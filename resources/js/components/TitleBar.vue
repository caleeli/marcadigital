<template>
  <span>
    <img class="logo" :src="logo">
  </span>
</template>

<script>
import logo from '../../images/logo.svg';

export default {
  data() {
    return {
      logo
    }
  },
}
</script>

<style>
.logo {
  height: 2em;
}
</style>