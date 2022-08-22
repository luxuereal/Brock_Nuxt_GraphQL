<template>
  <PageContentWrapper>
    <TabsView :tabs-headers="tabsHeaders" :tabs="tabs" />
  </PageContentWrapper>
</template>

<script>
import { unitMaintenanceMixin } from '../mixins/unitMaintenanceMixin'
import { submitMessagesMixin } from '../mixins/submitMessagesMixin'
import PageContentWrapper from './PageContentWrapper.vue'
import TabsView from './TabsView.vue'
import HQUnitMaintenanceDetails from './HQUnitMaintenanceDetails.vue'
import HQUnitMaintenanceFinancials from './HQUnitMaintenanceFinancials.vue'
import HQUnitMaintenanceFees from './HQUnitMaintenanceFees.vue'
export default {
  name: 'HQUnitMaintenance',
  components: {
    PageContentWrapper,
    TabsView,
  },
  mixins: [unitMaintenanceMixin, submitMessagesMixin],
  data() {
    return {
      tabsHeaders: ['Details', 'Financials', 'Fees'],
      tabs: [
        HQUnitMaintenanceDetails,
        HQUnitMaintenanceFinancials,
        HQUnitMaintenanceFees,
      ],
    }
  },
  destroyed() {
    this.hideAddUnit()
    this.setUnitID(null)
  },
}
</script>

<style lang="scss" scoped></style>
