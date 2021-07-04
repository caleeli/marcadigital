<template>
  <b-card>
    <b-card-body class="d-flex flex-row flex-nowrap">
      <div :style="`width:${form.attributes.width}%`">
        <svg :viewBox="viewBox" width="100%">
          <image
            :href="form.attributes.image && form.attributes.image.url"
            :width="width"
            :height="height"
            :transform="transform"
          />
        </svg>
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
        <p>
          <img v-if="form.attributes.qrcode" :src="form.attributes.qrcode" width="128px">
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
  data() {
    return {
      rotation: 1,
      width: 210,
      height: 279,
    };
  },
  computed: {
    viewBox() {
      return this.form.attributes.rotation == 0 || this.form.attributes.rotation == 2 ? '0 0 210 279' : '0 0 279 210';
    },
    transform() {
      switch(parseInt(this.form.attributes.rotation)) {
        case 0:
          return '';
        case 1:
          return 'rotate(90 139.5 139.5)';
        case 2:
          return 'rotate(180 105 105)';
        case 3:
          return 'rotate(270 105 105)';
      }
    },
  },
  methods: {
    getImageSize(imgSrc) {
      return new Promise(resolve => {
        const newImg = new Image();
        newImg.src = imgSrc;
        console.log(newImg);
        newImg.addEventListener('load', () => {
          resolve({width: newImg.width, height: newImg.height});
        });
      })
    },
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
  watch: {
    'form.attributes': {
      deep: true,
      handler() {
        const url = this.form.attributes.image && this.form.attributes.image.url;
        if (url) {
          console.log(url);
          this.getImageSize(url).then(size => {
            this.height = this.width / size.width * size.height;
          });
        }
      }
    }
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