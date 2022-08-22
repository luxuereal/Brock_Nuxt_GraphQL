<template>
  <PageSubheader>
    <PageSubheaderItem>
      <template #title>{{ selectedUnit && selectedUnit.id }}</template>

      <template #subtitle>Unit Number</template>
    </PageSubheaderItem>

    <PageSubheaderItem>
      <template #title>{{
        selectedUnit.activePeriod &&
        formatDateFromAPI(selectedUnit.activePeriod.periodEnd)
      }}</template>

      <template #subtitle>Period End</template>
    </PageSubheaderItem>
  </PageSubheader>
</template>

<script>
import PageSubheader from './PageSubheader.vue'
import PageSubheaderItem from './PageSubheaderItem.vue'
import { meMixin } from '~/mixins/meMixin'
import { formatDateFromAPI } from '~/helpers/helpers'
export default {
  name: 'PageSubHeaderContent',
  components: { PageSubheader, PageSubheaderItem },
  mixins: [meMixin],
  methods: {
    formatDateFromAPI,
  },
}
</script>

<style lang="scss" scoped>
div.subheader {
  justify-content: flex-start;
  overflow: auto;
  div {
    @media screen and (min-width: $lg) {
      margin-right: 120px;
    }
    @media screen and (max-width: $lg) {
      margin-right: 30px;
    }
  }
}
</style>
