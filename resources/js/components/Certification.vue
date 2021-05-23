<template>
  <b-card>
    <b-card-body class="d-flex flex-row flex-nowrap">
      <div :style="`width:${form.attributes.width}%`">
        <img
          :src="form.attributes.image && form.attributes.image.url"
          width="100%"
          class="cert-frame"
        />
      </div>
      <div :class="form.attributes.style" class="p-4" :style="`width:${100-form.attributes.width}%`">
        <h1 class="titulo" v-if="$root.user.attributes">
          {{ $root.user.attributes.name }}
        </h1>
        <h1 class="titulo">
          <b>{{ form.attributes.title }}</b>
        </h1>
        <h2 class="orga">
          {{ form.attributes.organization }}
        </h2>
        <a :href="form.attributes.organization_url">{{
          form.attributes.organization_url
        }}</a>
        <p>
          {{ form.attributes.place + (form.attributes.place && ',') }} {{ format(form.attributes.date) }}
        </p>
      </div>
    </b-card-body>
  </b-card>
</template>

<script>
export default {
  props: {
    form: Object,
  },
  methods: {
    format(str) {
      try {
        const date = new Date(`${str} 00:00:00`);
        const formatter = new Intl.DateTimeFormat([], {
          dateStyle: "long",
        });
        return formatter.format(date);
      } catch (e) {
        return str;
      }
    },
  },
};
</script>

<style>
.titulo {
  font-size: 2vw;
}
.orga {
  font-size: 1.5vw;
}
.serif * {
  font-family: "Times New Roman", Times, serif;
}
.sans-serif * {
  font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
}
.cert-frame {
  -webkit-box-shadow: 0 0 16px 0px gray;
  box-shadow: 0 0 16px 0px gray;
}
</style>