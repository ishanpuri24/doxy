<template>
  <v-app>
    <v-app-bar app>
      <v-toolbar-title>
        <v-btn
          depressed
          class="mr-2"
          @click="redirect('/dashboard')"
        >
          <v-icon left>arrow_back</v-icon>
          Dashboard
        </v-btn>

        Custom User Document</v-toolbar-title
      >

      <v-spacer></v-spacer>

      <v-btn
        :disabled="screens.current_index !== 6"
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
              <h3>{{ user.name }}</h3>
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

    <notification
      :open="snackbar.is_open"
      :message="snackbar.message"
      :error="snackbar.error"
      :close="() => (snackbar.is_open = false)"
    ></notification>

    <v-main>
      <v-stepper v-model="screens.current_index" class="elevation-0">
        <v-stepper-header>
          <v-stepper-step :complete="screens.current_index > 1" step="1">
            Name
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
            ></step-four>
          </v-stepper-content>

          <v-stepper-content step="5">
            <step-five
              @next_screen="next_screen()"
              @previous_screen="previous_screen()"
              @data="populate_step_five_data"
            ></step-five>
          </v-stepper-content>

          <v-stepper-content step="6" class="fill_remaining p-0">
            <step-six
              v-if="screens.current_index == 6"
              :signatories="filled_data.signatories"
              :pages="filled_data.document_template.image_encodings"
              @previous_screen="previous_screen()"
              @data="populate_step_six_data"
            ></step-six>
          </v-stepper-content>
        </v-stepper-items>
      </v-stepper>

      <loading :open="loader.is_visible"></loading>
    </v-main>
  </v-app>
</template>

<script>
import StepOne from "./custom_user_document/step_one__name.vue";
import StepTwo from "./create_document_variation/step_two__field_hierarchy.vue";
import StepThree from "./create_document_variation/step_three__template_pdf.vue";
import StepFour from "./create_document_variation/step_four__place_fields_on_template.vue";
import StepFive from "./create_document_variation/step_five__signatories.vue";
import StepSix from "./create_document_variation/step_six__signature_positions.vue";
import Loading from "./create_document_variation/loading.vue";
import Notification from "./notification.vue";

export default {
  name: "Create_Document_Template",

  props: {
    user: {
      required: true,
      type: Object,
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
    Notification,
  },

  data: function () {
    return {
      snackbar: {
        is_open: false,
        message: null,
        error: false,
      },

      screens: {
        current_index: 1,
      },

      filled_data: {
        user_id: this.user.id,
        document_name: null,
        field_hierarchy: [],
        document_template: {
          image_encodings: [],
        },
        signatories: [],
      },

      loader: {
        is_visible: false,
      },

      custom_document: {
        api: "/api/custom-user-documents",
      },
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
      this.snackbar.error = data.error;
      this.snackbar.is_open = true;
    },

    /**
     *  recieve state data from child components and set it into
     *  this component's state
     *
     */
    populate_step_one_data(payload) {
      this.filled_data.document_name = payload.document_name;
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

      const res = await fetch(this.custom_document.api, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body,
      });

      this.loader.is_visible = false;

      if (res.status === 200) {
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
