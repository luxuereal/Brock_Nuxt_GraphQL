<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Unit Setup / Unit Period Status </PageSubtitle>

      <PageTitle> Unit Period Status </PageTitle>
    </template>

    <template #content>
      <HQUnitPeriodStatusContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_UNITS_TABS } from '~/constants/constants'
import { unitMaintenanceMixin } from '~/mixins/unitMaintenanceMixin'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQUnitPeriodStatusContent from '~/components/HQUnitPeriodStatusContent.vue'
export default {
  name: 'UnitPeriodStatusPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQUnitPeriodStatusContent,
  },
  mixins: [unitMaintenanceMixin, sideBarNavTabsMixin(HQ_UNITS_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
