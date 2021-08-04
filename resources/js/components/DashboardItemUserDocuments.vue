<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-card-title>
        <v-btn color="primary" @click="redirect('/make-documents')">
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
          <v-btn icon @click="download_document(item)">
            <v-icon small> file_download </v-icon>
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
  name: "Dashboard_Item__User_Document",

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
        api_url: "/api/user-document",
        all: [],
      },

      pdf: {
        api_url: "/api/user-document/pdf",
      },

      snackbar: {
        is_open: false,
        text: null,
        timeout: 4000,
      },

      table: {
        headers: [
          { text: "Document", value: "variation.document.name" },
          { text: "Download", value: "actions" },
        ],
      },
    };
  },

  mounted() {
    this.get_all_documents(this.documents.api_url, this.user.id);
  },

  methods: {
    async get_all_documents(url, user_id) {
      if (this.documents.all.length > 0) return;

      const res = await fetch(`${url}/${user_id}`);
      this.documents.all = await res.json();
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

    async download_document(item) {
      console.log("download requested:", item);

      const body = {
        variation_id: item.document_variation_id,
        filled_data: item.filled_data,
      };

      const res = await fetch(this.pdf.api_url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/pdf",
        },
        body: JSON.stringify(body),
      });

      if (res.status !== 200) {
        console.error(`Invalid response from server. Status : ${res.status}`);
        return;
      }

      const pdf = await res.blob();
      const file = window.URL.createObjectURL(pdf);

      // open in new tab
      window.open(file, "_blank").focus();
    },
  },
};
</script>
