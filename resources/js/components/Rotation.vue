<template>
  <b-form-radio-group
    id="btn-radios-rotation"
    v-model="selected"
    :aria-describedby="ariaDescribedby"
    name="radios-btn-rotation"
    buttons
    button-variant="outline-secondary"
    @change="change"
  >
    <b-form-radio
      :aria-describedby="ariaDescribedby"
      :value="0"
    >
      0°
    </b-form-radio>
    <b-form-radio
      :aria-describedby="ariaDescribedby"
      :value="1"
    >
      90°
    </b-form-radio>
    <b-form-radio
      :aria-describedby="ariaDescribedby"
      :value="2"
    >
      180°
    </b-form-radio>
    <b-form-radio
      :aria-describedby="ariaDescribedby"
      :value="3"
    >
      270°
    </b-form-radio>
  </b-form-radio-group>
</template>

<script>
export default {
  props: {
    value: { default: 0 },
  },
  data() {
    return {
      ariaDescribedby: "rotation",
      selected: this.value,
    };
  },
  methods: {
    change(value) {
      if (value != this.value) {
        this.$emit("change", value);
      }
    },
  },
  watch: {
    value(value) {
      this.selected = value;
    },
  },
};
</script>
