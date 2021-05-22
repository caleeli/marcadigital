<template>
  <b-form-radio-group
    id="btn-radios-serif"
    v-model="selected"
    :aria-describedby="ariaDescribedby"
    name="radios-btn-serif"
    buttons
    button-variant="outline-secondary"
    @change="change"
  >
    <b-form-radio
      v-model="selected"
      :aria-describedby="ariaDescribedby"
      value="serif"
      class="serif"
    >
      {{ __("Serif") }}
    </b-form-radio>
    <b-form-radio
      v-model="selected"
      :aria-describedby="ariaDescribedby"
      value="sans-serif"
      class="sans-serif"
    >
      {{ __("Sans Serif") }}
    </b-form-radio>
  </b-form-radio-group>
</template>

<script>
export default {
  props: {
    value: { default: "serif" },
  },
  data() {
    return {
      ariaDescribedby: "style",
      selected: this.value,
    };
  },
  methods: {
    change(value) {
      this.$emit("change", value);
    },
  },
};
</script>

<style scoped>
.serif {
  font-family: "Times New Roman", Times, serif;
}
.sans-serif {
  font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
}
</style>