export const state = () => ({
  tempId: Math.random(),
})

export const mutations = {
  SET_TEMP_ID(state, payload) {
    state.tempId = payload
  },
}

export const getters = {
  getTempId: (state) => state.tempId,
}
