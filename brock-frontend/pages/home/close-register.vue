<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle>Home / Close Register</PageSubtitle>
      <PageTitle> Close Register </PageTitle>
    </template>

    <template #content>
      <CloseRegisterContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { HOME_NAV_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageTitle from '~/components/PageTitle'
import PageSubtitle from '~/components/PageSubtitle.vue'
import CloseRegisterContent from '~/components/CloseRegisterContent.vue'
export default {
  name: 'CloseRegisterPage',
  components: {
    BasePageLayout,
    SideBar,
    PageTitle,
    PageSubtitle,
    CloseRegisterContent,
  },
  mixins: [sideBarNavTabsMixin(HOME_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
}
</script>

<style lang="scss" scoped></style>
