<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Admin / Fixed Expenses </PageSubtitle>

      <PageTitle> Fixed Expenses </PageTitle>
    </template>

    <template #content>
      <FixedExpensesContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { ADMIN_NAV_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import FixedExpensesContent from '~/components/FixedExpensesContent.vue'
export default {
  name: 'FixedExpensesPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    FixedExpensesContent,
  },
  mixins: [sideBarNavTabsMixin(ADMIN_NAV_TABS)],
}
</script>

<style lang="scss" scoped></style>
