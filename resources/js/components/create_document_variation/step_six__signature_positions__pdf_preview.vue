<template>
  <div class="preview">
    <div
      :data-page="page.page_num"
      v-for="page in pages"
      :key="page.page_num"
      class="img_wrapper"
      :style="`width: ${image_width};`"
    >
      <img
        :src="page.image_encoding"
        :style="`cursor: ${cursor};`"
        @click="detect_click_position($event, page.page_num)"
      />

      <template
        v-for="(marker, index) in markers.filter(
          (marker) => marker.clicked_pixel.page === page.page_num
        )"
      >
        <span
          class="marker"
          @click="handleMarkerClick(marker)"
          :key="index"
          :style="`
            top: ${marker.position.top}%; 
            left: ${marker.position.left}%;`"
          ><span>{{ marker.selected_signatory.name }}</span></span
        >
      </template>
    </div>

    <div class="zoom_controls">
      <button @click="set_zoom(1)">+</button>
      <button @click="set_zoom(-1)">-</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "SignatoriesPositionsPreview",

  props: {
    pages: {
      required: true,
      type: Array,
    },
    selected_signatory: {
      required: false,
      // type: Object,
    },
  },

  data: () => {
    return {
      zoom: {
        current: 1,
        step: 0.1,
      },
      markers: [],
    };
  },

  mounted() {
    console.log("selected signatory", this.selected_signatory);
  },

  computed: {
    image_width() {
      const zoom_perc = this.zoom.current * 100;
      return `calc(${zoom_perc}% - calc(var(--gap) * 2))`;
    },

    cursor() {
      return this.selected_signatory ? "crosshair" : "auto";
    },
  },

  watch: {
    markers: {
      handler(newValue) {
        console.log("markers", newValue);
      },
      deep: true,
    },
  },

  methods: {
    set_zoom(direction) {
      if (direction == 0) return;

      this.zoom.current =
        direction < 0
          ? this.zoom.current - this.zoom.step
          : this.zoom.current + this.zoom.step;
    },

    detect_click_position(event, page_num) {
      /**
       *  if no field is selected, clicked position doesn't
       *  need to be calculated
       */
      if (!this.selected_signatory) {
        return;
      }

      /**
       *  image dimentions as visible on the screen
       *
       */
      const page_dimensions = {
        height: event.target.offsetHeight,
        width: event.target.offsetWidth,
      };

      /**
       *  actual image dimentions in pixels
       *
       */
      const page_img_dimensions = {
        height: event.target.naturalHeight,
        width: event.target.naturalWidth,
      };

      const click_position = {
        x: event.offsetX,
        y: event.offsetY,
      };

      const clicked_pixel = {
        page: page_num,
        pixel: {
          x: Math.round(
            (click_position.x / page_dimensions.width) *
              page_img_dimensions.width
          ),
          y: Math.round(
            (click_position.y / page_dimensions.height) *
              page_img_dimensions.height
          ),
        },
      };

      console.log("clicked pixel", clicked_pixel);
      this.saveMarkerLocal(clicked_pixel, page_img_dimensions);

      const signatory_copy = { ...this.selected_signatory };
      signatory_copy.positions.push(clicked_pixel);
      this.emitMarkerToParent(signatory_copy);
    },

    /**
     *  save clicked position details as marker in local component state
     *
     */
    saveMarkerLocal(clicked_pixel, page_img_dimensions) {
      const new_markers = [...this.markers];
      new_markers.push({
        clicked_pixel,
        position: {
          top: (clicked_pixel.pixel.y / page_img_dimensions.height) * 100,
          left: (clicked_pixel.pixel.x / page_img_dimensions.width) * 100,
        },
        selected_signatory: this.selected_signatory,
      });

      this.markers = [...new_markers];
    },

    /**
     *  inform parent component that a field's position has been set
     *
     */
    emitMarkerToParent(signatory) {
      this.$emit("position_selected", { signatory });
    },

    /**
     *  show details and / or delete marker when clicked on preview
     *
     */
    handleMarkerClick(marker) {
      const signatory_name = marker.selected_signatory.name;

      const deleteMarker = window.confirm(
        `Signatory Name: ${signatory_name}\n\nDelete Marker?`
      );

      if (deleteMarker) {
        this.deleteLocalMarker(marker);
        this.deleteParentMarker(marker);
      }
    },

    /**
     *  two copies of markers exist
     *  1. Locally in this component's state
     *  2. In the parent element's state
     *
     *  this function deletes marker only from the local state
     */
    deleteLocalMarker(marker) {
      const del_index = this.markers.indexOf(marker);
      const copy = [...this.markers];
      copy.splice(del_index, 1);
      this.markers = [...copy];
    },

    /**
     *  delete marker from parent component's state i.e.
     *  from inside the field hierarchy
     *
     */
    deleteParentMarker(marker) {
      const signatory_copy = { ...marker.selected_signatory };

      const del_marker_index = signatory_copy.positions.findIndex(
        (position) => {
          return (
            position.pixel.x === marker.clicked_pixel.pixel.x &&
            position.pixel.y === marker.clicked_pixel.pixel.y
          );
        }
      );

      if (del_marker_index === -1) {
        throw new Error("Del marker not found in parent component's state");
      }

      signatory_copy.positions.splice(del_marker_index, 1);
      this.$emit("position_selected", {
        signatory: signatory_copy,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.preview {
  --height: 75vh;
  --gap: 0.5rem;

  background: hsl(0, 0%, 50%);
  display: flex;
  flex-direction: column;
  height: var(--height);
  overflow-y: auto;

  .img_wrapper {
    display: flex;
    position: relative;
    margin: var(--gap) auto;

    img {
      border-radius: 0.3rem;
      width: 100%;
      box-shadow: 0.1rem 0.2rem 0.5rem rgba(0, 0, 0, 0.3);
    }
  }

  .zoom_controls {
    display: inline-flex;
    flex-direction: column;
    gap: 0.5rem;
    position: absolute;
    right: 2.5rem;
    bottom: 1.5rem;
    width: 3rem;

    button {
      background: white;
      padding: 0.5rem 1rem;
      border-radius: 0.3rem;
      font-weight: bold;
      box-shadow: 0.1rem 0.2rem 0.3rem rgb(0 0 0 / 8%);
      border: 1px solid rgba(0, 0, 0, 0.1);

      &:hover {
        background: hsl(0, 0%, 95%);
      }

      &:active {
        background: hsl(0, 0%, 87%);
      }
    }
  }

  .marker {
    --size: 1.5rem;
    border-radius: 0.3rem;
    height: var(--size);
    background: #6a6ad5;
    position: absolute;
    cursor: pointer;
    color: white;
    display: flex;
    padding: 0 0.5rem;

    span {
      margin: auto;
      font-size: 0.7rem;
      font-weight: bold;
    }
  }
}
</style>