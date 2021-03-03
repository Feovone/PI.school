<template>
  <div>
    <b-dropdown-item class="minw-none" v-for="locale in locales" :key="locale" @click="switchLocale(locale)">
      {{ $t('lang.' + locale) }}
    </b-dropdown-item>
  </div>
</template>

<script>
export default {
  name: "Locale",
  methods: {
    switchLocale(locale) {
      if (this.$i18n.locale !== locale) {
        this.$i18n.locale = locale;
        document.cookie = "locale = " + locale + ";max-age=" + 30 * 24 * 60 * 60;
      }
    },
  },
  data() {
    return {
      locales: process.env.VUE_APP_I18N_SUPPORTED_LOCALE.split(',')
    }
  }
}
</script>

<style scoped>
li {
  list-style-type: none;
  text-decoration: none;
  cursor: pointer;
}

</style>
