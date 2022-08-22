<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Accounting / Expense Types </PageSubtitle>

      <PageTitle> Expense Types </PageTitle>
    </template>

    <template #content>
      <HQExpenseTypesContent />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_ACCOUNTING } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQExpenseTypesContent from '~/components/HQExpenseTypesContent.vue'
export default {
  name: 'ExpenseTypesPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQExpenseTypesContent,
  },
  mixins: [sideBarNavTabsMixin(HQ_ACCOUNTING)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
