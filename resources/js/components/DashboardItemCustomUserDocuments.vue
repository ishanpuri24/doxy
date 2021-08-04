<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-card-title>
        <v-btn color="primary" @click="redirect('/custom-user-document/')">
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
        :items="documents.all"
        :search="search"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn icon @click="fill_document(item)">
            <v-icon small> play_arrow </v-icon>
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
  name: "Dashboard_Item__Custom_User_Documents",

  props: {
    user: {
      required: true,
      type: Object,
    },
  },

  data() {
    return {
      search: "",

      documents: {
        api_url: "/api/custom-user-documents",
        all: [],
      },

      fill_custom_document: {
        web_url: "/custom-document"
      },

      snackbar: {
        is_open: false,
        text: null,
        timeout: 4000,
      },

      table: {
        headers: [
          { text: "Document Name", value: "document_name" },
          { text: "Actions", value: "actions" },
        ],
      },
    };
  },

  async mounted() {
    this.documents.all = await this.get_all_documents(
      this.documents.api_url,
      this.user.id
    );
  },

  methods: {
    async get_all_documents(url, user_id) {
      if (this.documents.all.length > 0) return;

      const res = await fetch(`${url}/${user_id}`);
      return await res.json();
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

    notify(data) {
      this.$emit("notification", data);
    },

    redirect(url) {
      this.$emit("redirect", url);
    },

    fill_document(item) {
      const url = `${this.fill_custom_document.web_url}/${item.id}`;
      console.log(url);
      this.redirect(url);
    }
  },
};
</script>
