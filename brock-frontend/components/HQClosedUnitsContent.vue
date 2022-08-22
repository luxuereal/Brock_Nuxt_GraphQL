<template>
  <PageContentWrapper>
    <InputRow>
      <InputWithTitle has-select>
        <template #title> District </template>

        <template #input>
          <CustomSelect
            v-if="districts"
            :options="districts"
            select-by="name"
            select-by-second="code"
            @input="selectDistrict"
          />
        </template>
      </InputWithTitle>
    </InputRow>

    <CustomTable v-if="unitsFromDistrict" class="table" :w-table="470">
      <template #header>
        <div class="table-row">
          <span>Unit Number</span>

          <span>Unit Name</span>

          <span>Last closed period end date</span>
        </div>
      </template>

      <template #content>
        <CustomTableRow
          v-for="unit in unitsFromDistrict"
          :key="unit.id"
          class="table-row"
        >
          <span>{{ unit.code }}</span>

          <span>{{ unit.name }}</span>

          <span v-if="unit.periods">{{
            unit.periods.find(
              (period) => period.pivot && period.pivot.isClosed
            ) &&
            formatDateFromAPI(
              unit.periods.find(
                (period) => period.pivot && period.pivot.isClosed
              ).periodEnd
            )
          }}</span>
        </CustomTableRow>
      </template>
    </CustomTable>
  </PageContentWrapper>
</template>

<script>
import Districts from '~/graphql/queries/districts.gql'
import Units from '~/graphql/queries/units.gql'
import { formatDateFromAPI } from '~/helpers/helpers'
export default {
  name: 'HQClosedUnitsContent',
  apollo: {
    districts: {
      query: Districts,
    },
    units: {
      query: Units,
    },
  },
  data() {
    return {
      district: '',
    }
  },
  computed: {
    unitsFromDistrict() {
      return this.units.filter((unit) => unit.district.id === this.district.id)
    },
  },
  methods: {
    formatDateFromAPI,
    selectDistrict(item) {
      this.district = item
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  column-gap: 30px;
  padding: 12px 0;
  @media screen and (min-width: $md) {
    grid-template-columns: 80px 300px 250px;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 60px 250px 200px;
  }
}
.row {
  padding: 12px 10px;

  span {
    min-height: 28px;
    display: flex;
    align-items: center;
  }
}
</style>
