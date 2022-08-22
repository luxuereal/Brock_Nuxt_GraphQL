import { mapActions } from 'vuex'
export const setRoleMixin = {
  methods: {
    ...mapActions({
      setRole: 'auth/setRole',
    }),
  },
}
