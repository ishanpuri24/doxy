<template>
  <v-app>
    <v-app-bar app>
      <v-toolbar-title>
        <v-btn depressed class="mr-2" @click="redirect('/dashboard')">
          <v-icon left>arrow_back</v-icon>
          Dashboard
        </v-btn>
        Document Variation
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn
        :disabled="isFinishDisabled()"
        color="primary"
        small
        @click="finish_document_creation"
        class="mr-2"
      >
        Finish
      </v-btn>

      <v-menu bottom min-width="200px" rounded offset-y>
        <template v-slot:activator="{ on }">
          <v-btn icon x-large v-on="on">
            <v-avatar color="primary" size="32">
              <v-icon dark> account_circle </v-icon>
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <v-avatar color="primary">
                <v-icon dark> account_circle </v-icon>
              </v-avatar>
              <h3>{{ user.fullName }}</h3>
              <p class="caption mt-1">
                {{ user.email }}
              </p>
              <v-divider class="my-3"></v-divider>
              <v-btn depressed rounded text @click="redirect('/my-profile')">
                Edit
              </v-btn>
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
    </v-app-bar>

    <!-- notifications component -->
    <v-snackbar v-model="snackbar.is_open">
      {{ snackbar.message }}

      <template v-slot:action="{ attrs }">
        <v-btn
          :color="snackbar.color"
          text
          v-bind="attrs"
          @click="snackbar.is_open = false"
        >
          <v-icon> close </v-icon>
        </v-btn>
      </template>
    </v-snackbar>

    <v-main>
      <v-stepper v-model="screens.current_index" class="elevation-0">
        <v-stepper-header>
          <v-stepper-step :complete="screens.current_index > 1" step="1">
            State
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step :complete="screens.current_index > 2" step="2">
            Fields & Field Groups
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step :complete="screens.current_index > 3" step="3">
            Document Template
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step :complete="screens.current_index > 4" step="4">
            Field Positions
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step :complete="screens.current_index > 5" step="5">
            Signatories
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step :complete="screens.current_index > 6" step="6">
            Signature Positions
          </v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
          <v-stepper-content step="1">
            <step-one
              :documents="documents"
              @next_screen="next_screen()"
              @data="populate_step_one_data"
            ></step-one>
          </v-stepper-content>

          <v-stepper-content step="2">
            <step-two
              @next_screen="next_screen()"
              @previous_screen="previous_screen()"
              @notification="notify"
              @data="populate_step_two_data"
            ></step-two>
          </v-stepper-content>

          <v-stepper-content step="3">
            <step-three
              @next_screen="next_screen()"
              @previous_screen="previous_screen()"
              @data="populate_step_three_data"
              @notification="notify"
            ></step-three>
          </v-stepper-content>

          <v-stepper-content step="4" class="fill_remaining p-0">
            <step-four
              v-if="screens.current_index === 4"
              :hierarchy="this.filled_data.field_hierarchy"
              :pages="filled_data.document_template.image_encodings"
              @next_screen="next_screen()"
              @previous_screen="previous_screen()"
              @data="populate_step_four_data"
              @notification="notify"
            ></step-four>
          </v-stepper-content>

          <v-stepper-content step="5">
            <step-five
              @next_screen="next_screen()"
              @previous_screen="previous_screen()"
              @data="populate_step_five_data"
              @notification="notify"
            ></step-five>
          </v-stepper-content>

          <v-stepper-content step="6" class="fill_remaining p-0">
            <step-six
              v-if="screens.current_index == 6"
              :signatories="filled_data.signatories"
              :pages="filled_data.document_template.image_encodings"
              @previous_screen="previous_screen()"
              @data="populate_step_six_data"
              @notification="notify"
            ></step-six>
          </v-stepper-content>
        </v-stepper-items>
      </v-stepper>

      <loading :open="loader.is_visible"></loading>
    </v-main>
  </v-app>
</template>

<script>
import StepOne from "./create_document_variation/step_one__state.vue";
import StepTwo from "./create_document_variation/step_two__field_hierarchy.vue";
import StepThree from "./create_document_variation/step_three__template_pdf.vue";
import StepFour from "./create_document_variation/step_four__place_fields_on_template.vue";
import StepFive from "./create_document_variation/step_five__signatories.vue";
import StepSix from "./create_document_variation/step_six__signature_positions.vue";
import Loading from "./create_document_variation/loading.vue";

export default {
  name: "Create_Document_Template",

  props: {
    documents: {
      required: true,
      type: Array,
    },
  },

  components: {
    StepOne,
    StepTwo,
    StepThree,
    StepFour,
    StepFive,
    StepSix,
    Loading,
  },

  data() {
    return {
      user: {
        fullname: "John",
        email: "john_doe@gmail.com",
      },

      snackbar: {
        is_open: false,
        message: null,
        error: false,
      },

      screens: {
        current_index: 1,
      },

      filled_data: {
        document_id: null,
        state: null,
        field_hierarchy: [],
        document_template: {
          image_encodings: [],
        },
        signatories: [],
      },

      loader: {
        is_visible: false,
      },

      document_variation: {
        api: "/api/document/variations",
      },

      disable_finish: false,


      /**
       *  this is for testing purposes only, remove if not required
       * 
      */
      test_field_heirarchy: [
        {
          group_name: "Screen 1",
          group_description: "Screen 1 Desc",
          fields: [
            {
              document_field_group_name: "Screen 1",
              field_name: "Sample 1",
              input_type: "text",
              line_height: null,
              line_length: null,
              wrap_text: null,
              positions: [],
            },
            {
              document_field_group_name: "Screen 1",
              field_name: "Sample 2",
              input_type: "text",
              line_height: null,
              line_length: null,
              wrap_text: null,
              positions: [],
            },
          ],
        },
        {
          group_name: "Screen 2",
          group_description: "Screen 2 Desc",
          fields: [
            {
              document_field_group_name: "Screen 2",
              field_name: "Sample 3",
              input_type: "text",
              line_height: null,
              line_length: null,
              wrap_text: null,
              positions: [],
            },
            {
              document_field_group_name: "Screen 2",
              field_name: "Sample 4",
              input_type: "text",
              line_height: null,
              line_length: null,
              wrap_text: null,
              positions: [],
            },
          ],
        },
      ],
    };
  },

  methods: {
    redirect(url) {
      window.open(url, "_blank").focus();
    },

    next_screen() {
      this.screens.current_index++;
    },

    previous_screen() {
      this.screens.current_index--;
    },

    notify(data) {
      this.snackbar.message = data.message;
      this.snackbar.error = data.error ? "red" : "primary";
      this.snackbar.is_open = true;
    },

    /**
     *  recieve state data from child components and set it into
     *  this component's state
     *
     */
    populate_step_one_data(payload) {
      this.filled_data.document_id = payload.document_id;
      this.filled_data.state = payload.state;
    },

    populate_step_two_data(payload) {
      this.filled_data.field_hierarchy = [...payload];
    },

    populate_step_three_data(payload) {
      this.filled_data.document_template.image_encodings = payload;
    },

    populate_step_four_data(payload) {
      this.filled_data.field_hierarchy = [...payload];
    },

    populate_step_five_data(payload) {
      this.filled_data.signatories = [...payload];
    },

    populate_step_six_data(payload) {
      this.filled_data.signatories = [...payload];
    },

    /**
     *  submit the filled data to the server
     *
     */
    async finish_document_creation() {
      this.loader.is_visible = true;
      const body = JSON.stringify(this.filled_data);

      const res = await fetch(this.document_variation.api, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body,
      });

      this.loader.is_visible = false;

      if (res.status === 200) {
        this.disable_finish = true;
        this.notify({
          message: "Document Variation Created Successfully",
          error: false,
        });
      }

      if (res.status !== 200) {
        this.notify({
          message: "Failed to create Document Variation",
          error: true,
        });
      }
    },

    redirect(url) {
      window.open(url, "_blank").focus();
    },

    /**
     *  disable "Finish" button on successful submit
     *  so the data cannot accidentally be saved twice
     *
     */
    isFinishDisabled() {
      if (this.disable_finish) {
        return true;
      }

      return this.screens.current_index !== 6;
    },
  },
};
</script>

<style lang="scss" scoped>
.v-avatar {
  color: white;
}

.fill_remaining {
  height: 75vh;
}
</style>
