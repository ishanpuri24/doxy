<template>
  <div class="col-12 p-4 bg-white shadow rounded" data-step="1">
    <div>
      <div class="d-flex">
        <p class="mb-0 ml-auto">
          <span class="font-weight-bold">Step</span
          ><span class="badge badge-secondary ml-2"
            >{{ current_step + 1 }} of {{ total_steps }}</span
          >
        </p>
      </div>

      <template v-for="(group, index) in fieldGroups">
        <div
          v-if="index === current_step"
          class="form-step pt-3 pb-0"
          :key="index"
        >
          <h3>{{ group.group_name }}</h3>
          <h5 v-if="group.group_description" class="font-weight-normal">
            {{ group.group_description }}
          </h5>

          <div class="my-4">
            <template v-for="(field, f_index) in group.fields">
              <div class="form-group" :key="f_index">
                <div v-if="field.html_input_type === 'checkbox'">
                  <input
                    :type="field.html_input_type"
                    :name="field.field_slug"
                    v-model="filled_data[field.field_slug]"
                    class="form-check-input ml-1"
                  />
                  <label class="mb-0 ml-4">{{ field.field_name }}</label>
                </div>

                <div v-else>
                  <label>{{ field.field_name }}</label>
                  <input
                    :type="field.html_input_type"
                    :name="field.field_slug"
                    v-model="filled_data[field.field_slug]"
                    class="form-control"
                  />
                </div>
              </div>
            </template>
          </div>
        </div>
      </template>

      <hr />

      <div class="d-flex">
        <div class="btn-group" id="form_step_controls">
          <v-btn
            icon
            @click="
              () => (this.current_step = this.previous_step(this.current_step))
            "
            :disabled="current_step === 0"
          >
            <v-icon> navigate_before </v-icon>
          </v-btn>

          <v-btn
            icon
            @click="
              () => (this.current_step = this.next_step(this.current_step))
            "
            :disabled="current_step === total_steps - 1"
          >
            <v-icon> navigate_next </v-icon>
          </v-btn>
        </div>

        <button
          class="btn btn-secondary ml-auto"
          @click="() => this.$emit('update_preview')"
        >
          <i class="fa fa-redo mr-2"></i><span>Update Preview</span>
        </button>

        <button
          class="btn btn-secondary ml-1"
          @click="() => this.$emit('save')"
        >
          Save
        </button>

        <button class="btn btn-primary ml-1" @click="() => this.$emit('done')">
          Done
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "User_Form_Steps",
  props: ["fieldGroups"],

  mounted() {
    // calculate total steps one time
    this.total_steps = this.fieldGroups.length;
    this.filled_data = this.generate_filled_data_map(this.fieldGroups);
  },

  data() {
    return {
      current_step: 0,
      total_steps: null,
      filled_data: {},
    };
  },

  watch: {
    filled_data: {
      handler(new_value) {
        this.report_filled_data(new_value);
      },
      deep: true,
    },
  },

  methods: {
    previous_step(current_step) {
      return current_step - 1;
    },

    next_step(current_step) {
      return current_step + 1;
    },

    generate_filled_data_map(field_groups) {
      const result = {};

      field_groups.forEach((group) => {
        group.fields.forEach((field) => {
          result[field.field_slug] =
            field.html_input_type === "checkbox" ? false : null;
        });
      });

      return result;
    },

    report_filled_data(filled_data) {
      this.$emit("data", filled_data);
    },
  },
};
</script>