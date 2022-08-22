<template>
  <div>
    <component :is="isShowAddUser" />
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'HQUsersContent',
  computed: {
    ...mapGetters({
      isShowAddUser: 'users/getShowAddUser',
    }),
  },
  destroyed() {
    this.setUpdateUser({
      firstName: '',
      lastName: '',
      email: '',
      unit: '',
      isAdmin: false,
      isActive: false,
    })
    this.setShowAddUser('HQUsers')
  },
  methods: {
    ...mapActions({
      setUpdateUser: 'users/setUpdateUser',
      setShowAddUser: 'users/setShowAddUser',
    }),
  },
}
</script>

<style scoped></style>
