export const state = () => ({
  actions: [],
  activeActions:[],
  possibleCurrency: '',
  report:{
    startDate:null,
    endDate:null,
    income:null,
    tax:null
  }
});

export const actions = {
  async FETCH({commit}) {
    let data = await this.app.$axios.$get('/api/actions');

    commit('SET_ACTIONS', data);
  },
  async ADD_ACTION({commit},form){
    return await this.app.$axios.$post('/api/actions',form);
  },
  async DELETE_ACTION({commit},action){
    return await this.app.$axios.$delete('/api/actions/'+action[0].id)
  },
    async POSSIBLE_EXCHANGE({commit}){
      let data = await this.app.$axios.$post('/api/checksum',{"currency":"usd"})
      commit('SET_POSSIBLE_CURRENCY', data);
  },
  async GET_REPORT({commit},form){
    return await this.app.$axios.$post('/api/report',form)
  }
}

export const mutations = {
  SET_ACTIONS(state, actions) {
    state.actions = actions
  },
  SET_ACTIVE_ACTIONS(state, actions){
    state.activeActions = actions;
  },
  SET_POSSIBLE_CURRENCY(state, sum){
    state.possibleCurrency = sum;
  },
  SET_REPORT(state, report) {
    state.report.startDate =report.startDate;
    state.report.endDate =report.endDate;
    state.report.income =report.income;
    state.report.tax =report.tax;
  },


};

export const getters = {
  actions: s => s.actions,
  isActionsSelected: (state) => {
    return state.activeActions.length === 0;
  },

}
