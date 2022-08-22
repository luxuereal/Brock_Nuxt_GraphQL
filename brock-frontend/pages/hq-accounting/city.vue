<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Accounting / City </PageSubtitle>

      <PageTitle> City </PageTitle>
    </template>

    <template #content>
      <HQCityContent />
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
import HQCityContent from '~/components/HQCityContent.vue'
export default {
  name: 'CityPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQCityContent,
  },
  mixins: [sideBarNavTabsMixin(HQ_ACCOUNTING)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped></style>
