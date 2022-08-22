export const state = () => ({
  showAddRole: 'HQRoles',
  updateRole: {
    roleName: '',
    permissions: '',
  },
})

export const mutations = {
  SET_SHOW_ADD_ROLE(state, payload) {
    state.showAddRole = payload
  },
  SET_UPDATE_ROLE(state, payload) {
    state.updateRole.id = payload.id
    state.updateRole.roleName = payload.name
    state.updateRole.permissions = payload.roleMenus
  },
  SET_UPDATE_ROLE_NAME(state, payload){
    state.updateRole.roleName = payload
  },
  SET_UPDATE_ROLE_PERMISSIONS(state, payload){
    state.updateRole.permissions = payload
  }
}

export const actions = {
  setShowAddRole({ commit }, data) {
    commit('SET_SHOW_ADD_ROLE', data)
  },
  setUpdateRole({ commit }, data){
    commit('SET_UPDATE_ROLE', data)
  }
}

export const getters = {
  getShowAddRole: (state) => state.showAddRole,
  getUpdateRole: (state) => state.updateRole,
}
