<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Unit Setup / Registers </PageSubtitle>

      <PageTitle> Register Maintenance </PageTitle>
    </template>

    <template #content>
      <HQRegistersContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_UNITS_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQRegistersContent from '~/components/HQRegistersContent.vue'
export default {
  name: 'RegistersPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQRegistersContent,
  },
  mixins: [sideBarNavTabsMixin(HQ_UNITS_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
