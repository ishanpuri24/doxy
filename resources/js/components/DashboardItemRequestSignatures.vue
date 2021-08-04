<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-card-title>
        <v-dialog v-model="dialog.is_open" persistent max-width="400px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" v-bind="attrs" v-on="on">
              <v-icon left> add </v-icon>
              Add New
            </v-btn>

            <v-btn depressed class="ml-2" @click="redirect('/my-contacts')">
              <v-icon left> perm_contact_calendar </v-icon>
              Contacts
            </v-btn>            
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">Request Signatures</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-select
                      label="User Documents"
                      v-model="form.user_document_id"
                      :items="user_documents.all"
                      item-text="variation.document.name"
                      item-value="id"
                      required
                    ></v-select>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                      label="Contact"
                      v-model="form.contact_id"
                      :items="contacts.all"
                      item-text="contact_name"
                      item-value="id"
                      required
                    ></v-select>
                  </v-col>
                </v-row>
              </v-container>
              <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close_dialog()">
                Close
              </v-btn>
              <v-btn color="blue darken-1" text @click="save()"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-card-title>
      <v-data-table :headers="table.headers" :items="signature_requests.all">
        <template v-slot:[`item.document_name`]="{ item }">
          {{ find_user_document_name_by_id(item.user_document_id) }}
        </template>

        <template v-slot:[`item.contact_name`]="{ item }">
          {{ find_contact_name_by_id(item.user_contacts_id) }}
        </template>

        <template v-slot:[`item.status`]="{ item }">
          {{ item.is_signed ? "Yes" : "No" }}
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template> 

<script>
export default {
  name: "DashboardItemRequestSignatures",

  props: {
    user: {
      required: true,
      type: Object,
    },
  },

  data() {
    return {
      dialog: {
        is_open: false,
      },
      form: {
        user_document_id: null,
        contact_id: null,
      },
      user_documents: {
        api_url: "/api/user-document",
        all: [],
      },
      contacts: {
        api_url: "/api/user-contacts",
        all: [],
      },
      signature_requests: {
        api_url: "/api/signature-request",
        all: [],
      },
      table: {
        headers: [
          { text: "Document Name", value: "document_name" },
          { text: "Contact", value: "contact_name" },
          { text: "Is Signed?", value: "status" },
        ],
      },
    };
  },

  async mounted() {
    let url = `${this.contacts.api_url}/${this.user.id}`;
    this.contacts.all = await this.get_data(url);

    url = `${this.user_documents.api_url}/${this.user.id}`;
    this.user_documents.all = await this.get_data(url);

    url = `${this.signature_requests.api_url}/${this.user.id}`;
    this.signature_requests.all = await this.get_data(url);
  },

  methods: {
    redirect(url) {
      window.open(url, "_blank").focus();
    },

    save() {
      this.store_signature_request(this.signature_requests.api_url);
      this.close_dialog();
    },

    close_dialog() {
      this.form.user_document_id = null;
      this.form.contact_id = null;

      this.dialog.is_open = false;
    },

    async store_signature_request(url) {
      const res = await fetch(url, {
        method: "POST",
        headers: {
          ContentType: "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          user_id: this.user.id,
          user_document_id: this.form.user_document_id,
          user_contacts_id: this.form.contact_id,
        }),
      });

      if (res.status !== 200) {
        this.$emit("notification", {
          message: "Failed to send document for signatures",
          color: "red",
        });

        throw new Error("Failed to save signature request");
      }

      this.$emit("notification", {
        message: "Document successfully sent for signatures",
        color: "primary",
      });

      url = `${this.signature_requests.api_url}/${this.user.id}`;
      this.signature_requests.all = await this.get_data(url);
    },

    async get_data(url) {
      const res = await fetch(url).catch((err) => console.error(err));
      return await res.json();
    },

    find_contact_name_by_id(id) {
      const found = this.contacts.all.find((contact) => contact.id === id);
      return found.contact_name;
    },

    find_user_document_name_by_id(id) {
      const found = this.user_documents.all.find((document) => document.id);

      return found.variation.document_name
        ? found.variation.document_name
        : found.variation.document.name;
    },
  },
};
</script>