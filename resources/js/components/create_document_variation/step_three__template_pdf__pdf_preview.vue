<template>
  <div class="preview_container">
    <canvas ref="canvas"></canvas>

    <template v-if="file.image_encodings.length == 0">
      <div class="preview_placeholder">
        <v-icon size="80" class="icon"> article </v-icon>
      </div>
    </template>

    <template v-else>
      <div class="thumb_container">
        <v-progress-circular
          class="thumb_loading"
          v-if="!file.processing_complete"
          :value="file.progress"
          rotate="-90"
          color="primary"
        ></v-progress-circular>
        <img
          v-if="file.processing_complete"
          class="thumb_preview"
          :src="file.image_encodings[0].image_encoding"
          alt="preview"
        />
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: "PdfPreview",
  props: {
    pdf_file: {
      required: true,
    }
  },

  data: () => {
    return {
      preview: {
        scale: 2.0,
      },

      file: {
        pages: null,
        image_encodings: [],
        progress: 0,
        processing_complete: false,
      },
    };
  },

  watch: {
    pdf_file: async function (new_value) {
      if (new_value != null) {
        const encoded_data = await this.get_file_content(new_value);
        await this.process_document(encoded_data);
      }

      if (new_value == null) {
        this.file.image_encodings = [];
        this.file.progress = 0;
        this.file.processing_complete = false;
        this.$emit("encodings", []);
      }
    },
  },

  methods: {
    notify(data) {
      this.$emit("notification", data);
    },

    async get_file_content(file) {
      const reader = new FileReader();

      if (!this.is_pdf(file.name)) {
        this.notify({
          color: "red",
          message: "Invalid File Type Selected",
        });
        return;
      }

      return new Promise((resolve) => {
        reader.addEventListener(
          "load",
          () => {
            const encoding = this.extract_encoding(reader.result);
            resolve(encoding);
          },
          false
        );

        if (file) {
          reader.readAsDataURL(file);
        }
      });
    },

    is_pdf(filename) {
      const pattern = /^[\S,\s]*.(pdf|PDF)$/i;
      return pattern.test(filename);
    },

    extract_encoding(full_encoding) {
      const pieces = full_encoding.split(",");

      // remove encoding details
      pieces.shift();

      // return binary representation
      return atob(pieces.join(","));
    },

    async process_document(encoded_data) {
      const loadingTask = pdfjsLib.getDocument({ data: encoded_data });
      const pdf = await loadingTask.promise;
      this.file.pages = pdf.numPages;

      this.notify({
        color: "green",
        message: "Processing Selected file...",
      });

      for (let page = 1; page <= this.file.pages; page++) {
        const img = await this.handle_load(pdf, page);
        this.file.image_encodings.push(img);
        this.mark_current_progress(page);
      }

      this.$emit("encodings", this.file.image_encodings);
      this.mark_process_completion();
    },

    async handle_load(pdf, page_num) {
      const page = await pdf.getPage(page_num);
      const viewport = page.getViewport({ scale: this.preview.scale });

      // Prepare canvas using PDF page dimensions
      const context = this.$refs["canvas"].getContext("2d");

      this.$refs["canvas"].height = viewport.height;
      this.$refs["canvas"].width = viewport.width;

      // Render PDF page into canvas context
      const renderContext = {
        canvasContext: context,
        viewport: viewport,
      };

      return new Promise((resolve) => {
        const renderTask = page.render(renderContext);
        renderTask.promise.then(() => {
          const image_encoding = this.$refs["canvas"].toDataURL();
          resolve({ page_num, image_encoding });
        });
      });
    },

    mark_current_progress(page_num) {
      this.file.progress = Math.ceil((page_num / this.file.pages) * 200);
    },

    mark_process_completion() {
      this.file.processing_complete = true;
      this.notify({
        color: "primary",
        message: "Processing Complete",
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.preview_container {
  height: 100%;

  .preview_placeholder {
    height: 100%;
    width: 60%;
    display: flex;
    margin: auto;
    border-radius: 0.4rem;
    background: hsl(0, 0%, 97%);

    .icon {
      color: hsl(0, 0%, 83%);
      margin: auto;
    }
  }
}

.thumb_container {
  display: flex;
  flex-direction: column;
  height: 100%;

  .thumb_preview {
    height: 20rem;
    border: 1px solid #dadada;
    border-radius: 0.4rem;
    box-shadow: 0.1rem 0.2rem 0.3rem rgb(0 0 0 / 10%);
  }

  :is(.thumb_preview, .thumb_loading) {
    margin: auto;
  }
}

@media (max-width: 960px) {
  .preview_container {
    display: none;
  }
}

canvas {
  display: none;
}
</style>