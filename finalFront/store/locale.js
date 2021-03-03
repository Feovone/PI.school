export const state = () => ({
  locales: process.env.VUE_APP_I18N_SUPPORTED_LOCALE.split(','),
  locale: process.env.VUE_APP_I18N_LOCALE
});

export const mutations = {
  SET_LANG(state, locale) {
    for (let key in state.locales) {
      if (state.locales[key] === locale) {
        state.locale = locale;
      }
    }
  }
};
