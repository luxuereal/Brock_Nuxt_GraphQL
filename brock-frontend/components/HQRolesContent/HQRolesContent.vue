<template>
  <div>
    <component :is="isShowAddRole" />
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'HQRolesContent',
  computed: {
    ...mapGetters({
      isShowAddRole: 'roles/getShowAddRole',
    }),
  },
  destroyed() {
    this.setUpdateRole({
      roleName: '',
      permissions: '',
    })
    this.setShowAddRole('HQRoles')
  },
  methods: {
    ...mapActions({
      setUpdateRole: 'roles/setUpdateRole',
      setShowAddRole: 'roles/setShowAddRole',
    }),
  },
}
</script>

<style scoped></style>
