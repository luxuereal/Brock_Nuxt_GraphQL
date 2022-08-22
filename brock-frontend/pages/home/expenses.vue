<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Home / Expenses</PageSubtitle>

      <PageTitle>Expenses</PageTitle>
    </template>

    <template #content>
      <ExpensesContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { HOME_NAV_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import ExpensesContent from '~/components/ExpensesContent.vue'
export default {
  name: 'ExpensesPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    ExpensesContent,
  },
  mixins: [sideBarNavTabsMixin(HOME_NAV_TABS)],

}
</script>

<style lang="scss" scoped></style>
