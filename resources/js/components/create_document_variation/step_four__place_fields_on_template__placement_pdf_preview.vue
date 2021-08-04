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
            top: calc(${marker.position.top}% - calc(var(--size) / 2)); 
            left: calc(${marker.position.left}% - calc(var(--size) / 2));`"
        ><span>{{ marker.selected_field.table_index }}</span></span>
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
  name: "PlacementPdfPreview",
  props: ["pages", "selected_field_position", "hierarchy"],

  data: () => {
    return {
      zoom: {
        current: 1,
        step: 0.1,
      },
      markers: [],
    };
  },

  computed: {
    image_width() {
      const zoom_perc = this.zoom.current * 100;
      return `calc(${zoom_perc}% - calc(var(--gap) * 2))`;
    },

    cursor() {
      return this.selected_field_position ? "crosshair" : "auto";
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
      if (!this.selected_field_position) {
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

      this.saveMarkerLocal(clicked_pixel, page_img_dimensions);
      this.emitMarkerToParent(clicked_pixel);
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
        selected_field: this.selected_field_position,
      });

      this.markers = [...new_markers];
    },


    /**
     *  inform parent component that a field's position has been set
     * 
    */
    emitMarkerToParent(clicked_pixel) {
      let copy = Array.from(this.hierarchy);
      let field_copy = JSON.parse(
        JSON.stringify(
          copy[this.selected_field_position.group_index].fields[
            this.selected_field_position.field_index
          ]
        )
      );

      field_copy.positions.push(clicked_pixel);

      this.$emit("updated_hierarchy", {
        field: field_copy,
        selected: this.selected_field_position,
      });
    },


    /**
     *  show details and / or delete marker when clicked on preview
     * 
    */
    handleMarkerClick(marker) {
      const { group_index, field_index } = marker.selected_field;
      const group_name = this.hierarchy[group_index].group_name;
      const field_name =
        this.hierarchy[group_index].fields[field_index].field_name;

      const deleteMarker = window.confirm(
        `Group name: ${group_name}\nField Name: ${field_name}\n\nDelete Marker?`
      );

      if (deleteMarker) {
        this.deleteLocalMarker(marker);
        this.deleteParentMarker(marker);
      }
    },

    /**
     *  two copies of markers exist
     *  1. Locally in this component's state
     *  2. In the parent element inside the hierarchy
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
      const {group_index, field_index} = marker.selected_field;
      const field_copy = {...this.hierarchy[group_index].fields[field_index]};

      const {x, y} = marker.clicked_pixel.pixel;
      const del_marker_index = field_copy.positions.findIndex(position => {
        return (position.pixel.x === x && position.pixel.y === y); 
      });
      
      if (del_marker_index === -1) {
        throw new Error("Del marker not found in parent state hierarchy");
      }

      field_copy.positions.splice(del_marker_index, 1);
      this.$emit("updated_hierarchy", {
        field: field_copy,
        selected: this.selected_field_position,
      });
    }
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
    border-radius: 100%;
    height: var(--size);
    width: var(--size);
    background: #6a6ad5;
    position: absolute;
    cursor: pointer;
    color: white;
    display: flex;

    span {
      margin: auto;
      font-size: 0.7rem;
      font-weight: bold;
    }
  }
}
</style>