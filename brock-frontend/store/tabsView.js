export const state = () => ({
  activeTab: 0,
  allowSwitch: true,
  redirects: [],
  activeValidate: '',
})

export const mutations = {
  SET_ACTIVE_TAB(state, payload) {
    state.activeTab = payload
  },
  SET_ALLOW_SWITCH(state, payload) {
    state.allowSwitch = payload
  },
  SET_REDIRECTS(state, payload) {
    state.redirects = payload
  },
  SET_ACTIVE_VALIDATE(state, payload) {
    state.activeValidate = payload
  }
}

export const getters = {
  getActiveTab: (state) => state.activeTab,
  getAllowSwitch: (state) => state.allowSwitch,
  getRedirects: (state) => state.redirects,
  getActiveValidate: (state) => state.activeValidate,
}
