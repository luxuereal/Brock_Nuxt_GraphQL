<template>
  <div class="content">
    <PageSubHeaderContent />

    <PageContentWrapper>
      <TabsView :tabs-headers="tabsHeaders" :tabs="tabs"></TabsView>
    </PageContentWrapper>
  </div>
</template>

<script>
/* eslint-disable vue/no-unused-components */
import PageSubheader from './PageSubheader.vue'
import TabsView from './TabsView.vue'
import CateringSalesDetails from './CateringSalesDetails.vue'
import PageContentWrapper from './PageContentWrapper.vue'
import CateringSalesItems from './CateringSalesItems.vue'
import CateringSalesShipAndBillTo from './CateringSalesShipAndBillTo.vue'
import PageSubHeaderContent from './PageSubHeaderContent.vue'
import { CATERING_ORDER } from '~/constants/cateringOrder'
export default {
  name: 'CateringSalesContent',
  components: {
    PageSubheader,
    TabsView,
    CateringSalesDetails,
    PageContentWrapper,
    CateringSalesItems,
    CateringSalesShipAndBillTo,
    PageSubHeaderContent,
  },
  data() {
    return {
      tabsHeaders: ['Details', 'Items', 'Ship To/Bill To'],
      tabs: [
        CateringSalesDetails,
        CateringSalesItems,
        CateringSalesShipAndBillTo,
      ],
    }
  },
  destroyed() {
    this.$store.commit('cateringSales/SET_IS_EDIT', false)
    this.$store.commit('cateringSales/SET_CATERING_ORDER', CATERING_ORDER)
  },
}
</script>

<style lang="scss" scoped></style>
