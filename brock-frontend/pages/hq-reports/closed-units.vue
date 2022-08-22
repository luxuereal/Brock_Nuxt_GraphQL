<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Reports / Closed Units </PageSubtitle>

      <PageTitle> Closed Units </PageTitle>
    </template>

    <template #content>
      <HQClosedUnitsContent />
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
import HQClosedUnitsContent from '~/components/HQClosedUnitsContent.vue'
export default {
  name: 'MonthlyOperatingReportsPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQClosedUnitsContent,
  },
  mixins: [sideBarNavTabsMixin(HQ_REPORT_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
}
</script>

<style lang="scss" scoped></style>
