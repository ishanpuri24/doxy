<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-data-table :headers="table.headers" :items="requested_signatures.all">
        <template v-slot:[`item.document_name`]="{ item }">
          {{
            item.user_document.variation.document_name
              ? item.user_document.variation.document_name
              : item.user_document.variation.document.name
          }}
        </template>

        <template v-slot:[`item.actions`]="{ item }">
          <v-btn
            small
            elevation="0"
            color="primary"
            :disabled="item.is_signed"
            @click="sign_document(item)"
          >
            Sign
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template> 

<script>
export default {
  name: "DashboardItemRequestedSignatures",

  props: {
    user: {
      required: true,
      type: Object,
    },
  },

  data() {
    return {
      requested_signatures: {
        api_url: "/api/signature-request/user",
        all: [],
      },
      table: {
        headers: [
          { text: "Document Name", value: "document_name" },
          { text: "Requested By", value: "requested_by.name" },
          { text: "Actions", value: "actions" },
        ],
      },
      pdf: {
        api_url: "/api/user-document/pdf",
      },
    };
  },

  async mounted() {
    await this.get_requested_signatures();
  },

  methods: {
    async get_requested_signatures() {
      const url = `${this.requested_signatures.api_url}/${this.user.id}`;
      this.requested_signatures.all = await this.get_data(url);
    },

    async get_data(url) {
      const res = await fetch(url);
      return await res.json();
    },

    async generate_preview(item) {
      console.log("download requested:", item);

      const body = {
        variation_id: item.user_document.document_variation_id,
        filled_data: item.user_document.filled_data,
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

    async sign_document(item) {
      const res = await fetch(this.requested_signatures.api_url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          signature_request_id: item.id,
        }),
      });

      if (res.status !== 200) {
        this.$emit("notification", {
          message: "Failed to sign document",
          color: "red",
        });
      }

      if (res.status === 200) {
        this.$emit("notification", {
          message: "Document Signed Successfully",
          color: "primary",
        });
      }

      await this.get_requested_signatures();
    },
  },
};
</script>