<template>
  <div class="ml-5 mt-5">
    <v-card class="fixed-height">
      <v-card-title>
        <v-text-field
          v-model="table.search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        v-model="selected"
        :headers="table.headers"
        :items="organized_hierarchy"
        :single-select="table.single_select"
        :search="table.search"
        item-key="index"
        show-select
      >
        <template v-slot:[`item.status`]="{ item }">
          <v-icon v-if="is_done(item)" small color="primary"> done_all </v-icon>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template> 

<script>
export default {
  name: "FieldTable",
  props: {
    hierarchy: {
      required: true,
      type: Array,
    },
  },

  watch: {
    selected(newVal) {
      const payload = !newVal[0]
        ? null
        : {
            group_index: newVal[0].group_index,
            field_index: newVal[0].field_index,
            table_index: this.get_selected_field_index(newVal[0]), 
          };

      this.$emit("update_selection", payload);
    },

    hierarchy: {
      handler(new_value) {
        this.organized_hierarchy = this.process_hierarchy(new_value);
      },
      deep: true,
    },
  },

  mounted() {
    this.organized_hierarchy = this.process_hierarchy(this.hierarchy);
  },

  data: () => {
    return {
      organized_hierarchy: [],
      selected: [],

      table: {
        search: null,
        single_select: true,

        headers: [
          {
            text: "#",
            value: "index",
          },
          {
            text: "Field Group",
            value: "group_name",
          },
          {
            text: "Field Question",
            value: "field_name",
          },
          {
            text: "Input Type",
            value: "input_type",
          },
          {
            text: "Status",
            value: "status",
            sortable: false,
          },
        ],
      },
    };
  },

  methods: {
    process_hierarchy(hierarchy) {
      const organized = [];
      let index = 0;

      hierarchy.forEach((group, g_index) => {
        group.fields.forEach((field, f_index) => {
          organized.push({
            index: ++index,
            group_index: g_index,
            field_index: f_index,
            group_name: group.group_name,
            field_name: field.field_name,
            input_type: field.input_type,
            position_count: field.positions.length,
          });
        });
      });

      return [...organized];
    },

    get_selected_field_index(selected_field) {
      const found = this.organized_hierarchy.find((item) => {
        return (
          item.group_index === selected_field.group_index &&
          item.field_index === selected_field.field_index
        );
      });

      if (!found) {
        throw new Error('Selected field not found in organized_hierarchy');
      }

      return found.index;
    },

    is_done(item) {
      return item.position_count > 0;
    },
  },
};
</script>

<style scoped>
.fixed-height {
  height: 63vh;
  overflow-y: scroll;
}
</style>