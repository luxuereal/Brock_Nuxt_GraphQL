<template>
  <nav class="navigation">
    <SideBarTab
      v-for="tab in mutableNav"
      :key="tab.id"
      :page-url="tab.pageUrl"
      :icon-src="tab.iconSrc"
      :caption="tab.caption"
    />
  </nav>
</template>

<script>
import SideBarTab from './SideBarTab.vue'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";

export default {
  name: 'SideBarNavigation',
  components: {
    SideBarTab
  },
  props: {
    navTabs: {
      type: [Array, String],
      required: true,
    },
  },
  data() {
    return {
      mutableNav: {},
      RolePrivileges: {}
    }
  },
  watch: {
    navTabs() {
      this.getMutableNav()
    },
  },
  mounted() {
    this.getMutableNav()
  },
  methods: {
    getMutableNav() {
      if(this.role === 'admin') {
        this.getRolePrivileges()
      } else {
        this.mutableNav = this.navTabs
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

      for (const item of this.navTabs) {
        const permissionsFilter = (item.permission && this.RolePrivileges) ? !!this.RolePrivileges.filter(privilege => {
          return (privilege.slugName === item.permission.slugName) && (privilege.permissionType === item.permission.permissionType)
        }).length : null;

        if (!item.permission || permissionsFilter)
          this.mutableNav.push(item);
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.navigation {
  display: flex;
  flex-direction: column;
  width: 240px;

  &--active {
    @media screen and (max-width: $md) {
      position: absolute;
      width: 220px;
      height: 100%;
      background: white;
      z-index: 10;
    }
  }
}

.icon {
  cursor: pointer;
  transition: $transition;
  height: 24px;
  width: 24px;
  margin-left: 10px;
  margin-bottom: 10px;

  @media screen and (min-width: calc($lg + 1px)) {
    display: none;
  }

  &--active {
    transform: rotateY(180deg);
  }
}
</style>
