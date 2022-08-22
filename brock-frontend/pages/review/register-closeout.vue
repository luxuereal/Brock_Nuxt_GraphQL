<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Review / Register Closeout </PageSubtitle>

      <PageTitle> Register Closeout </PageTitle>
    </template>

    <template #content>
      <RegisterCloseoutReviewContent />
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
import RegisterCloseoutReviewContent from '~/components/RegisterCloseoutReviewContent.vue'
export default {
  name: 'RegisterCloseout',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    RegisterCloseoutReviewContent,
  },
  mixins: [sideBarNavTabsMixin(REVIEW_NAV_TABS)],
}
</script>

<style lang="scss" scoped></style>
