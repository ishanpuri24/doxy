<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="5">

        <v-btn depressed class="mr-1" @click="previous_screen()">
          <v-icon left> arrow_back </v-icon>
          Back
        </v-btn>        

        <div>
          <v-card-title>Upload Document Template</v-card-title>
          <v-card-text
            >Please Select a PDF File which will serve as the Document Template
            for this document variation.
          </v-card-text>

          <div class="p-3">
            <v-file-input
              accept=".pdf"
              label="File Upload"
              v-model="filled_data.document_template.pdf_file"
            ></v-file-input>

            <v-btn
              :disabled="
                filled_data.document_template.image_encodings.length == 0
              "
              color="primary"
              class="mt-5"
              @click="submit_and_proceed()"
            >
              Next
              <v-icon right dark> arrow_forward </v-icon>
            </v-btn>
          </div>
        </div>
      </v-col>

      <v-col cols="12" md="7">
        <pdf-preview
          @notification="notify"
          @encodings="get_image_encodings"
          :pdf_file="filled_data.document_template.pdf_file"
        ></pdf-preview>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import PdfPreview from './step_three__template_pdf__pdf_preview.vue';

export default {
  name: "StepThree",
  components: {
    PdfPreview,
  },

  props: {},

  data() {
    return {
      filled_data: {
        document_template: {
          pdf_file: null,
          image_encodings: [],
        },
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

    notify(data) {
      this.$emit("notification", data);
    },
    
    get_image_encodings(payload) {
      this.filled_data.document_template.image_encodings = [...payload];
    },    

    submit_and_proceed() {
      const encodings = [...this.filled_data.document_template.image_encodings];

      this.$emit("data", encodings);
      this.next_screen();
    }
  },
};
</script>