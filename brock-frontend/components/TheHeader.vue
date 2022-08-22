<template>
  <header class="header">
    <div class="container">
      <div class="header-left">
        <NuxtLink to="/" class="logo">
          <img src="~assets/images/header/logo.svg" />
        </NuxtLink>

        <button v-if="!onlyLogo" type="button" class="btn-humburger" @click="setIsShowSideBar"><img src="~assets/images/icons/menu.svg"></button>

        <div class="nav">
          <HeaderNavigation v-if="!onlyLogo" />
        </div>
      </div>

      <div v-if="!onlyLogo" class="profile">
        <img v-if="avatarResource == '' || avatarResource == null" src="~assets/images/header/avatar.svg" />
        <img v-else :src="avatarResource"/>

        <svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
          class="icon"
          :class="{
            'icon--active': isShowDropdown,
          }"
          @click="isShowDropdown = !isShowDropdown"
        >
          <path
            d="M15.8798 9.29006L11.9998 13.1701L8.11979 9.29006C7.72978 8.90006 7.09978 8.90006 6.70978 9.29006C6.31978 9.68006 6.31978 10.3101 6.70978 10.7001L11.2998 15.2901C11.6898 15.6801 12.3198 15.6801 12.7098 15.2901L17.2998 10.7001C17.6898 10.3101 17.6898 9.68006 17.2998 9.29006C16.9098 8.91006 16.2698 8.90006 15.8798 9.29006Z"
            fill="white"
          />
        </svg>
        <div v-if="isShowDropdown" class="profile-menu">
          <div class="nav--mobile">
            <HeaderNavigation v-if="!onlyLogo" />
          </div>

          <div class="menu-item" @click="profile">
            My Profile
          </div>
          <div class="menu-item" @click="logout">
            Logout
          </div>
        </div>
        <!-- <div v-if="isShowDropdown" class="logout">
          <div class="nav--mobile">
            <HeaderNavigation v-if="!onlyLogo" />
          </div>
          <span class="logout-item" @click="logout">Logout</span>
        </div> -->
      </div>
    </div>
  </header>
</template>

<script>
import { mapGetters } from 'vuex'
import Logout from '../graphql/mutations/logout.gql'
import HeaderNavigation from './HeaderNavigation.vue'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import Me from '~/graphql/queries/me.query.gql'

export default {
  name: 'TheHeader',
  components: { HeaderNavigation },
  mixins: [submitMessagesMixin],
  props: {
    onlyLogo: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      avatarResource: '',

      isShowDropdown: false,
      isShowSideBar:false,
    }
  },
  computed: {
    ...mapGetters ({
      getUpdated: 'profile/getUpdated'
    })
  },
  watch: {
    getUpdated() {
      this.fetchData()
    }
  },
  beforeMount() {
    if(!this.onlyLogo) {
      this.fetchData();
    }
  },
  methods: {
    fetchData() {
        this.me = {};
        this.getMyData().then((me) => {
          if ( me !== undefined ) {
            this.avatarResource = me.avatar != null ? process.env.BASE_URL + me.avatar : '';
          }
        });
    },
    async getMyData() {
        const me = await this.$apollo.query({
            query: Me,
            fetchPolicy: 'network-only'
        });
        return me.data.me;
    },
    setIsShowSideBar() {
      this.$store.commit('sidebar/SET_IS_SHOW_SIDEBAR', !this.isShowSideBar)
    },
    profile() {
      this.$router.push('/profile')
    },
    async logout() {
      const {
        data: { logout },
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
  },
}
</script>

<style lang="scss" scoped>
.header {
  position: sticky;
  left: 0;
  top: 0;
  width: 100%;
  z-index: 10;
  background: $nero;

  &-left {
    display: flex;
  }
  .container{
    @media screen and (max-width: $lg) {
      padding: 24px 10px;
    }
  }
}

.btn-humburger{
  background: transparent;
  @media screen and (min-width: $lg) {
    display: none;
  }
}

.nav {
  @media screen and (max-width: $lg) {
    display: none;
  }

  &--mobile {
    @media screen and (min-width: calc($lg + 1px)) {
      display: none;
    }
  }
}

.logo {
  display: flex;
  margin-right: 80px;

  img {
    @media screen and (min-width: $lg) {
      height: 82px;
      width: 135px;
    }
    @media screen and (max-width: $lg) {
      height: 30px;
    }
  }
}

.header-left{
  @media screen and (max-width: $lg) {
    width: 100%;
    justify-content: space-between;
  }
}

.container {
  display: flex;
  justify-content: space-between;
  max-width: $xxl;
  margin: 0 auto;
  padding: 10px 40px 10px;
}

.profile {
  position: relative;
  display: flex;
  align-items: center;
  @media screen and (max-width: $lg) {
    display: none;
  }
  img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }
}

.profile-menu {
  position: absolute;
  right: 0;
  bottom: calc(-100%);
  width: 100px;

  background: #ffffff;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4),
    -2px 0px 4px rgba(0, 0, 0, 0.1);
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;

  display: flex;
  flex-direction: column;

  .menu-item {
    width: 100%;
    padding: 10px;
    display: flex;
    align-items: center;

    &:not(:last-child) {
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    &:last-child {
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    cursor: pointer;
    transition: .2s all;
    &:hover {
      color: $firebrick;
      background: #EFEFEF;
    }
  }
}

.icon {
  cursor: pointer;
  transition: $transition;

  &--active {
    transform: rotateX(180deg);
  }
}
</style>
