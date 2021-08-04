<template>
  <div>
    <!-- dialog: create new or edit existing field group -->
    <v-dialog
      v-model="forms.field_group.dialog_is_open"
      persistent
      max-width="500px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">{{
            forms.field_group.edit.is_edit
              ? "Edit Form Group"
              : "Add Form Group"
          }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Heading*"
                  v-model="forms.field_group.current_values.group_name"
                  hide-details="auto"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  name="input-7-1"
                  label="Description"
                  v-model="forms.field_group.current_values.group_description"
                ></v-textarea>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="field_group__discard()">
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="field_group__save()"
            :disabled="!forms.field_group.current_values.group_name"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- dialog: create new or edit existing document field -->
    <v-dialog
      v-model="forms.document_field.dialog_is_open"
      persistent
      max-width="500px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">{{
            forms.document_field.edit.is_edit
              ? "Edit Document Field"
              : "Add Document Field"
          }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Field Name*"
                  v-model="forms.document_field.current_values.field_name"
                  hide-details="auto"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Input Type*"
                  v-model="forms.document_field.current_values.input_type"
                  :items="forms.document_field.input_types"
                  item-text="text"
                  item-value="value"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Field Group*"
                  v-model="
                    forms.document_field.current_values
                      .document_field_group_name
                  "
                  :items="filled_data.field_hierarchy"
                  item-text="group_name"
                  item-value="group_name"
                  class="pt-0"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-switch
                  v-model="forms.document_field.current_values.wrap_text"
                  label="Wrap Text"
                  :disabled="
                    forms.document_field.current_values.input_type !== 'text'
                  "
                ></v-switch>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="Line Length"
                  type="number"
                  v-model="forms.document_field.current_values.line_length"
                  hide-details="auto"
                  :disabled="!forms.document_field.current_values.wrap_text"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="Line Height"
                  type="number"
                  v-model="forms.document_field.current_values.line_height"
                  :disabled="!forms.document_field.current_values.wrap_text"
                  hide-details="auto"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="document_field__discard()">
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            :disabled="
              !forms.document_field.current_values.field_name ||
              !forms.document_field.current_values.input_type ||
              !forms.document_field.current_values.document_field_group_name
            "
            @click="document_field__save()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-toolbar flat>
      <v-btn depressed class="mr-1" @click="previous_screen()">
        <v-icon left> arrow_back </v-icon>
        Back
      </v-btn>

      <v-spacer></v-spacer>

      <v-btn
        depressed
        class="mr-1"
        @click="forms.field_group.dialog_is_open = true"
      >
        <v-icon left> add </v-icon>
        Add Field Group
      </v-btn>

      <v-btn
        depressed
        @click="forms.document_field.dialog_is_open = true"
        :disabled="filled_data.field_hierarchy.length === 0"
      >
        <v-icon left> add </v-icon>
        Add Field
      </v-btn>

      <v-btn
        color="primary"
        elevation="0"
        class="ml-1"
        :disabled="is_next_disabled()"
        @click="submit_and_proceed()"
      >
        Next
        <v-icon right dark> arrow_forward </v-icon>
      </v-btn>
    </v-toolbar>

    <v-container fluid class="mt-3 px-4">
      <v-row cols="12">
        <v-col>
          <template v-if="filled_data.field_hierarchy.length > 0">
            <v-row
              v-for="(group, index) in filled_data.field_hierarchy"
              :key="index"
            >
              <v-sheet width="100%">
                <div class="d-flex field-group">
                  <span class="my-auto font-weight-bold">{{
                    group.group_name
                  }}</span>
                  <span class="ml-auto">
                    <v-btn
                      icon
                      color="primary"
                      @click="field_group__edit(index)"
                    >
                      <v-icon small> edit </v-icon>
                    </v-btn>
                    <v-btn
                      icon
                      color="red"
                      @click="field_group__delete(index)"
                      :disabled="group.fields.length > 0"
                    >
                      <v-icon small> delete </v-icon>
                    </v-btn>
                  </span>
                </div>
                <div
                  v-for="(field, i) in group.fields"
                  :key="i"
                  class="d-flex document-field"
                >
                  <v-icon class="mr-2 gray-icon">
                    subdirectory_arrow_right
                  </v-icon>
                  <span class="my-auto">{{ field.field_name }}</span>
                  <span class="ml-auto">
                    <v-btn
                      icon
                      color="primary"
                      @click="document_field__edit(field)"
                    >
                      <v-icon small> edit </v-icon>
                    </v-btn>
                    <v-btn
                      icon
                      color="red"
                      @click="document_field__delete(field)"
                    >
                      <v-icon small> delete </v-icon>
                    </v-btn>
                  </span>
                </div>
              </v-sheet>
            </v-row>
          </template>

          <template v-if="filled_data.field_hierarchy.length == 0">
            <div class="d-flex justify-center mt-10">
              <v-alert type="info">
                No Fields or Field Groups found. Start by creating a new Field
                Group.
              </v-alert>
            </div>
          </template>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template> 

<script>
export default {
  name: "StepTwo",

  data() {
    return {
      forms: {
        field_group: {
          dialog_is_open: false,
          edit: {
            is_edit: false,
            edit_index: null, // index in field hierarchy
          },
          default_values: {
            group_name: null,
            group_description: null,
            fields: [],
          },
          current_values: {
            group_name: null,
            group_description: null,
            fields: [],
          },
        },
        document_field: {
          dialog_is_open: false,
          edit: {
            is_edit: false,
            edit_group_index: null,
            edit_field_index: null,
          },
          input_types: [
            { text: "Text", value: "text" },
            { text: "Number", value: "number" },
            { text: "Checkbox", value: "checkbox" },
            { text: "Date", value: "date" },
            { text: "Time", value: "time" },
          ],
          default_values: {
            field_name: null,
            input_type: null,
            document_field_group_name: null,
            wrap_text: false,
            line_length: null,
            line_height: null,
            positions: [],
          },
          current_values: {
            field_name: null,
            input_type: null,
            document_field_group_name: null,
            wrap_text: false,
            line_length: null,
            line_height: null,
            positions: [],
          },
        },
      },

      filled_data: {
        field_hierarchy: [],
      },
    };
  },

  methods: {
    next_screen() {
      this.$emit("next_screen");
    },

    previous_screen() {
      this.$emit("previous_screen");
    },

    /**
     *  field group related methods
     *
     */
    find_group_by_name(group_name) {
      let result = -1;

      this.filled_data.field_hierarchy.forEach((group, index) => {
        if (group.group_name === group_name) {
          result = index;
        }
      });

      return result;
    },

    field_group__discard() {
      this.field_group_dialog__close();

      this.forms.field_group.current_values = {
        ...this.forms.field_group.default_values,
      };
    },

    field_group__save() {
      if (!this.forms.field_group.edit.is_edit) {
        const current_group = { ...this.forms.field_group.current_values };
        current_group.fields = [];
        this.filled_data.field_hierarchy.push(current_group);
      }

      // handle edit scenario
      if (this.forms.field_group.edit.is_edit) {
        this.filled_data.field_hierarchy[
          this.forms.field_group.edit.edit_index
        ].group_name = this.forms.field_group.current_values.group_name;
        this.filled_data.field_hierarchy[
          this.forms.field_group.edit.edit_index
        ].group_description = this.forms.field_group.current_values.group_description;
      }

      this.field_group_dialog__close();

      // clear out the input form
      this.forms.field_group.current_values = {
        ...this.forms.field_group.default_values,
      };

      this.notify({
        error: false,
        message: this.forms.field_group.edit.is_edit
          ? "Field Group Updated"
          : "Field Group Added",
      });
    },

    field_group_dialog__close() {
      this.forms.field_group.dialog_is_open = false;
      this.forms.field_group.edit.is_edit = false;
      this.forms.field_group.edit.edit_index = null;
    },

    field_group__delete(delete_index) {
      let current_hierarchy = [...this.filled_data.field_hierarchy];
      current_hierarchy.splice(delete_index, 1);
      this.filled_data.field_hierarchy = [...current_hierarchy];

      this.notify({
        error: false,
        message: "Field Group Deleted Successfully",
      });
    },

    /**
     *  document field related methods
     *
     */
    field_group__edit(group_index) {
      this.forms.field_group.current_values = {
        ...this.filled_data.field_hierarchy[group_index],
      };
      this.forms.field_group.edit.is_edit = true;
      this.forms.field_group.edit.edit_index = group_index;
      this.forms.field_group.dialog_is_open = true;
    },

    document_field__discard() {
      this.forms.document_field.dialog_is_open = false;
      this.forms.document_field.current_values = {
        ...this.forms.document_field.default_values,
      };
    },

    document_field__save() {
      const current_field = { ...this.forms.document_field.current_values };

      if (!this.forms.document_field.edit.is_edit) {
        this.filled_data.field_hierarchy = this.filled_data.field_hierarchy.map(
          (group) => {
            if (group.group_name === current_field.document_field_group_name) {
              group.fields.push(current_field);
            }
            return group;
          }
        );
      }

      if (this.forms.document_field.edit.is_edit) {
        const old_group_index = this.forms.document_field.edit.edit_group_index;
        const new_group_index = this.find_group_by_name(
          current_field.document_field_group_name
        );
        const field_index = this.forms.document_field.edit.edit_field_index;

        if (old_group_index === new_group_index) {
          this.filled_data.field_hierarchy[old_group_index].fields[
            field_index
          ] = {
            ...current_field,
          };
        }

        if (old_group_index !== new_group_index) {
          this.filled_data.field_hierarchy[old_group_index].fields.splice(
            field_index,
            1
          );
          this.filled_data.field_hierarchy[new_group_index].fields.push(
            current_field
          );
        }
      }

      this.notify({
        error: false,
        message: this.forms.document_field.edit.is_edit
          ? "Document Field Updated"
          : "Document Field Added",
      });

      this.document_field_dialog__close();
    },

    document_field_dialog__close() {
      this.forms.document_field.dialog_is_open = false;
      this.forms.document_field.edit.is_edit = false;
      this.forms.document_field.edit.edit_group_index = null;
      this.forms.document_field.edit.edit_field_index = null;

      // clear out the form fields
      this.forms.document_field.current_values = {
        ...this.forms.document_field.default_values,
      };
    },

    document_field__edit(edit_field) {
      this.forms.document_field.current_values = { ...edit_field };
      this.forms.document_field.edit.is_edit = true;
      this.forms.document_field.dialog_is_open = true;

      // detect position of the edited field in field_hierarchy
      this.filled_data.field_hierarchy.forEach((group, group_index) => {
        group.fields.forEach((field, field_index) => {
          if (
            field.field_name === edit_field.field_name &&
            field.document_field_group_name ===
              edit_field.document_field_group_name
          ) {
            this.forms.document_field.edit.edit_group_index = group_index;
            this.forms.document_field.edit.edit_field_index = field_index;
          }
        });
      });
    },

    document_field__delete(del_field) {
      let current_hierarchy = [...this.filled_data.field_hierarchy];

      current_hierarchy = current_hierarchy.map((group) => {
        group.fields = group.fields.filter((field) => {
          if (
            field.field_name === del_field.field_name &&
            field.document_field_group_name ===
              del_field.document_field_group_name
          ) {
            return false;
          }

          return true;
        });

        return group;
      });

      this.filled_data.field_hierarchy = [...current_hierarchy];

      this.notify({
        error: false,
        message: "Field Deleted Successfully",
      });
    },

    is_next_disabled() {
      const is_groups_empty = this.filled_data.field_hierarchy.length === 0;
      const is_fields_empty = this.filled_data.field_hierarchy[0]
        ? this.filled_data.field_hierarchy[0].fields.length === 0
        : false;

      return is_groups_empty || is_fields_empty;
    },

    submit_and_proceed() {
      this.$emit("data", this.filled_data.field_hierarchy);
      this.next_screen();
    },

    notify(data) {
      this.$emit("notification", data);
    },
  },
};
</script>

<style lang="scss" scoped>
.field-group,
.document-field {
  border-radius: 0.2rem;
  padding: 0.2rem 1rem;

  &:hover {
    background: hsla(0, 0%, 0%, 0.05);
  }
}

.field-group {
  border-bottom: 1px solid hsla(0, 0%, 0%, 0.1);
  margin-top: 1rem;
}

.gray-icon {
  color: hsla(0, 0%, 0%, 0.1);
}
</style>