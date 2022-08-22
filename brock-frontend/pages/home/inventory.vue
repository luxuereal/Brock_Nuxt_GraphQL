<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle>Home / Inventory</PageSubtitle>
      <PageTitle> Inventory </PageTitle>
    </template>

    <template #content>
      <InventoryContent />
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
import InventoryContent from '~/components/InventoryContent.vue'
export default {
  name: 'InventoryPage',
  components: {
    BasePageLayout,
    SideBar,
    PageTitle,
    PageSubtitle,
    InventoryContent,
  },
  mixins: [sideBarNavTabsMixin(HOME_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
