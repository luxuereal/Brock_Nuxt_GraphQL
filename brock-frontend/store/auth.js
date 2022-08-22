export const state = () => ({
  role: '',
})

export const mutations = {
  SET_ROLE(state, payload) {
    state.role = payload
  },
}

export const actions = {
  setRole({ commit }, data) {
    commit('SET_ROLE', data)
  },
}

export const getters = {
  getRole: (state) => state.role,
}
