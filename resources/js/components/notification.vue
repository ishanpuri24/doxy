<template>
  <v-snackbar v-model="snackbar.is_open">
    {{ message }}

    <template v-slot:action="{ attrs }">
      <v-btn
        :color="snackbar.color"
        text
        v-bind="attrs"
        @click="close()"
      >
        <v-icon> close </v-icon>
      </v-btn>
    </template>
  </v-snackbar>
</template> 

<script>
export default {
  name: "Notification",
  props: {
    message: {
      required: true,
    },
    open: {
      type: Boolean,
      required: true,
    },
    error: {
      required: true,
      type: Boolean
    },
    close: {
      type: Function,
      required: true,
    },
  },

  watch: {
    open: {
      handler(new_value) {
        this.snackbar.is_open = new_value;
      }
    },

    "snackbar.is_open": {
      handler(new_value) {
        if (!new_value) {
          this.close();
        }
      }
    },

    error: {
      handler(new_value) {
        this.color = (new_value) ? "primary" : "red";
      },
      deep: true,
    }
  },

  data() {
    return {
      snackbar: {
        is_open: false,
        color: "primary",
      },
    };
  },
};
</script>