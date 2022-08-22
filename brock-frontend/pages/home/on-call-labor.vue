<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Home / On-Call Labor </PageSubtitle>

      <PageTitle> On-Call Labor </PageTitle>
    </template>

    <template #content>
      <OnCallLaborContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { HOME_NAV_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import OnCallLaborContent from '~/components/OnCallLaborContent.vue'
export default {
  name: 'OnCallLaborPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    OnCallLaborContent,
  },
  mixins: [sideBarNavTabsMixin(HOME_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
