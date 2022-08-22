<template>
  <div class="content">
    <PageSubHeaderContent />

    <PageContentWrapper>
      <TabsView :tabs-headers="tabsHeaders" :tabs="tabs" />
    </PageContentWrapper>
  </div>
</template>

<script>
import TabsView from './TabsView.vue'
import PageContentWrapper from './PageContentWrapper.vue'
import PurchaseOrdersDetails from './PurchaseOrdersDetails.vue'
import PurchaseOrdersItems from './PurchaseOrdersItems.vue'
import PageSubHeaderContent from './PageSubHeaderContent.vue'
import { mutationMixin } from '~/mixins/mutationMixin'
import { meMixin } from '~/mixins/meMixin'
import { PURCHASE_ORDER } from '~/constants/purchaseOrder'
export default {
  name: 'PurchaseOrdersContent',
  components: {
    TabsView,
    PageContentWrapper,
    PageSubHeaderContent,
  },
  mixins: [mutationMixin, meMixin],
  data() {
    return {
      tabsHeaders: ['Details', 'Items'],
      tabs: [PurchaseOrdersDetails, PurchaseOrdersItems],
    }
  },
  destroyed() {
    this.$store.commit('purchaseOrders/SET_IS_EDIT', false)
    this.$store.commit('purchaseOrders/SET_PURCHASE_ORDER', PURCHASE_ORDER)
  },
}
</script>

<style lang="scss" scoped></style>
