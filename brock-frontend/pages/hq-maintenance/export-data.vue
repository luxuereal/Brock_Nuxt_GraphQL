<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Maintenance / Export Data </PageSubtitle>

      <PageTitle> Export Data </PageTitle>
    </template>

    <template #content>
      <HQExportPurchases />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_MAINTENANCE_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQExportPurchases from '~/components/HQExportPurchases.vue'
export default {
  name: 'HqMaintenanceExportData',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQExportPurchases,
  },
  mixins: [sideBarNavTabsMixin(HQ_MAINTENANCE_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
}
</script>

<style lang="scss" scoped></style>
