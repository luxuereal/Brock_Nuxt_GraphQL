<template>
  <div>
    <div class="sidebar-mob" :class="{open:isShowSideBar}">
      <div class="sidebar-mob__header">
        <button type="button" class="sidebar-mob__close" @click="closeSidebar()">
          <img width="20px" src="~/assets/images/icons/icons8-close.svg"/>
        </button>
      </div>
      <HeaderNavigation/>
      <div class="sidebar-mob__item" @click="logout">
        <img src="~/assets/images/icons/logout-svgrepo-com.svg" width="22" height="22" class="icon"/>
        <span class="logout-item caption">Logout</span>
      </div>
      <div class="sidebar-mob__page">
        <SideBarNavigation :nav-tabs="menuItem"/>
      </div>
    </div>
    <div v-show="isShowSideBar" class="sidebar-mob-back" @click="closeSidebar"></div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import Logout from '../graphql/mutations/logout.gql'
import HeaderNavigation from './HeaderNavigation.vue'
import SideBarNavigation from './SideBarNavigation.vue'
import {HOME_NAV_TABS} from '~/constants/constants'
import {sideBarNavTabsMixin} from "~/mixins/sideBarNavTabsMixin"
import {submitMessagesMixin} from '~/mixins/submitMessagesMixin'

export default {
  name: "SideBarMob",

  components: {
    HeaderNavigation, SideBarNavigation
  },
  mixins: [sideBarNavTabsMixin(HOME_NAV_TABS), submitMessagesMixin],
  computed: {
    ...mapGetters({
      isShowSideBar: 'sidebar/getIsShowSideBar',
      menuItem: 'sidebar/getMenu',
    }),
  },
  methods: {
    closeSidebar() {
      this.$store.commit('sidebar/SET_IS_SHOW_SIDEBAR', !this.isShowSideBar)
    },
    async logout() {
      const {
        data: {logout},
      } = await this.$apollo.mutate({
        mutation: Logout,
      })

      if (logout.status === 'TOKEN_REVOKED') {
        const defaultClient = this.$apolloProvider.defaultClient
        this.$apolloHelpers.onLogout(defaultClient, true)
        defaultClient.stop()
        defaultClient.cache.reset()
        defaultClient.resetStore()
        this.showSubmitMessage(logout.message, 'success')
        this.$router.push('/login')
      }
    },
  }
}
</script>

<style lang="scss">
.sidebar-mob {
  position: fixed;
  width: 240px;
  left: -100%;
  top: 0;
  overflow: auto;
  height: 100vh;
  background: #fff;
  z-index: 9999;
  transition: left 0.25s;
  &-back{
    position: fixed;
    top: 0;
    left: 0;
    background: rgba(#000, 0.5);
    z-index: 111;
    height: 100%;
    width: 100%;
  }
  &.open {
    left: 0;
  }

  &__item {
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;

    &:hover {
      background: rgba(#000, 0.2);
    }
  }

  &__close {
    padding: 5px;
    background: transparent;
  }

  &__header {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 5px 10px;
  }

  .navigation {
    background: #2c2c2c;
  }

  .tab {
    display: flex !important;
    align-items: center !important;
    flex-direction: row !important;
    border-radius: 0 !important;
    padding: 10px;
    width: 100% !important;
    justify-content: flex-start;
    border: none;
    margin: 0;
    max-width: 100% !important;
  }

  .caption {
    margin: 0 0 0 15px;
  }

  &__page {
    .navigation {
      background: #fff;

      .caption {
        color: #2c2c2c;
      }

      .nuxt-link-active {
        .caption {
          color: #fff !important;
        }
      }
    }
  }
}
</style>
