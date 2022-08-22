export const state = () => ({
    unit: '',
  })
  
  export const mutations = {
    SET_UNIT(state, payload) {
      state.unit = payload
    },
  }
  
  export const actions = {
    setUnit({ commit }, data) {
      commit('SET_UNIT', data)
    },
  }
  
  export const getters = {
    getUnit: (state) => state.unit,
  }
  