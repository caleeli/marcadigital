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
      <b-card v-for="item in items" :key="`item-${item.id}`" class="mt-2 ml-1 mr-1">
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
};
</script>
