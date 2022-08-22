<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Reports / Open Report </PageSubtitle>

      <PageTitle> Open Report </PageTitle>
    </template>

    <template #content>
      <OpenReportContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { REPORTS_NAV_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import OpenReportContent from '~/components/OpenReportContent.vue'
export default {
  name: 'OpenReportPage',
    components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    OpenReportContent
  },
  mixins: [sideBarNavTabsMixin(REPORTS_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
