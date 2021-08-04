<template>
  <v-dialog v-model="dialog.is_open" persistent max-width="400px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on">
        <v-icon left> add </v-icon>
        Share Document
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">Share Document</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-select
                label="Document*"
                v-model="selected.user_document_id"
                :items="documents"
                item-text="variation.document.name"
                item-value="id"
                required
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-select
                label="Contact*"
                multiple
                v-model="selected.contacts"
                :items="contacts"
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
        <v-btn
          color="blue darken-1"
          text
          @click="save_record()"
          :disabled="
            selected.user_document_id == null || selected.contacts.length == 0
          "
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template> 

<script>
export default {
  name: "ShareDocumentDialog",

  props: {
    contacts: {
      required: true,
      type: Array,
    },

    documents: {
      required: true,
      type: Array,
    },
  },

  data() {
    return {
      dialog: {
        is_open: false,
      },

      initial_selection: {},

      selected: {
        user_document_id: null,
        contacts: [],
      },
    };
  },

  mounted() {
    this.initial_selection = { ...this.selected };
  },

  methods: {
    close_dialog() {
      this.selected = { ...this.initial_selection };
      this.dialog.is_open = false;
    },

    save_record() {
      this.$emit("data", this.selected);
      this.close_dialog();
    },
  },
};
</script>