<template>
  <PageContentWrapper>
    <LoadingBar v-if="$apollo.loading" />
    <CustomTable v-else :w-table="620">
      <template #header>
        <div class="table-row">
          <span>Unit Number</span>

          <span>Name</span>

          <span>City</span>

          <span>State</span>
        </div>
      </template>

      <template v-if="queryData.data" #content>
        <CustomTableRow v-for="unit in queryData.data" :key="unit.id" class="table-row">
          <span>
            {{ unit.code }}
          </span>

          <span>
            {{ unit.name }}
          </span>

          <span v-if="unit.city">
            {{ unit.city.name }}
          </span>
          <span v-else>-</span>

          <span v-if="unit.city">
            {{ unit.city.state.code }}
          </span>
          <span v-else>-</span>

          <CustomTableIconsColumn
            :is-delete-active="isDelete === unit.id"
            @edit="editUnit(unit)"
            @delete="deleteItem(unit.id)"
            @cancel-delete="cancelDelete"
            @confirm-delete="confirmDelete(unit.id)"
          />
        </CustomTableRow>

        <!-- pagination -->
          <PaginationRow v-if="queryData.data.length">
            <div :class="(!isHide || isAdd ? 'show' : 'hide') + ' button-bar'">
              <PaginationButton
                :disabled="currentPage == 1"
                :loading="fetchingData"
                @event="firstPage"
              > << </PaginationButton>
              <PaginationButton
                :disabled="currentPage == 1"
                :loading="fetchingData"
                @event="prevPage"
              > < </PaginationButton>
              <PaginationInput
                v-model="page"
                :disabled="fetchingData"
                @change="goToPage"
                @event="goToPage"
                >
              </PaginationInput>
              <PaginationButton
                :disabled="currentPage >= queryData.paginatorInfo.lastPage"
                :loading="fetchingData"
                @event="nextPage"
              > > </PaginationButton>
              <PaginationButton
                :disabled="currentPage >= queryData.paginatorInfo.lastPage"
                :loading="fetchingData"
                @event="lastPage"
              > >> </PaginationButton>
            </div>
            <div class='description-bar'>
              Showing {{queryData.paginatorInfo.firstItem}}-{{queryData.paginatorInfo.lastItem}} of {{queryData.paginatorInfo.total}}
            </div>
          </PaginationRow>
          <!-- pagination -->
      </template>
    </CustomTable>
  </PageContentWrapper>
</template>

<script>
import UnitList from '../graphql/queries/unitList.gql'
import Unit from '../graphql/queries/unit.gql'
import DeleteUnit from '../graphql/mutations/unit/deleteUnit.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow'
import CustomTableIconsColumn from './CustomTableIconsColumn'
import PaginationRow from './PaginationRow.vue'
import PaginationButton from './PaginationButton.vue'
import PaginationInput from './PaginationInput.vue'
import { unitMaintenanceMixin } from '~/mixins/unitMaintenanceMixin'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import { paginatorMixin } from '~/mixins/paginatorMixin'

export default {
  name: 'HQUnitsTableContent',
  components: {
    PageContentWrapper,
    CustomTable,
    CustomTableRow,
    CustomTableIconsColumn,
    PaginationRow,
    PaginationButton,
    PaginationInput,
  },
  mixins: [unitMaintenanceMixin, tableActionsMixin, mutationMixin, paginatorMixin],
  props: {
    search: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      query: UnitList,
      queryName: 'unitList',
      currentPage: 1,
      queryData: {},
      hasQueryVariable: true,
      queryVariable: {
        search: '%',
      },

      timeout: null
    }
  },
  watch: {
    search() {
      clearTimeout(this.timeout)
      this.timeout = setTimeout(() => this.showFilterUnits(), 500)
    }
  },
  beforeMount() {
    this.fetchData()
  },
  methods: {
    showFilterUnits() {
      this.queryVariable.search = '%' + this.search + '%'
      this.goToPage(1)
    },
    async editUnit(unit) {
      const res = await this.$apollo.query({
          query: Unit,
          fetchPolicy: 'network-only',
          variables: { id: unit.id },
      });

      const unitById = res.data.unit
      
      const propertyList = ['administrativeAmount', 'administrativePercent', 'benefitsAmount', 'benefitsPercent', 'businessInsuranceAmount', 'commissionAmount', 'commissionPercent', 'managementAmount', 'managementPercent', 'payrollTaxPercent', 'supportAmount', 'supportPercent', 'vacationAmount', 'vendingIncome'];
      for ( const property of propertyList ) {
        unitById[property] = Number(unitById[property]).toFixed(2);
      }

      this.setUnit(unitById)
      this.setUnitID(unitById.id)
      this.showAddUnit()
    },
    async confirmDelete(id) {
      const res = await this.mutationAction(
        DeleteUnit,
        { id },
        null,
        'Delete unit success',
        'Delete unit error'
      )
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
    },
  },
}
</script>

<style lang="scss" scoped>

.table-content {
  .header {
    padding: 6px 10px;

    .table-row {
      padding: 0;
    }
  }
}

.table-row {
  display: grid;
  align-items: center;
  padding: 6px 10px;
  //grid-template-columns: 160px 340px 200px 160px auto;
  column-gap: 30px;
  @media screen and (min-width: $md) {
    grid-template-columns: 17% 30% 16% 15% auto;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 100px 120px 120px 70px auto;
  }

  span {
    height: 40px;
    display: flex;
    align-items: center;
  }
}
</style>



