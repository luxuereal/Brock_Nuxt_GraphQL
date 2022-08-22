<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Review / Weekly Expenses </PageSubtitle>

      <PageTitle> Weekly Expenses </PageTitle>
    </template>

    <template #content>
      <WeeklyExpensesContent />
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
import WeeklyExpensesContent from '~/components/WeeklyExpensesContent.vue'
export default {
  name: 'WeeklyPurchasesPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    WeeklyExpensesContent,
  },
  mixins: [sideBarNavTabsMixin(REVIEW_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
}
</script>

<style lang="scss" scoped></style>
