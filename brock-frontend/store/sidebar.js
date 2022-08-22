export const state = () => ({
  isShowSideBar: false,
  menu: '',
})

export const mutations = {
  SET_IS_SHOW_SIDEBAR(state, payload) {
    state.isShowSideBar = payload
  },
  SET_MENU(state, payload) {
    state.menu = payload
  },
}

export const getters = {
  getIsShowSideBar: (state) => state.isShowSideBar,
  getMenu: (state) => state.menu,
}
