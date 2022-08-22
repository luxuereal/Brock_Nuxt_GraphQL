import { mapGetters } from 'vuex'
export const tabsViewMixin = {
  computed: {
    ...mapGetters({
      activeTab: 'tabsView/getActiveTab',
      activeValidate: 'tabsView/getActiveValidate'
    }),
  },
  destroyed() {
    this.$store.commit('tabsView/SET_ACTIVE_TAB', 0)
  },
  methods: {
    nextTab() {
      this.$store.commit('tabsView/SET_ACTIVE_TAB', this.activeTab + 1)
    },
  },
}
