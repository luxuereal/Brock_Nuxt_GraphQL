<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Unit Setup / Unit-GL </PageSubtitle>

      <div class="title-area">
        <PageTitle> Unit-GL Maintenance </PageTitle>

        <DefaultButton button-color-gamma="red" @event="cloneUnit">
          Clone Unit
        </DefaultButton>
      </div>
    </template>

    <template #content>
      <HQUnitGLMaintenance />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_UNITS_TABS } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import DefaultButton from '~/components/DefaultButton.vue'
import HQUnitGLMaintenance from '~/components/HQUnitGLMaintenance.vue'
export default {
  name: 'UnitGL',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    DefaultButton,
    HQUnitGLMaintenance,
  },
  mixins: [sideBarNavTabsMixin(HQ_UNITS_TABS)],
  layout: 'hqlayout',
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
  methods: {
    cloneUnit() {},
  },
}
</script>

<style lang="scss" scoped>
.title-area {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
