<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Home / ReAccruals</PageSubtitle>

      <PageTitle>ReAccruals</PageTitle>
    </template>

    <template #content>
      <ReAccrualsContent />
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
import ReAccrualsContent from '~/components/ReAccrualsContent.vue'
export default {
  name: 'ReAccrualsPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    ReAccrualsContent,
  },
  mixins: [sideBarNavTabsMixin(HOME_NAV_TABS)],
}
</script>

<style lang="scss" scoped></style>
