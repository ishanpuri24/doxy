<template>
  <div>
    <div class="preview-container">
      <template v-for="image in templateImages">
        <img
          v-if="current_page === image.page"
          :key="image.page"
          :src="'/storage/' + image.location"
          alt="template page"
        />
      </template>

      <div class="control-buttons-container">
        <div class="control-buttons mx-auto">
          <v-btn icon @click="current_page--" :disabled="current_page === 1">
            <v-icon> navigate_before </v-icon>
          </v-btn>

          <span
            ><em>Page {{ current_page }}</em> of {{ total_pages }}
          </span>

          <v-btn
            icon
            @click="current_page++"
            :disabled="current_page === total_pages"
          >
            <v-icon> navigate_next </v-icon>
          </v-btn>
        </div>
      </div>
    </div>
  </div>
</template> 

<script>
export default {
  name: "PdfLivePreview",

  props: {
    templateImages: {
      required: true,
      type: Array,
    },
  },

  data() {
    return {
      current_page: 1,
      total_pages: this.templateImages.length,
    };
  },
};
</script>

<style lang="scss" scoped>
.preview-container {
  display: flex;
  flex-direction: column;

  img {
    width: 70%;
    margin: 0 auto;
    box-shadow: 0.1rem 0.2rem 0.3rem rgb(0 0 0 / 15%);
    border-radius: 0.3rem;
  }

  .control-buttons-container {
    .control-buttons {
      width: 70%;
      margin-top: 2rem;
      display: flex;

      button:first-child {
        margin-left: auto;
      }

      span {
        align-self: center;

        em {
          font-style: initial;
          font-weight: bold;
        }
      }
    }
  }
}
</style>