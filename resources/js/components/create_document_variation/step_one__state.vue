<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="5">
        <div>
          <v-card-title>Document Variation</v-card-title>
          <v-card-text
            >Legal documents may vary in format from State to State. Please
            select a USA State and Parent Document to continue.
          </v-card-text>

          <div class="p-3">
            <v-select
              v-model="filled_data.document_id"
              :items="documents"
              item-text="name"
              item-value="id"
              label="Document"
              required
            ></v-select>

            <v-select
              v-model="filled_data.state"
              :items="us_states"
              label="USA State"
              required
            ></v-select>

            <v-btn
              :disabled="
                filled_data.state == null || filled_data.document_id == null
              "
              color="primary"
              class="mr-4"
              @click="next_screen()"
            >
              Next
              <v-icon right dark> arrow_forward </v-icon>
            </v-btn>
          </div>

          <v-card-text>
            <p class="text--lighten-1">
              <b> * </b> <em>General</em> means that the document is same for
              all USA States.
            </p>
          </v-card-text>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "StepOne",
  props: {
    documents: {
      required: true,
      type: Array,
    },
  },

  data() {
    return {
      us_states: [
        "General",
        "Alabama",
        "Alaska",
        "Arizona",
        "Arkansas",
        "California",
        "Colorado",
        "Connecticut",
        "Delaware",
        "Florida",
        "Georgia",
        "Hawaii",
        "Idaho",
        "Illinois",
        "Indiana",
        "Iowa",
        "Kansas",
        "Kentucky",
        "Louisiana",
        "Maine",
        "Maryland",
        "Massachusetts",
        "Michigan",
        "Minnesota",
        "Mississippi",
        "Missouri",
        "Montana",
        "Nebraska",
        "Nevada",
        "New Hampshire",
        "New Jersey",
        "New Mexico",
        "New York",
        "North Carolina",
        "North Dakota",
        "Ohio",
        "Oklahoma",
        "Oregon",
        "Pennsylvania",
        "Rhode Island",
        "South Carolina",
        "South Dakota",
        "Tennessee",
        "Texas",
        "Utah",
        "Vermont",
        "Virginia",
        "Washington",
        "West Verginia",
        "Wisconsin",
        "Wyoming",
      ],

      filled_data: {
        document_id: null,
        state: null,
      }
    };
  },

  methods: {
    next_screen() {
      this.$emit("data", this.filled_data)
      this.$emit("next_screen");
    },
  }
};
</script>
