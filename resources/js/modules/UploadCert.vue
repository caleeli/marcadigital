<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fa fa-users"></i> {{ __("User") }}
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <formulario
      ref="form"
      :value="form"
      :fields="fields"
      :api="api"
    />
    <b-button variant="primary" @click="$refs.form.guardar()">
      <i class="fas fa-save"></i>
      {{ __('Generate Unique Digital Certificacion') }}
    </b-button>
    <p>Preview:</p>
    <certification :form="form" />
  </panel>
</template>

<script>
export default {
  path: "/upload_certificate",
  mixins: [window.ResourceMixin],
  data() {
    return {
      api: this.$api.user[`${window.userId}/certifications`],
      form: {
        attributes: {
          image: null,
          title: "",
          organization: "",
          organization_url: "",
          place: "",
          date: "",
          width: "60",
          style: "serif",
        },
      },
      fields: [
        {
          key: "attributes.image",
          label: "",
          create: true,
          edit: true,
          component: "UploadCertificate",
        },
        {
          key: "attributes.title",
          label: this.__("Title"),
          create: true,
          edit: true,
        },
        {
          key: "attributes.organization",
          label: this.__("Issuing organization"),
          create: true,
          edit: true,
        },
        {
          key: "attributes.organization_url",
          label: this.__("Issuing organization URL"),
          create: true,
          edit: true,
          type: "url",
        },
        {
          key: "attributes.place",
          label: this.__("Issue place"),
          create: true,
          edit: true,
        },
        {
          key: "attributes.date",
          label: this.__("Issue date"),
          create: true,
          edit: true,
          component: 'datetime',
          properties: { type: "date", format: "YYYY-MM-DD" },
        },
        {
          key: "attributes.width",
          label: this.__("Width"),
          create: true,
          edit: true,
          type: "range",
          properties: { min: "0", max: "100", step: "10" },
        },
        {
          key: "attributes.style",
          label: this.__("Style"),
          create: true,
          edit: true,
          component: "Serif",
        },
      ],
    };
  },
};
</script>

<style scoped>
</style>
