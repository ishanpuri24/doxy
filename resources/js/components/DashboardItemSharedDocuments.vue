<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-card-title>
        <p class="w-100">Shared by me</p>
        <share-document-dialog
          :contacts="user_contacts.all"
          :documents="user_documents.all"
          @data="populate_new_share_dialog_data"
        ></share-document-dialog>
      </v-card-title>
      <v-data-table
        :headers="shared_with_others.headers"
        :items="shared_with_others.all"
      >
        <template v-slot:[`item.name`]="{ item }">
          {{
            item.variation.document_name
              ? item.variation.document_name
              : item.variation.document.name
          }}
        </template>
      </v-data-table>
    </v-card>

    <v-card class="mt-5">
      <v-card-title> Shared with me </v-card-title>
      <v-data-table
        :headers="shared_with_me.headers"
        :items="shared_with_me.all"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn icon @click="download_document(item)">
            <v-icon small> file_download </v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script>
import ShareDocumentDialog from "./share_document/share_document__dialog.vue";

export default {
  name: "DashboardItemSharedDocuments",

  components: {
    ShareDocumentDialog,
  },

  props: {
    user: {
      required: true,
      type: Object,
    },
  },

  data() {
    return {
      shared_with_me: {
        api_url: "/api/shared-documents",
        all: [],
        headers: [
          { text: "Name", value: "name" },
          { text: "Download", value: "actions" },
        ],
      },

      shared_with_others: {
        api_url: "/api/shared-documents/user",
        all: [],
        headers: [{ text: "Name", value: "name" }],
      },

      user_contacts: {
        api_url: "/api/user-contacts",
        all: [],
      },

      user_documents: {
        api_url: "/api/user-document",
        all: [],
      },

      share_document: {
        api_url: "/api/shared-documents/user/",
      },

      pdf: {
        api_url: "/api/user-document/pdf",
      },
    };
  },

  async mounted() {
    let url = `${this.shared_with_me.api_url}/${this.user.id}`;
    const shared_with_me_all = await this.get_data(url);
    this.shared_with_me.all = this.format_document_names(shared_with_me_all);

    url = `${this.user_contacts.api_url}/${this.user.id}`;
    this.user_contacts.all = await this.get_data(url);

    url = `${this.shared_with_others.api_url}/${this.user.id}`;
    this.shared_with_others.all = await this.get_data(url);

    url = `${this.user_documents.api_url}/${this.user.id}`;
    this.user_documents.all = await this.get_data(url);
  },

  methods: {
    async get_data(url) {
      const res = await fetch(url).catch((err) => console.error(err));
      return await res.json();
    },

    format_document_names(all_documents) {
      return all_documents.map((document) => {
        document.name = document.variation.document_name
          ? document.variation.document_name
          : document.variation.document.name;

        return document;
      });
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

    async populate_new_share_dialog_data(payload) {
      const res = await fetch(this.share_document.api_url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          user_document_id: payload.user_document_id,
          shared_with: payload.contacts,
        }),
      }).catch((err) => console.error(err));

      if (res.status !== 200) {
        console.warn("Invalid status code:", res.status);
        return;
      }

      const url = `${this.shared_with_others.api_url}/${this.user.id}`;
      this.shared_with_others.all = await this.get_data(url);
    },
  },
};
</script>