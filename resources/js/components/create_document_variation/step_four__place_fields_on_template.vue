<template>
  <v-row>
    <v-col cols="12" md="6">
      <div class="d-flex">
        <v-btn depressed class="ml-4 mt-5 mr-auto" @click="previous_screen()">
          <v-icon left> arrow_back </v-icon>
          Back
        </v-btn>

        <v-btn depressed class="ml-auto mt-5" @click="save_and_proceed()">
          Next
          <v-icon right> arrow_forward </v-icon>
        </v-btn>
      </div>
      <field-table
        :hierarchy="current_hierarchy"
        @update_selection="get_field_placement_selected"
      ></field-table>
    </v-col>
    <v-col cols="12" md="6">
      <placement-pdf-preview
        :hierarchy="current_hierarchy"
        :pages="pages"
        :selected_field_position="selected_field_for_placement"
        @updated_hierarchy="set_updated_hierarchy"
      ></placement-pdf-preview>
    </v-col>
  </v-row>
</template>

<script>
import FieldTable from "./step_four__place_fields_on_template__field_table.vue";
import PlacementPdfPreview from "./step_four__place_fields_on_template__placement_pdf_preview.vue";

export default {
  name: "StepFour",

  components: {
    FieldTable,
    PlacementPdfPreview,
  },

  props: {
    hierarchy: {
      required: true,
      type: Array,
    },
    pages: {
      required: true,
      type: Array,
    },
  },

  mounted() {
    this.current_hierarchy = [...this.hierarchy];
  },

  data() {
    return {
      selected_field_for_placement: null,
      current_hierarchy: [],
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
      this.$emit("data", this.current_hierarchy);
      this.next_screen();
    },

    async set_updated_hierarchy(field_data) {
      await this.update_field_heirarchy(field_data);
    },

    async update_field_heirarchy(field_data) {
      const group_index = field_data.selected.group_index;
      const field_index = field_data.selected.field_index;

      this.current_hierarchy = this.current_hierarchy.map((group, g_index) => {
        if (g_index === group_index) {
          group.fields = group.fields.map((field, f_index) => {
            if (f_index === field_index) {
              field = { ...field_data.field };
            }

            return field;
          });
        }

        return group;
      });
    },

    /**
     *  when fields are to be placed on the document template,
     *  field-hierarchy emits an event with the selected field
     *  we need to pass this to the pdf-field-map component
     */
    get_field_placement_selected(field_position) {
      this.selected_field_for_placement = field_position
        ? field_position
        : null;
    },
  },
};
</script>