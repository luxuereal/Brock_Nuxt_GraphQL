<template>
  <div class="container">
    <TheHeader />
    <SideBarMob />
    <div class="nuxt-container">
      <Nuxt />
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import TheHeader from '@/components/TheHeader'
import SideBarMob from '@/components/SideBarMob'
export default {
  name: 'HQLayout',
  components: {
    TheHeader,
    SideBarMob
  },
  middleware: ['isAuth', 'authAdmin'],
  computed: {
    ...mapGetters({
      isShowSideBar: 'sidebar/getIsShowSideBar',
    }),
  },
  watch: {
    '$route' () {
      if(window.innerWidth < 1024){
        this.$store.commit('sidebar/SET_IS_SHOW_SIDEBAR', !this.isShowSideBar)
      }
    }
  },
  beforeMount() {
    this.setRole('admin')
  },
  methods: {
    ...mapActions({
      setRole: 'auth/setRole',
    }),
  },

}
</script>

<style lang="scss" scoped>
.container {
  min-height: 100vh;
}

.nuxt-container {
  display: flex;
  justify-content: center;
  min-height: calc(100vh - 100px);
}
</style>
