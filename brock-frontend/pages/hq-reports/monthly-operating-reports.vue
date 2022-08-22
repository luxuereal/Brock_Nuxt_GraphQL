<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Reports / Monthly Operating Reports </PageSubtitle>

      <PageTitle> Monthly Reports </PageTitle>
    </template>

    <template #content>
      <HQMonthlyOperatingReports />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_REPORT_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQMonthlyOperatingReports from '~/components/HQMonthlyOperatingReports.vue'
export default {
  name: 'MonthlyOperatingReportsPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQMonthlyOperatingReports,
  },
  mixins: [sideBarNavTabsMixin(HQ_REPORT_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
