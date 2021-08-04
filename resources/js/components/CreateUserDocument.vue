<template>
  <div class="col-12">
    <div
      class="
        col-12 col-lg-7 col-md-10 col-sm-12
        mx-auto
        mb-4
        card
        questions-wrap
        bg-light
      "
    >
      <div class="row">
        <user-form-steps
          :field-groups="fieldGroups"
          @data="(data) => (this.filled_data = { ...data })"
          @done="
            () =>
              handle__document_pdf(this.pdf.api_url, this.documentVariationId, {
                ...this.filled_data,
              })
          "
          @update_preview="
            () =>
              this.handle__update_preview({ ...this.filled_data }, [
                ...this.template_images,
              ])
          "
          @save="
            () =>
              this.handle__document_save(
                this.user_document.api_url,
                this.documentVariationId,
                { ...this.filled_data },
                this.user_document.id
              )
          "
        ></user-form-steps>
      </div>
    </div>

    <div class="col-12 mt-4 questions-wrap document-preview">
      <pdf-live-preview :template-images="template_images"></pdf-live-preview>
    </div>

    <v-snackbar v-model="notification.open">
      {{ notification.message }}

      <template v-slot:action="{ attrs }">
      <v-btn
        :color="notification.error ? 'red' : 'primary'"
        text
        v-bind="attrs"
        @click="notification.open = false"
      >
        <v-icon> close </v-icon>
      </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import UserFormSteps from "./create_user_document/UserFormSteps.vue";
import PdfLivePreview from "./create_user_document/PdfLivePreview.vue";

export default {
  name: "CreateUserDocument",
  components: {
    UserFormSteps,
    PdfLivePreview,
  },

  props: {
    fieldGroups: {
      required: true,
      type: Array,
    },

    templateImages: {
      required: true,
      type: Array,
    },

    documentVariationId: {
      required: true,
      type: Number,
    },

    userDocumentId: {
      required: false,
      type: String,
    },
  },

  data() {
    return {
      // initial template images are different from filled-in
      // template images
      template_images: this.templateImages,

      // recieved from child component: UserFormSteps
      filled_data: {},

      preview: {
        api_url: "/api/user-document/preview",
      },

      pdf: {
        api_url: "/api/user-document/pdf",
      },

      user_document: {
        api_url: "/api/user-document/save",
        id: null, // if a new user_document id has been created, it will live here
      },

      notification: {
        message: null,
        open: false,
        error: false,
      },
    };
  },

  methods: {
    async handle__update_preview(filled_data, current_previews) {
      const template_images = await this.request_updated_preview(
        this.preview.api_url,
        this.documentVariationId,
        filled_data,
        current_previews
      ).catch((error) => console.error(error.message));

      // side-effect: directly changing state
      this.template_images = template_images.map((image) => {
        /**
         *  initially, image.location in templateImage don't start with the
         *  '/storage/' prefix. The response recieved above does. Therefore,
         *  for consistency, we remove this prefix from recieved data.
         */
        if (image.location.startsWith("/storage/")) {
          image.location = image.location.substr(9);
        }

        return image;
      });
    },

    async request_updated_preview(
      url,
      document_variation_id,
      filled_data,
      current_previews
    ) {
      const body = { document_variation_id, filled_data, current_previews };

      const res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(body),
      });

      if (res.status !== 200) {
        throw new Error(
          `Failed to get valid response from server. Status :: ${res.status}`
        );
      }

      return await res.json();
    },

    /**
     *  generate pdf file from filled data
     */
    async handle__document_pdf(url, variation_id, filled_data) {
      const body = { variation_id, filled_data };
      const res = await fetch(url, {
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

    handle__document_save(
      url,
      document_variation_id,
      filled_data,
      user_document_id
    ) {
      if (user_document_id) {
        this.document__update(
          url,
          user_document_id,
          document_variation_id,
          filled_data
        );
        return;
      }

      this.document__create(url, document_variation_id, filled_data);
    },

    async document__create(url, document_variation_id, filled_data) {
      const body = { document_variation_id, filled_data };
      const res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(body),
      });

      if (res.status !== 200) {
        console.error("Failed to create New document", res.status);
        return;
      }

      const data = await res.json();
      this.user_document.id = data.user_document_id;

      this.notify({
        message: "Created new User document",
        error: false,
      });
    },

    async document__update(
      url,
      user_document_id,
      document_variation_id,
      filled_data
    ) {
      const body = { user_document_id, document_variation_id, filled_data };
      const res = await fetch(url, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(body),
      });

      if (res.status !== 200) {
        this.notify({
          message: "Failed to update user document",
          error: true,
        });

        return;
      }

      this.notify({
        message: "Updated user document successfully",
        error: false,
      });
    },

    notify(data) {
      this.notification.message = data.message;
      this.notification.error = data.error;
      this.notification.open = true;
    },
  },
};
</script>
