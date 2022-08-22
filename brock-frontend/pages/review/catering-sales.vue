<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Review /Catering Sales </PageSubtitle>

      <PageTitle>Catering Sales </PageTitle>
    </template>

    <template #content>
      <CateringSalesReviewContent />
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
import CateringSalesReviewContent from '~/components/CateringSalesReviewContent.vue'
export default {
  name: 'CateringSalesReview',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    CateringSalesReviewContent,
  },
  mixins: [sideBarNavTabsMixin(REVIEW_NAV_TABS)],
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
