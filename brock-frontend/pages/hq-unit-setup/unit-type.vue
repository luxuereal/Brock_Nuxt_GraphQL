<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Unit Setup / Unit Info </PageSubtitle>

      <PageTitle> Unit Type </PageTitle>
    </template>

    <template #content>
      <HQUnitTypeContent />
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
import HQUnitTypeContent from '~/components/HQUnitTypeContent'
export default {
  name: 'UnitTypePage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQUnitTypeContent,
  },
  mixins: [unitMaintenanceMixin, sideBarNavTabsMixin(HQ_UNITS_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
