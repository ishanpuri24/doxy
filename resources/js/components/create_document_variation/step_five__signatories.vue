 <template>
  <div>
    <v-toolbar flat>

      <v-btn depressed @click="previous_screen()">
        <v-icon left> arrow_back </v-icon>
        Back
      </v-btn>

      <v-spacer></v-spacer>

      <v-btn
        depressed
        @click="save_and_proceed()"
        :disabled="filled_data.signatories.length == 0"
      >
        Next
        <v-icon right> arrow_forward </v-icon>
      </v-btn>
    </v-toolbar>

    <v-container fluid>
      <v-row>
        <v-col cols="12">
          <add-document-signatories
            @notification="notify"
            @update_signatory="update_signatories"
          ></add-document-signatories>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import AddDocumentSignatories from "./step_five__signatories__add_edit.vue";

export default {
  name: "StepFive",

  components: {
    AddDocumentSignatories,
  },

  props: {},

  data() {
    return {
      filled_data: {
        signatories: [],
      },
    };
  },

  methods: {
    next_screen() {
      this.$emit("next_screen");
    },

    previous_screen() {
      this.$emit("previous_screen");
    },

    notify(data) {
      this.$emit("notification", data);
    },

    save_and_proceed() {
      this.$emit("data", this.filled_data.signatories);
      this.next_screen();
    },

    update_signatories(signatories) {
      this.filled_data.signatories = [...signatories];
    },
  },
};
</script>