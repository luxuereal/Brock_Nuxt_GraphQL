<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Reports / Multi Unit Labor Report </PageSubtitle>

      <PageTitle> Labor Schedule Report </PageTitle>
    </template>

    <template #content>
      <HQLaborScheduleReport />
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
export default {
  name: 'LaborScheduleReport',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
  },
  mixins: [sideBarNavTabsMixin(HQ_REPORT_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
