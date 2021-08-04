<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="5">
        <div>
          <v-card-title>Document Name</v-card-title>
          <v-card-text>Please enter a name for this document </v-card-text>

          <div class="p-3">
            <v-text-field
              label="Name*"
              v-model="filled_data.document_name"
              hide-details="auto"
            ></v-text-field>

            <v-btn
              color="primary"
              class="mr-4 mt-5"
              @click="next_screen()"
              :disabled="filled_data.document_name === null"
            >
              Next
              <v-icon right dark> arrow_forward </v-icon>
            </v-btn>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "StepOne",

  data() {
    return {
      filled_data: {
        document_name: null,
      },
    };
  },

  methods: {
    next_screen() {
      this.$emit("data", this.filled_data);
      this.$emit("next_screen");
    },
  },
};
</script>
