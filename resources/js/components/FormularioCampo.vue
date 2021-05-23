<template>
  <div v-if="field.key==='attributes.avatar'">
    <avatar v-model="value.attributes.avatar" style="font-size: 3em"></avatar>
    <div class="form-group">
      <div class="d-inline-block">
        <upload v-model="value.attributes.avatar" @change="updateAvatar">
          <button type="button" class="btn btn-primary">Cambiar imagen</button>
        </upload>
      </div>
    </div>
  </div>
  <b-form-group
    v-else-if="field.component"
    :label="withoutLabel ? '': field.label"
    label-size="sm"
    :state="state"
    :invalid-feedback="invalidFeedback"
  >
    <component :is="field.component" v-bind="field.properties" :value="getValue(value, field.key)" :state="state || fieldState(value, field)" @change="setValue(value, field.key, $event)" />
  </b-form-group>
  <b-form-group
    v-else
    :label="withoutLabel ? '': field.label"
    label-size="sm"
    :state="state"
    :invalid-feedback="invalidFeedback"
  >
    <b-form-input class="form-control" :type="field.type || 'text'" :state="state || fieldState(value, field)" :value="getValue(value, field.key)" @input="setValue(value, field.key, $event)" v-bind="field.properties" />
  </b-form-group>
</template>

<script>
import { get, set } from 'lodash';

export default {
  props: {
    field: Object,
    value: Object,
    state: Boolean,
    invalidFeedback: String,
    withoutLabel: Boolean,
  },
  methods: {
    fieldState(value, field) {
      if (field.properties && field.properties.required) {
        const text = this.getValue(value, field.key);
        return !!text;
      }
      return null;
    },
    updateAvatar(avatar) {
      this.value.attributes.avatar = avatar;
    },
    getValue(object, key) {
      return get(object, key);
    },
    setValue(object, key, value) {
      set(object, key, value);
    },
    setInputValue(object, key, event) {
      set(object, key, event.target.value);
    },
  },
}
</script>

<style>

</style>