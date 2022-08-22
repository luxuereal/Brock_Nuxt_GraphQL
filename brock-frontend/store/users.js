export const state = () => ({
  showAddUser: 'HQUsers',
  updateUser: {
    firstName: '',
    lastName: '',
    email: '',
    unit: '',
    isAdmin: false,
    isActive: false,
    role: null,
  },
})

export const mutations = {
  SET_SHOW_ADD_USER(state, payload) {
    state.showAddUser = payload
  },
  SET_UPDATE_USER(state, payload) {
    state.updateUser.id = payload.id
    state.updateUser.firstName = payload.firstName
    state.updateUser.lastName = payload.lastName
    state.updateUser.email = payload.email
    state.updateUser.unit = payload.units
    state.updateUser.isAdmin = payload.isAdmin
    state.updateUser.isActive = payload.isActive
    state.updateUser.role = payload.role
  },
  SET_UPDATE_USER_FIRSTNAME(state, payload){
    state.updateUser.firstName = payload
  },
  SET_UPDATE_USER_LASTNAME(state, payload){
    state.updateUser.lastName = payload
  },
  SET_UPDATE_USER_EMAIL(state, payload){
    state.updateUser.email = payload
  },
  SET_UPDATE_USER_UNIT(state, payload){
    state.updateUser.unit = payload
  },
  SET_UPDATE_USER_IS_ADMIN(state, payload){
    state.updateUser.isAdmin = payload
  },
  SET_UPDATE_USER_IS_ACTIVE(state, payload){
    state.updateUser.isActive = payload
  },
  SET_UPDATE_USER_ROLE(state, payload){
    state.updateUser.role = payload
  }
}

export const actions = {
  setShowAddUser({ commit }, data) {
    commit('SET_SHOW_ADD_USER', data)
  },
  setUpdateUser({ commit }, data){
    commit('SET_UPDATE_USER', data)
  }
}

export const getters = {
  getShowAddUser: (state) => state.showAddUser,
  getUpdateUser: (state) => state.updateUser,
}
