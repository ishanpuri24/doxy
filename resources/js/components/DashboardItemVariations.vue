<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-card-title>
        <v-btn color="primary" @click="redirect('/create-document-template')">
          <v-icon left> add </v-icon>
          Add New
        </v-btn>
      </v-card-title>
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="table.headers"
        :items="variations.all"
        :search="search"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <!-- <v-btn icon color="primary">
            <v-icon small @click="edit_item(item)"> edit </v-icon>
          </v-btn> -->

          <v-btn icon color="red" dark @click="delete_item(item)">
            <v-icon small> delete </v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-card>

    <v-snackbar v-model="snackbar.is_open" :timeout="snackbar.timeout">
      {{ snackbar.text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="snackbar.is_open = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script>
export default {
  name: "Dashboard_Item__Variation",

  data() {
    return {
      search: "",

      variations: {
        api_url: "/api/document/variations",
        all: [],
      },

      documents: {
        api_url: "/api/document",
        all: [],
        names: [],
      },

      snackbar: {
        is_open: false,
        text: null,
        timeout: 4000,
      },

      table: {
        headers: [
          { text: "Document", value: "document.name" },
          { text: "State", value: "state" },
          { text: "Actions", value: "actions" },
        ],
      },
    };
  },

  mounted() {
    this.get_all_document_variations(this.variations.api_url);
  },

  methods: {
    async get_all_document_variations(url) {
      const res = await fetch(url);
      this.variations.all = await res.json();
      this.format_variations_state();
    },

    /**
     *  null state means that the document has only
     *  a general variation
     */
    format_variations_state() {
      const variations = [...this.variations.all];

      this.variations.all = variations.map((variation) => {
        if (!variation.state) variation.state = "General";
        return variation;
      });
    },

    async get_all_documents(url) {
      if (this.documents.all.length > 0) return;

      const res = await fetch(url);
      this.documents.all = await res.json();
      this.documents.names = this.documents.all.map(
        (document) => document.name
      );
    },

    add_document_variation() {
      const document = this.documents.all.find((document) => {
        if (document.name === this.dialog.fields.document_name) {
          return document;
        }
      });
      const state = this.dialog.fields.state;

      const payload = { document_id: document.id, state };
      console.log(payload);

      this.notify({
        color: "blue",
        message: "Document variation created successfully",
      });
      this.dialog.is_open = false;
    },

    edit_item(item) {
      console.log("Editing Item", item);
    },

    async delete_item(item) {
      const body = JSON.stringify({
        document_variation_id: item.id,
      });

      const res = await fetch(this.variations.api_url, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body,
      });

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to delete document variation",
        });
      }

      if (res.status === 200) {
        this.notify({
          color: "primary",
          message: "Document Variation deleted successfully",
        });

        const del_index = this.variations.all.indexOf(item);
        this.variations.all.splice(del_index, 1);
      }
    },

    notify(data) {
      this.$emit("notification", data);
    },

    redirect(url) {
      this.$emit("redirect", url);
    },
  },
};
</script>
