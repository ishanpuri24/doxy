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
        v-model="table.selected"
        :headers="table.headers"
        :items="signatories"
        :single-select="table.single_select"
        :search="table.search"
        item-key="name"
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
  name: "SignatoriesPositionTable",

  props: {
    signatories: {
      required: true,
      type: Array,
    },
  },

  data() {
    return {
      table: {
        search: null,
        selected: [],
        single_select: true,
        headers: [
          {
            text: "Signatory",
            value: "name",
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

  watch: {
    "table.selected": {
      handler: function (new_value) {
        this.$emit("update_selection", new_value);
      },
    },
  },

  methods: {
    is_done(item) {
      return item.positions.length > 0;
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