<template>
  <PageContentWrapper>
    <div class="header">
      <InputRow>
        <InputWithTitle has-select>
          <template #title> Unit </template>

          <template #input>
            <CustomSelect
              v-if="unitsByPeriod"
              :options="unitsByPeriod"
              select-by="name"
              select-by-second="code"
              @input="selectUnit"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle v-if="unit">
          <template #title> Name </template>

          <template #input>
            <CustomInput v-model="unit.name" readonly disabled />
          </template>
        </InputWithTitle>
      </InputRow>
    </div>

    <CustomTable v-if="unit && unit.periods" :w-table="520">
      <template #header>
        <div class="table-row">
          <span>Period ID</span>

          <span>PeriodEnd</span>

          <span>Open</span>
        </div>
      </template>

      <template #content>
        <CustomTableRow
          v-for="period in unit.periods"
          :key="period.id"
          class="table-row"
        >
          <span>
            {{ period.id }}
          </span>

          <span>
            {{ formatDateFromAPI(period.periodEnd) }}
          </span>

          <CustomRadioButton
            v-if="period.pivot"
            :is-active="!period.pivot.isClosed"
            disabled
          />
        </CustomTableRow>
      </template>
    </CustomTable>
  </PageContentWrapper>
</template>

<script>
import UnitsByPeriod from '../graphql/queries/unitsByPeriod.gql'
import { formatDateFromAPI } from '~/helpers/helpers'
export default {
  name: 'HQUnitPeriodStatusContent',
  apollo: {
    unitsByPeriod: {
      query: UnitsByPeriod,
      fetchPolicy: 'no-cache',
    },
  },
  data() {
    return {
      unit: '',
    }
  },
  methods: {
    formatDateFromAPI,
    selectUnit(item) {
      this.unit = item
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  padding: 12px 0;
  @media screen and (min-width: $md) {
    grid-template-columns: 80px repeat(2, 300px) 80px;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 80px repeat(2, 120px) 80px;
  }
  column-gap: 30px;
}

.row {
  padding: 6px 10px;

  span {
    min-height: 40px;
    display: flex;
    align-items: center;
  }
}
</style>
