export const state = () => ({
  showMessage: false,
  messageType: '',
  message: '',
})

export const mutations = {
  SET_SHOW_MESSAGE(state, payload) {
    state.showMessage = payload
  },
  SET_MESSAGE_TYPE(state, payload) {
    state.messageType = payload
  },
  SET_MESSAGE(state, payload) {
    state.message = payload
  },
}

export const actions = {
  setShowMessage({ commit }, data) {
    commit('SET_SHOW_MESSAGE', data)
  },
  setMessageType({ commit }, data) {
    commit('SET_MESSAGE_TYPE', data)
  },
  setMessage({ commit }, data) {
    commit('SET_MESSAGE', data)
  },
}

export const getters = {
  getShowMessage: (state) => state.showMessage,
  getMessageType: (state) => state.messageType,
  getMessage: (state) => state.message,
}
