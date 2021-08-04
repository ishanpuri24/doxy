<template>
  <v-container fluid class="p-4 mt-3">
    <v-alert
      type="info"
    >Please select an image file which will serve as your signatures. It is recommended that the image background be transparent.</v-alert>

    <v-card>
      <v-card-title>
        <v-file-input
          accept="image/*"
          label="Upload Signatures"
          v-model="selected_image.file"
          @change="handle_change"
        ></v-file-input>

        <v-btn
          color="primary"
          class="ml-3"
          @click="handle_upload"
          :disabled="selected_image.file == null"
        >
          <v-icon left> file_upload </v-icon>
          Upload
        </v-btn>
      </v-card-title>

      <v-card-text v-if="selected_image.encoding !== null">
        <p>Preview</p>
        <img
          class="signature_preview"
          :src="selected_image.encoding"
          alt="signature_preview"
        />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "DashboardItemSignatures",

  props: {
    user: {
      required: true,
      type: Object,
    },
  },

  data() {
    return {
      selected_image: {
        file: null,
        encoding: null,
      },

      signatures: {
        api_url: "/api/user-signatures",
      },
    };
  },

  async mounted() {
    await this.get_signatures();
  },

  methods: {
    async get_signatures() {
      const res = await fetch(
        `${this.signatures.api_url}/${this.user.id}`
      ).catch((err) => console.error("Failed to get signatures: ", err));

      const data = await res.json();
      if (data.signature_image) {
        this.selected_image.encoding = data.signature_image;
      }
    },

    async handle_upload() {
      const { encoding } = this.selected_image;
      const res = await fetch(this.signatures.api_url, {
        method: "POST",
        headers: {
          ContentType: "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          user_id: this.user.id,
          signature_image: encoding,
        }),
      });

      if (res.status !== 200) {
        this.$emit("notification", {
          message: "Failed to upload user signatures",
          color: "red",
        });

        console.warn("Invalid status code recieved:", res.status);
        return;
      }

      this.$emit("notification", {
        message: "User signatures uploaded successfully",
        color: "primary",
      });

      console.log("Signatures uploaded successfully");
    },

    async handle_change(e) {
      this.selected_image.encoding = await this.createBase64Image(e);
    },

    createBase64Image(file_obj) {
      return new Promise((resolve) => {
        const reader = new FileReader();

        reader.onload = (e) => {
          resolve(e.target.result);
        };

        reader.readAsDataURL(file_obj);
      });
    },
  },
};
</script>

<style scoped lang="scss">
.signature_preview {
  height: 20rem;
  width: 20rem;
  object-fit: cover;
  border-radius: 0.3rem;
  box-shadow: 0.1rem 0.2rem 0.3rem rgba(0, 0, 0, 0.05);
}
</style>