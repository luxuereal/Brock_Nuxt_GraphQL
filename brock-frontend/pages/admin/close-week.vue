<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Admin / Close Week </PageSubtitle>

      <PageTitle> Close Week </PageTitle>
    </template>

    <template #content>
      <CloseWeekContent />
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
import CloseWeekContent from '~/components/CloseWeekContent.vue'
export default {
  name: 'CloseWeekPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    CloseWeekContent,
  },
  mixins: [sideBarNavTabsMixin(ADMIN_NAV_TABS)],
}
</script>

<style lang="scss" scoped></style>
