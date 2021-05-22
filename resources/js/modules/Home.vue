<template>
  <panel class="panel-secondary">
    <template slot="header">
      <title-bar /> <i class="fa fa-home"></i> {{ __('Home') }}
    </template>
    <template slot="actions">
      <nav-bar />
    </template>
    <b-card>
      <b-card-body class="d-flex flex-row">
        <div class="mr-2">
          <b-button variant="primary" size="lg" to="/upload_certificate">
            <i class="fas fa-upload"></i>
            {{ __('Upload certification') }}
          </b-button>
        </div>
        <div>
          <ul>
            <li>Upload a scanned certification</li>
            <li>Link it to an educational organization</li>
            <li>Generate an unique digital certification ID</li>
            <li>Share it to you networks</li>
          </ul>
        </div>
      </b-card-body>
    </b-card>
  </panel>
</template>

<script>
export default {
  path: "/",
  mixins: [window.ResourceMixin],
  data() {
    return {
    };
  }
};
</script>
