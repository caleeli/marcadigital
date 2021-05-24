<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fa fa-home"></i> {{ __("Home") }}
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <b-card>
      <b-card-body class="d-flex flex-row">
        <div class="mr-2">
          <b-button variant="primary" size="lg" to="/certificate">
            <i class="fas fa-upload"></i>
            {{ __("Upload certification") }}
          </b-button>
        </div>
        <div>
          <ul>
            <li>{{ __("Upload a scanned certification") }}</li>
            <li>{{ __("Link it to an educational organization") }}</li>
            <li>{{ __("Generate an unique digital certification UDC") }}</li>
            <li>{{ __("Share it in your networks") }}</li>
          </ul>
        </div>
      </b-card-body>
    </b-card>
    <div class="d-flex flex-row justify-content-center">
      <b-card
        v-for="item in items"
        :key="`item-${item.id}`"
        class="mt-2 ml-1 mr-1"
      >
        <dl>
          <dt>
            <b-link :to="`certificate/${item.id}`">
              {{ item.attributes.title }}
            </b-link>
          </dt>
          <dd>{{ item.attributes.organization }}</dd>
          <dd>
            {{ item.attributes.place + (item.attributes.place && ",") }}
            {{ item.attributes.date }}
          </dd>
        </dl>
        <div class="text-right">
          <b-button class="linkedin" size="sm" :href="linkedin(item)" target="_blank">
            <i class="fab fa-linkedin-in"></i>
          </b-button>
          <b-button-group class="mx-1">
            <b-button
              variant="outline-secondary"
              :to="`certificate/${item.id}`"
            >
              <i class="fas fa-pen"></i>
            </b-button>
            <b-button
              variant="outline-secondary"
              :href="`/credential/${item.id}`"
              target="_blank"
            >
              <i class="far fa-eye"></i>
            </b-button>
            <b-button variant="outline-secondary" @click="dropItem(item)">
              <i class="fas fa-trash"></i>
            </b-button>
          </b-button-group>
        </div>
      </b-card>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin],
  data() {
    return {
      items: this.$api.user[`${window.userId}/certifications`].array(),
    };
  },
  methods: {
    dropItem(item) {
      this.$bvModal
        .msgBoxConfirm(this.__("Are you sure to delete this item?"))
        .then((value) => {
          this.$api.certification.delete(item.id).then(() => {
            this.refresh();
          });
        });
    },
    refresh() {
      this.$api.user[`${window.userId}/certifications`].refresh(this.items);
    },
    linkedin(item) {
      const url = `${window.location.origin}/credential/${item.id}`;
      const certId = item.attributes.credential_id;
      const date = new Date(`${item.attributes.date} 00:00:00`);
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name=${encodeURIComponent(item.attributes.title)}&organizationName=${encodeURIComponent(item.attributes.organization)}&issueYear=${year}&issueMonth=${month}&certUrl=${encodeURIComponent(url)}&certId=${encodeURIComponent(certId)}&credentialDoesNotExpire=1`;
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
