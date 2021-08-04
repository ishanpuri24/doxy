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
                    <v-select
                      label="Document*"
                      v-model="form.edit_item_values.document_id"
                      :items="documents.all"
                      item-text="name"
                      item-value="id"
                      required
                    ></v-select>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      label="Question*"
                      v-model="form.edit_item_values.question"
                      hide-details="auto"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      label="Answer*"
                      v-model="form.edit_item_values.answer"
                      hide-details="auto"
                    ></v-text-field>
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
      <v-card-title>
        <v-text-field
          v-model="form.search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>

      <v-dialog v-model="delete_dialog.is_open" persistent max-width="290">
        <v-card>
          <v-card-title class="headline"> Delete Question? </v-card-title>
          <v-card-text
            >Are you sure you want to delete the question? Deletion is permanent
            and changes cannot be recovered.</v-card-text
          >
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="close_delete_dialog()">
              Disagree
            </v-btn>
            <v-btn color="green darken-1" text @click="confirm_delete_item()">
              Agree
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-data-table
        :headers="table.headers"
        :items="questions_answers.all"
        :search="form.search"
      >
        <template v-slot:[`item.document`]="{ item }">
          <span>{{ find_document_name_by_id(item.document_id) }}</span>
        </template>

        <template v-slot:[`item.answer`]="{ item }">
          <span>{{ limit_characters(item.answer) }}</span>
        </template>

        <template v-slot:[`item.actions`]="{ item }">
          <v-btn icon color="primary" @click="edit_item(item)">
            <v-icon small> edit </v-icon>
          </v-btn>
          <v-btn icon color="red" dark @click="delete_item(item)">
            <v-icon small> delete </v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template> 

<script>
export default {
  name: "Dashboard_Item__QA",

  computed: {
    form_title() {
      return this.form.edit_index === -1 ? "Add Question" : "Edit Question";
    },
  },

  mounted() {
    this.form.default_values = { ...this.form.edit_item_values };
    this.get_page_data();
  },

  data() {
    return {
      dialog: {
        is_open: false,
      },

      delete_dialog: {
        is_open: false,
        delete_index: null,
        delete_id: null,
      },

      documents: {
        api_url: "/api/document",
        all: [],
      },

      questions_answers: {
        api_url: "/api/document/qa",
        all: [],
      },

      table: {
        headers: [
          { text: "Document", value: "document" },
          { text: "Question", value: "question" },
          { text: "Answer", value: "answer" },
          { text: "Actions", value: "actions" },
        ],
      },

      form: {
        search: null,
        edit_index: -1,
        default_values: {},
        edit_item_values: {
          document_id: null,
          question: null,
          answer: null,
        },
      },
    };
  },

  methods: {
    async get_page_data() {
      await this.get_all_documents(this.documents.api_url);
      await this.get_all_questions_answers(this.questions_answers.api_url);
    },

    async get_all_documents(url) {
      const res = await fetch(url);
      const all_documents = await res.json();
      this.documents.all = [...all_documents];
    },

    async get_all_questions_answers(url) {
      const res = await fetch(url);
      const all_questions = await res.json();

      this.questions_answers.all = [...all_questions];
    },

    find_document_name_by_id(id) {
      const result = this.documents.all.filter((document) => {
        return document.id === id;
      });

      return result[0].name;
    },

    limit_characters(text) {
      if (text.length < 30) return text;

      const substring = text.substr(0, 30);
      return substring + "...";
    },

    close_dialog() {
      this.dialog.is_open = false;
      this.form.edit_index = -1;
      this.form.edit_item_values = { ...this.form.default_values };
    },

    save() {
      if (this.form.edit_index === -1) {
        this.save__new();
      }

      if (this.form.edit_index !== -1) {
        this.save__edit();
      }
    },

    async save__new() {
      const edit_values = { ...this.form.edit_item_values };
      console.log("current values ::", edit_values);

      await this.send_new_item_request(
        this.questions_answers.api_url,
        edit_values
      );
    },

    async save__edit() {
      const edit_values = { ...this.form.edit_item_values };
      await this.send_edit_item_request(
        this.questions_answers.api_url,
        edit_values
      );
    },

    async send_new_item_request(url, data) {
      const res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(data),
      });

      if (res.status === 200) {
        const question_id = await res.json();

        data.id = question_id.question_answer_id;
        this.questions_answers.all = [...this.questions_answers.all, data];

        this.close_dialog();
        this.notify({
          color: "primary",
          message: "Question added successfully",
        });
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to add question to document",
        });
      }

      console.log("all items :", this.questions_answers.all);
    },

    async send_edit_item_request(url, data) {
      const res = await fetch(url, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(data),
      });

      if (res.status === 200) {
        this.questions_answers.all = this.questions_answers.all.map(
          (question, index) => {
            if (index === this.form.edit_index) {
              question = { ...data };
            }

            return question;
          }
        );

        this.close_dialog();
        this.notify({
          color: "primary",
          message: "Question updated successfully",
        });
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to add question to document",
        });
      }
    },

    edit_item(item) {
      this.form.edit_item_values = { ...item };
      this.form.edit_index = this.questions_answers.all.indexOf(item);
      this.dialog.is_open = true;
    },

    delete_item(item) {
      this.delete_dialog.delete_id = item.id;
      this.delete_dialog.delete_index = this.questions_answers.all.indexOf(
        item
      );
      this.delete_dialog.is_open = true;
    },

    async confirm_delete_item() {
      const delete_index = this.delete_dialog.delete_index;
      const delete_id = this.delete_dialog.delete_id;

      await this.send_delete_item_request(
        this.questions_answers.api_url,
        delete_id,
        delete_index
      );
    },

    async send_delete_item_request(url, delete_id, delete_index) {
      const res = await fetch(url, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ id: delete_id }),
      });

      if (res.status === 200) {
        this.questions_answers.all = this.questions_answers.all.filter(
          (_, index) => {
            return index !== delete_index;
          }
        );

        this.close_delete_dialog();

        this.notify({
          color: "primary",
          message: "Question deleted successfully",
        });
      }

      if (res.status !== 200) {
        this.notify({
          color: "red",
          message: "Failed to delete question",
        });
      }
    },

    close_delete_dialog() {
      this.delete_dialog.is_open = false;
      this.delete_dialog.delete_index = null;
      this.delete_dialog.delete_id = null;
    },

    notify(message) {
      this.$emit("notification", message);
    },
  },
};
</script>
