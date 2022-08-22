export const state = () => ({
    updated: '',
  })
  
  export const mutations = {
    SET_UPDATED(state, payload) {
      state.updated = payload
    },
  }
  
  export const actions = {
    setUpdated({ commit }, data) {
      commit('SET_UPDATED', data)
    },
  }
  
  export const getters = {
    getUpdated: (state) => state.updated,
  }
  