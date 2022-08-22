<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Accounting / Terms </PageSubtitle>

      <PageTitle> Terms </PageTitle>
    </template>

    <template #content>
      <HQTermsContent />
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
import HQTermsContent from '~/components/HQTermsContent.vue'
export default {
  name: 'TermsPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQTermsContent,
  },
  mixins: [sideBarNavTabsMixin(HQ_ACCOUNTING)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
