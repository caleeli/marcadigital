<template>
  <div class="form-group">
    <div class="d-inline-block">
      <upload v-model="local" @change="ready">
        <button type="button" class="btn btn-primary">
          <i class="fas fa-file-upload"></i>
          {{ __("Upload certification") }}
        </button>
      </upload>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: null,
  },
  data() {
    return {
      local: this.value,
    };
  },
  methods: {
    ready(file) {
      this.$emit('input', file);
      this.$emit('change', file);
    },
  },
};
</script>

<style>
</style>