<template>
  <nav class="navigation">
    <HeaderTab
      v-for="tab in mutableNav"
      :key="tab.id"
      :to="tab.to"
      :icon-src="tab.src"
      :name="tab.name"
    />
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import { HEADER_TABS, HQ_HEADER_TABS } from '../constants/constants'
import HeaderTab from './HeaderTab.vue'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";

export default {
  name: 'HeaderNavigation',
  components: { HeaderTab },
  data() {
    return {
      mutableNav: {},
      RolePrivileges: {}
    }
  },
  computed: {
    ...mapGetters({
      role: 'auth/getRole',
    }),
    headerTabs() {
      switch (this.role) {
        case 'admin':
          return HQ_HEADER_TABS
        default:
          return HEADER_TABS
      }
    },
  },
  watch: {
    headerTabs() {
      this.getMutableNav()
    },
  },
  mounted() {
    this.getMutableNav()
  },
  methods: {
    getMutableNav() {
      if(this.role !== 'admin') {
        this.getRolePrivileges()
      } else {
        this.mutableNav = this.headerTabs
      }
    },
    async getRolePrivileges() {
      const roleResponse = await this.$apollo.query({
        query: RolePrivileges,
        fetchPolicy: 'network-only'
      });
      this.RolePrivileges = roleResponse.data.RolePrivileges;
      this.verifyPermissions();
    },
    verifyPermissions() {
      this.mutableNav = [];
      this.redirectTabs = {};

      for (const item of this.headerTabs) {
        let addItem = !item.permissionTabs;
        const returnTabs = [];

        if (!addItem) {
          addItem = false;

          for (const subItem of item.permissionTabs) {
            
            const permissionsFilter = (subItem.permission && this.RolePrivileges) ? !!this.RolePrivileges.filter(privilege => {
              return (privilege.slugName === subItem.permission.slugName) && (privilege.permissionType === subItem.permission.permissionType)
            }).length : null;

            if (!subItem.permission || permissionsFilter)
              returnTabs.push(subItem);
          }

          if (returnTabs.length) {
            addItem = true;
          }
        }

        if (addItem) {
          this.mutableNav.push(item);

          if (returnTabs.length)
            this.redirectTabs[item.to] = returnTabs.map(a => a.pageUrl);
        }
      }

      this.$store.commit('tabsView/SET_REDIRECTS', this.redirectTabs);
    },
  },
}
</script>

<style lang="scss" scoped>
.navigation {
  display: flex;
  align-items: center;

  @media screen and (max-width: $lg) {
    flex-direction: column;
  }
}
</style>
