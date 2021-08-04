<template>
  <div>
    <v-dialog v-model="dialog.is_open" persistent max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn depressed v-bind="attrs" v-on="on" class="mr-1">
          <v-icon left> add </v-icon>
          Add Document Signatory
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">{{
            dialog.is_edit
              ? "Edit Document Signatory"
              : "Add Document Signatory"
          }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Name*"
                  v-model="form.name"
                  hide-details="auto"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog__close()">
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            :disabled="form__save_disable()"
            @click="form__save()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- table search field -->
    <v-card-title>
      <v-text-field
        v-model="table.search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>

    <!-- signatories table -->
    <v-data-table
      :headers="table.headers"
      :items="filled_data.signatories"
      :search="table.search"
    >
      <template v-slot:[`item.actions`]="{ item }">
        <v-btn icon color="primary" @click="edit_item(item)">
          <v-icon small> edit </v-icon>
        </v-btn>
        <v-btn icon color="red" dark @click="delete_item(item)">
          <v-icon small> delete </v-icon>
        </v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  name: "AddDocumentSignatories",

  data: () => {
    return {
      dialog: {
        is_open: false,
        is_edit: false,
        edit_index: null,
      },

      form: {
        name: null,
      },

      filled_data: {
        signatories: [],
      },

      table: {
        search: null,
        headers: [
          { text: "Signatory Name", value: "name" },
          { text: "Actions", value: "actions" },
        ],
      },
    };
  },

  watch: {
    "filled_data.signatories": {
      handler: function (new_value) {
        this.$emit("update_signatory", new_value);
      },
      deep: true,
    },
  },

  methods: {
    dialog__open() {
      this.dialog.is_open = true;
    },

    dialog__close() {
      this.dialog.is_open = false;
      this.dialog.is_edit = false;
      this.dialog.edit_index = null;

      this.form__reset();
    },

    form__reset() {
      this.form.name = null;
    },

    form__save() {
      const signatory = {
        name: this.form.name,
        positions: [],
      };

      if (!this.dialog.is_edit) this.handle_new(signatory);
      if (this.dialog.is_edit)
        this.handle_edit(this.dialog.edit_index, signatory);
    },

    form__save_disable() {
      return !this.form.name;
    },

    handle_new(signatory) {
      this.filled_data.signatories.push(signatory);
      this.dialog__close();
      this.notify({
        color: "primary",
        message: "New Document Signatory Added",
      });
    },

    handle_edit(index, signatory) {
      this.filled_data.signatories[index].name = signatory.name;
      this.dialog__close();
      this.notify({
        color: "primary",
        message: "Document Signatory Edited",
      });
    },

    find_item_index(item) {
      const length = this.filled_data.signatories.length;

      for (let i = 0; i < length; i++) {
        if (this.filled_data.signatories[i].name === item.name) return i;
      }
    },

    edit_item(item) {
      // find edit item index
      this.dialog.is_edit = true;
      this.dialog.edit_index = this.find_item_index(item);

      // populate edit item data
      this.form.name = item.name;

      // open the dialog
      this.dialog__open();
    },

    delete_item(item) {
      const del_index = this.filled_data.signatories.indexOf(item);
      this.filled_data.signatories.splice(del_index, 1);

      this.notify({
        color: "red",
        message: "Signatory Deleted Successfully",
      });
    },

    notify(data) {
      this.$emit("notification", data);
    },
  },
};
</script>
