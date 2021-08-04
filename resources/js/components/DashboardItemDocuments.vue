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
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ form_title }}</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Name*"
                      v-model="form.edit_item_values.document_name"
                      hide-details="auto"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                      label="Category*"
                      v-model="form.edit_item_values.document_category_name"
                      :items="categories.names"
                      required
                    ></v-select>
                  </v-col>
                </v-row>
              </v-container>
              <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="discard()">
                Close
              </v-btn>
              <v-btn color="blue darken-1" text @click="save()"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
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
          <v-btn icon color="primary" @click="edit_item(item)">
            <v-icon small> edit </v-icon>
          </v-btn>

          <v-dialog v-model="delete_dialog.is_open" persistent max-width="290">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon color="red" dark v-bind="attrs" v-on="on">
                <v-icon small> delete </v-icon>
              </v-btn>
            </template>
            <v-card>
              <v-card-title class="headline"> Delete Category? </v-card-title>
              <v-card-text
                >Are you sure you want to delete the category? Deletion is
                permanent and changes cannot be recovered.</v-card-text
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="green darken-1"
                  text
                  @click="delete_dialog.is_open = false"
                >
                  Disagree
                </v-btn>
                <v-btn color="green darken-1" text @click="delete_item(item)">
                  Agree
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "Dashboard_Item__Documents",

  computed: {
    form_title() {
      return this.form.edit_index === -1 ? "Add Document" : "Edit Document";
    },
  },

  data() {
    return {
      search: "",

      dialog: {
        is_open: false,
      },

      delete_dialog: {
        is_open: false,
      },

      form: {
        edit_index: -1, // -1 means new item
        default_values: {
          document_id: null,
          document_name: "",
          document_category_name: null,
        },
        edit_item_values: {
          document_id: null,
          document_name: "",
          document_category_name: null,
        },
      },

      documents: {
        api_url: "/api/document",
        all: [],
      },

      categories: {
        api_url: "/api/document/category",
        all: [],
        names: [],
      },

      table: {
        headers: [
          { text: "Name", value: "name" },
          { text: "Category", value: "document_category_name" },
          { text: "Actions", value: "actions" },
        ],
      },
    };
  },

  mounted() {
    this.get_page_data();
  },

  methods: {
    async get_page_data() {
      await this.get_all_document_categories(this.categories.api_url);
      await this.get_all_documents(this.documents.api_url);
    },

    async get_all_document_categories(url) {
      const res = await fetch(url, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
      });

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message:
            "Failed to contact the server. Please check your internet connection",
        });
        console.log("Res Status ::", res.status);
        return;
      }

      this.categories.all = await res.json();
      this.categories.names = ["None"].concat(
        this.categories.all.map((category) => category.name)
      );
    },

    async get_all_documents(url) {
      const res = await fetch(url);
      const all_documents = await res.json();

      this.documents.all = all_documents.map((document) => {
        return Object.assign(document, {
          document_category_name: this.find_category_name_by_id(
            this.categories.all,
            document.document_category_id
          ),
        });
      });
    },

    discard() {
      this.reset_form();
      this.dialog.is_open = false;
    },

    save() {
      console.log("edit index ::", this.form.edit_index);

      if (this.form.edit_index === -1) {
        this.add_new_document(this.documents.api_url);
        return;
      }

      if (this.form.edit_index > -1) {
        this.edit_document(this.documents.api_url);
        return;
      }
    },

    async add_new_document(url) {
      const category = this.categories.all.find((category) => {
        return (
          category.name === this.form.edit_item_values.document_category_name
        );
      });
      const name = this.form.edit_item_values.document_name;

      const payload = {
        name,
        document_category_id: category ? category.id : 0,
      };

      const res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      const document_id = await res.json();

      if (res.status === 200) {
        this.documents.all.push({
          id: document_id.document_id,
          name: payload.name,
          document_category_name: this.find_category_name_by_id(
            this.categories.all,
            payload.document_category_id
          ),
        });

        this.notify({
          color: "blue",
          message: "Document created successfully",
        });
        this.dialog.is_open = false;
        return;
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to create document",
        });
      }

      this.reset_form();
    },

    reset_form() {
      this.form.edit_item_values = { ...this.form.default_values };
      this.form.edit_index = -1;
    },

    async edit_document(url) {
      const category = this.categories.all.find((category) => {
        return (
          category.name === this.form.edit_item_values.document_category_name
        );
      });

      const payload = {
        id: this.form.edit_item_values.document_id,
        name: this.form.edit_item_values.document_name,
        document_category_id: category ? category.id : 0,
      };

      const res = await fetch(url, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      if (res.status === 200) {
        this.documents.all.forEach((document) => {
          if (document.id === payload.id) {
            document.name = payload.name;
            document.document_category_id = payload.document_category_id;
            document.document_category_name = this.find_category_name_by_id(
              this.categories.all,
              payload.document_category_id
            );
          }

          return category;
        });

        this.dialog.is_open = false;
        this.reset_form();
        this.notify({
          color: "blue",
          message: "Document updated successfully",
        });
      }
    },

    find_category_name_by_id(categories, id) {
      const result = categories.find((category) => category.id === id);
      return result ? result.name : "-";
    },

    notify(message) {
      this.$emit("notification", message);
    },

    edit_item(item) {
      this.form.edit_index = this.documents.all.indexOf(item);
      this.form.edit_item_values = {
        document_id: item.id,
        document_name: item.name,
        document_category_name:
          item.document_category_name === "-"
            ? "None"
            : item.document_category_name,
      };
      this.dialog.is_open = true;
    },

    async delete_item(item) {
      const payload = {
        id: item.id,
      };

      const res = await fetch(this.documents.api_url, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      if (res.status === 200) {
        const delete_index = this.documents.all.indexOf(item);
        if (delete_index > -1) {
          this.documents.all.splice(delete_index, 1);
        }

        this.notify({
          color: "blue",
          message: "Document deleted successfully",
        });
        this.delete_dialog.is_open = false;
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to Delete the document",
        });
      }
    },
  },
};
</script>
