<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fas fa-certificate"></i> {{ __("Certificate") }}
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <formulario ref="form" :value="form" :fields="fields" :api="api" />
    <b-form-group
      id="group-credential_id"
      :label="__('Credential ID')"
      label-for="form.attributes.credential_id"
    >
      <b-form-input
        id="form.attributes.credential_id"
        v-model="form.attributes.credential_id"
        type="text"
        readonly
      />
    </b-form-group>
    <div class="d-flex justify-content-between">
      <div>
        <b-button variant="primary" @click="save">
          <i class="fas fa-save"></i>
          {{ form.id ? __("Save") : __("Generate Unique Digital Certificacion") }}
        </b-button>
      </div>
      <div v-if="form.id">
        {{ __("Share it") }}:
        <b-button class="linkedin" size="sm" :href="linkedin()" target="_blank"><i class="fab fa-linkedin-in"></i></b-button>
      </div>
    </div>
    <p>{{ __("Preview") }}:</p>
    <certification :form="form" />
  </panel>
</template>

<script>
import QRCode from "qrcode";

export default {
  path: "/certificate/:id?",
  mixins: [window.ResourceMixin],
  data() {
    let form = {
      id: null,
      attributes: {
        image: null,
        title: "",
        organization: "",
        organization_url: "",
        place: "",
        date: "",
        width: "60",
        style: "serif",
        credential_id: "",
        qrcode: "",
      },
    };
    if (this.$route.params.id) {
      form = this.$api.certifications.row(this.$route.params.id, {}, form);
    } else {
    }
    return {
      api: this.$api.user[`${window.userId}/certifications`],
      form,
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
          properties: {
            required: true,
          },
        },
        {
          key: "attributes.organization",
          label: this.__("Issuing organization"),
          create: true,
          edit: true,
          properties: {
            required: true,
          },
        },
        {
          key: "attributes.organization_url",
          label: this.__("Issuing organization URL"),
          create: true,
          edit: true,
          type: "url",
          properties: {
            required: true,
          },
        },
        {
          key: "attributes.place",
          label: this.__("Issue place"),
          create: true,
          edit: true,
          properties: {
            required: true,
          },
        },
        {
          key: "attributes.date",
          label: this.__("Issue date"),
          create: true,
          edit: true,
          component: "datetime",
          properties: { type: "date", format: "YYYY-MM-DD", required: true },
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
  methods: {
    linkedin() {
      const url = this.url();
      const certId = this.form.attributes.credential_id;
      const date = new Date(`${this.form.attributes.date} 00:00:00`);
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name=${encodeURIComponent(this.form.attributes.title)}&organization=${encodeURIComponent(this.form.attributes.organization)}&issueYear=${year}&issueMonth=${month}&certUrl=${encodeURIComponent(url)}&certId=${encodeURIComponent(certId)}&credentialDoesNotExpire=1`;
    },
    url() {
      return `${window.location.origin}/credential/${this.form.id}`;
    },
    save() {
      return this.$refs.form.guardar().then((res) => {
        const data = res.data;
        if (!this.form.id && data instanceof Array && data[0]) {
          this.form.id = data[0].id;
          this.form.attributes.credential_id = data[0].credential_id;
        }
        QRCode.toDataURL(
          this.url()
        ).then((url) => {
          if (this.form.attributes.qrcode !== url) {
            this.form.attributes.qrcode = url;
            this.$refs.form.guardar().then(() => {
              this.$router.push(`/certificate/${this.form.id}`);
            });
          } else {
            this.$router.push(`/certificate/${this.form.id}`);
          }
        });
      });
    },
  },
};
</script>

<style scoped>
.linkedin {
  background-color: #007bb5;
  color: white;
}
</style>
