<template>
  <div class="background" v-if="open">
    <v-progress-circular class="m-auto" indeterminate color="primary"></v-progress-circular>
  </div>
</template>

<script>
export default {
  name: "Loading",
  props: {
    open: {
      required: true,
      type: Boolean,
    }
  },
};
</script>

<style scoped lang="scss">
.background {
  background: hsla(0, 0%, 100%, 0.85);
  height: 100vh;
  width: 100vw;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 10;
  display: flex;
}
</style>