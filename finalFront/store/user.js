export const state = () => ({
  userPhoto: null,
});

export const actions = {
  async FETCH({commit},conversion) {
    await this.app.$axios.$get('/api/userPhotoIndex?conversion='+conversion, {responseType: 'blob',}).then((response) => {
      let url = window.URL.createObjectURL(new Blob([response]));
      commit('SET_PHOTO', url);
    });

  },
  async EDIT_PROFILE({commit}, form) {
    return await this.app.$axios.$patch('/api/user/' + this.$auth.user.id, form)
  },
}
export const mutations = {
  SET_PHOTO(state, photo) {
    state.userPhoto = photo
  },
}
