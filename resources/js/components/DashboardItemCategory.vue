<template>
  <v-container fluid class="p-4 mt-3">
    <v-card>
      <v-card-title>
        <v-dialog v-model="dialog.is_open" persistent max-width="400px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              v-bind="attrs"
              v-on="on"
              @click="get_all_document_categories(categories.api_url)"
            >
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
                      v-model="form.edit_item_values.category_name"
                      hide-details="auto"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                      label="Parent Category*"
                      v-model="form.edit_item_values.parent_category_name"
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

      <v-dialog v-model="delete_dialog.is_open" persistent max-width="290">
        <v-card>
          <v-card-title class="headline"> Delete Category? </v-card-title>
          <v-card-text
            >Are you sure you want to delete the category? Deletion is permanent
            and changes cannot be recovered.</v-card-text
          >
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green darken-1"
              text
              @click="close_delete_dialog()"
            >
              Disagree
            </v-btn>
            <v-btn color="green darken-1" text @click="delete_item()">
              Agree
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-data-table
        :headers="table.headers"
        :items="categories.all"
        :search="search"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn icon color="primary" @click="edit_item(item)">
            <v-icon small> edit </v-icon>
          </v-btn>

          <v-btn icon color="red" dark @click="open_delete_dialog(item)">
            <v-icon small> delete </v-icon>
          </v-btn>
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
      return this.form.edit_index === -1 ? "Add Category" : "Edit Category";
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
        item: {
          index: null,
          id: null,
        },
      },

      form: {
        edit_index: -1, // -1 means new item
        default_values: {
          category_id: null,
          category_name: "",
          parent_category_name: null,
        },
        edit_item_values: {
          category_id: null,
          category_name: "",
          parent_category_name: null,
        },
      },

      categories: {
        api_url: "/api/document/category",
        all: [],
        names: [],
      },

      table: {
        headers: [
          { text: "Name", value: "name" },
          { text: "Parent Category", value: "parent_category_name" },
          { text: "Actions", value: "actions" },
        ],
      },
    };
  },

  mounted() {
    this.get_all_document_categories(this.categories.api_url);
  },

  methods: {
    async get_all_document_categories(url) {
      const res = await fetch(url);
      const all_categories = await res.json();
      this.categories.names = ["None"].concat(
        all_categories.map((category) => category.name)
      );

      this.categories.all = all_categories.map((category) => {
        return Object.assign(category, {
          parent_category_name: this.find_category_name_by_id(
            all_categories,
            category.parent_category_id
          ),
        });
      });
    },

    discard() {
      this.dialog.is_open = false;
      this.reset_form();
    },

    save() {
      if (this.form.edit_index === -1) {
        this.add_new_category();
        return;
      }

      if (this.form.edit_index > -1) {
        this.edit_category();
        return;
      }
    },

    async add_new_category() {
      const parent_category = this.categories.all.find((category) => {
        return (
          category.name === this.form.edit_item_values.parent_category_name
        );
      });
      const name = this.form.edit_item_values.category_name;

      const payload = {
        name,
        parent_category_id: parent_category ? parent_category.id : 0,
      };

      const res = await fetch(this.categories.api_url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      const category_id = await res.json();

      if (res.status === 200) {
        this.categories.all.push({
          id: category_id.category_id,
          name: payload.name,
          parent_category_name: this.find_category_name_by_id(
            this.categories.all,
            payload.parent_category_id
          ),
        });

        this.notify({
          color: "blue",
          message: "Document Category created successfully",
        });
        this.dialog.is_open = false;
        return;
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to create document category",
        });
      }
    },

    async edit_category() {
      const parent_category = this.categories.all.find((category) => {
        return (
          category.name === this.form.edit_item_values.parent_category_name
        );
      });

      const payload = {
        document_category_id: this.form.edit_item_values.category_id,
        name: this.form.edit_item_values.category_name,
        parent_category_id: parent_category ? parent_category.id : 0,
      };

      const res = await fetch(this.categories.api_url, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      if (res.status === 200) {
        this.categories.all.forEach((category) => {
          if (category.id === payload.document_category_id) {
            category.name = payload.name;
            category.parent_category_id = payload.parent_category_id;
            category.parent_category_name = this.find_category_name_by_id(
              this.categories.all,
              payload.parent_category_id
            );
          }

          return category;
        });

        this.dialog.is_open = false;
        this.reset_form();
        this.notify({
          color: "blue",
          message: "Category Updated successfully",
        });
      }
    },

    find_category_name_by_id(categories, id) {
      const result = categories.find((category) => category.id == id);
      return result ? result.name : "-";
    },

    notify(data) {
      this.$emit("notification", data);
    },

    edit_item(item) {
      this.form.edit_index = this.categories.all.indexOf(item);
      this.form.edit_item_values = {
        category_id: item.id,
        category_name: item.name,
        parent_category_name:
          item.parent_category_name === "-"
            ? "None"
            : item.parent_category_name,
      };
      this.dialog.is_open = true;
    },

    open_delete_dialog(item) {
      this.delete_dialog.is_open = true;
      this.delete_dialog.item.index = this.categories.all.indexOf(item);
      this.delete_dialog.item.id = item.id;
    },

    close_delete_dialog() {
      this.delete_dialog.is_open = false;
      this.delete_dialog.item = Object.assign(
        {},
        {
          index: null,
          id: null,
        }
      );
    },

    async delete_item() {
      const del_id = this.delete_dialog.item.id;
      const del_index = this.delete_dialog.item.index;

      const payload = {
        document_category_id: del_id,
      };

      const res = await fetch(this.categories.api_url, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      if (res.status === 200) {
        if (del_index > -1) {
          this.categories.all.splice(del_index, 1);
        }

        this.notify({
          color: "blue",
          message: "Document category deleted successfully",
        });
        this.delete_dialog.is_open = false;
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to Delete the document category",
        });
      }
    },

    reset_form() {
      this.form.edit_item_values = { ...this.form.default_values };
      this.form.edit_index = -1;
    },
  },
};
</script>
