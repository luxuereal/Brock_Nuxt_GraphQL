<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Review / Weekly Purchases </PageSubtitle>

      <PageTitle> Weekly Purchases </PageTitle>
    </template>

    <template #content>
      <WeeklyPurchasesContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { REVIEW_NAV_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import WeeklyPurchasesContent from '~/components/WeeklyPurchasesContent.vue'
export default {
  name: 'WeeklyPurchasesPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    WeeklyPurchasesContent,
  },
  mixins: [sideBarNavTabsMixin(REVIEW_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
