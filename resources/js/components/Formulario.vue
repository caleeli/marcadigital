<template>
  <div v-if="value.attributes">
    <template v-for="(field,index) in fields">
      <formulario-campo :key="`field-${index}`"
        :field="field"
        :value="value"
        :state="state"
        :invalid-feedback="feedback(field)"
      />
    </template>
    <div class="text-right w-100 mt-2">
      <label class="text-danger" v-if="error">{{ error }}</label>
      <ul class="text-danger font-weight-light" v-for="(error, index) in errorsNotPresent" :key="`error-np-${index}`">
        <li v-for="(label, i) in error" :key="`error-np-${index}-${i}`">{{ label }}</li>
      </ul>
      <label class="text-success" v-if="success">{{ success }} <i class="fa fa-check"></i></label>
    </div>
  </div>
</template>

<script>
export default {
  mixins: [window.ResourceMixin],
  props: {
    value: Object,
    fields: Array,
    api: Object,
  },
  data() {
    return {
      state: null,
      errors: {},
      error: '',
      success: '',
    };
  },
  computed: {
    errorsNotPresent() {
      const errors = {};
      for(let e in this.errors) {
        if (!this.fields.find(field => field.key === e)) {
          errors[e] = this.errors[e];
        }
      }
      return errors;
    },
  },
  methods: {
    loadErrors(errors) {
      const loaded = {};
      if (errors) {
        for(let e in errors) {
          const a = `attributes.${e}`;
          loaded[a] = errors[e];
        }
      }
      this.$set(this, 'errors', loaded);
    },
    feedback(field) {
      const errors = this.errors;
      return (errors[field.key] || ['* ' + this.__('Required field')]).join('. ');
    },
    guardar() {
      return new Promise((accept, reject) => {
        this.success = '';
        this.state = null;
        if (this.value.id) {
          this.api.save(this.value).then((res) => {
            this.api.refresh(this.value);
            this.success = 'Los cambios se guardaron correctamente';
            this.state = true;
            accept(res);
          }).catch(res => {
            this.error = res.response.data.message;
            this.loadErrors(res.response.data.errors);
            this.state = false;
            reject(res);
          });
        } else {
          this.api.post(this.value).then((res) => {
            this.success = 'Los cambios se guardaron correctamente';
            this.state = true;
            accept(res);
          }).catch(res => {
            this.error = res.response.data.message;
            this.loadErrors(res.response.data.errors);
            this.state = false;
            reject(res);
          });
        }
      });
    },
  },
}
</script>

<style>
.form-datetime[required] {
    border-color: #e3342f;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23e3342f' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e3342f' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.4em + 0.1875rem) center;
    background-size: calc(0.8em + 0.375rem) calc(0.8em + 0.375rem);
}
.form-datetime[required][state="true"] {
  border-color:#38c172;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right calc(0.4em + 0.1875rem) center;
  background-size: calc(0.8em + 0.375rem) calc(0.8em + 0.375rem);
}
</style>