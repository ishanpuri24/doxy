<template>
  <v-row>
    <v-col cols="12" md="6">
      <div class="d-flex">
        <v-btn depressed class="ml-4 mt-5 mr-auto" @click="previous_screen()">
          <v-icon left> arrow_back </v-icon>
          Back
        </v-btn>
      </div>

      <!-- signatories table -->
      <signatories-position-table
        :signatories="signatories"
        @update_selection="set_signatory_selection"
      >
      </signatories-position-table>
      <!-- signatories table end -->
    </v-col>
    <v-col cols="12" md="6">
      <!-- pdf preview start -->
      <signatories-positions-preview
        :pages="pages"
        :selected_signatory="selected_signatory"
        @position_selected="set_signatory_signature_position"
      >
      </signatories-positions-preview>
      <!-- pdf preview end -->
    </v-col>
  </v-row>
</template>

<script>
import SignatoriesPositionTable from "./step_six__signature_positions__table.vue";
import SignatoriesPositionsPreview from "./step_six__signature_positions__pdf_preview.vue";

export default {
  name: "StepSix",

  components: {
    SignatoriesPositionTable,
    SignatoriesPositionsPreview,
  },

  props: {
    signatories: {
      required: true,
      type: Array,
    },
    pages: {
      required: true,
      type: Array,
    },
  },

  data() {
    return {
      selected_signatory_raw: [],
      selected_signatory: null,
    };
  },

  watch: {
    selected_signatory_raw: {
      handler(newValue) {
        this.selected_signatory = newValue[0] ? newValue[0] : null;
      },
      deep: true,
    }
  },

  methods: {
    previous_screen() {
      this.$emit("previous_screen");
    },

    notify(data) {
      this.$emit("notification", data);
    },

    // single select is enabled therefore an array
    set_signatory_selection(signatory) {
      this.selected_signatory_raw = {...signatory};
    },

    set_signatory_signature_position(position_data) {
      const signatories = this.signatories.map((signatory) => {
        if (signatory.name === position_data.signatory.name) {
          signatory.positions = [...position_data.signatory.positions];
        }

        return signatory;
      });

      this.save([...signatories]);
      this.notify({
        error: false,
        message: "Signature position set successfully",
      });
    },

    save(signatories) {
      this.$emit("data", signatories);
    },
  },
};
</script>