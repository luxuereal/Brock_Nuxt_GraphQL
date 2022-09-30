<template>
  <PageContentWrapper>
    <div class="input">
      <InputRow class="input">
        <InputWithTitle v-if="periods" has-select>
          <template #title>Period End Date</template>

          <template #input>
            <CustomSelect
              :options="formattedPeriods"
              select-by="periodEnd"
              @input="selectPeriodEndDate"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle has-select>
          <template #title>Export type</template>

          <template #input>
            <CustomSelect :options="exportTypes" @input="selectExportType" />
          </template>
        </InputWithTitle>
      </InputRow>
    </div>

    <CustomTable v-if="units" :w-table="500">
      <template #header>
        <div class="table-row">
          <CustomRadioButton
            :is-active="selectAllUnits"
            @set-is-active="setSelectAllUnits()"
          />

          <span> Unit Number </span>

          <span> Unit </span>
        </div>
      </template>

      <template #content>
        <CustomTableRow v-for="item in units" :key="item.id" class="table-row">
          <CustomRadioButton
            :is-active="item.selected"
            @set-is-active="selectItem(item)"
          />

          <span>
            {{ item.code }}
          </span>

          <span>
            {{ item.name }}
          </span>
        </CustomTableRow>
      </template>
    </CustomTable>

    <div class="buttons-area">
      <DefaultButton
        button-color-gamma="red"
        :disabled="selectedUnits && !selectedUnits.length"
        @event="exportPurchases"
      >
        export purchases
      </DefaultButton>
    </div>

    <a id="export"></a>
  </PageContentWrapper>
</template>

<script>
import PageContentWrapper from './PageContentWrapper.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomSelect from './CustomSelect.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomRadioButton from './CustomRadioButton.vue'
import InputRow from './InputRow.vue'
import Units from '~/graphql/queries/units.gql'
import Periods from '~/graphql/queries/periods.gql'
import ExportData from '~/graphql/mutations/reports/exportData.gql'
import { formatDateFromAPI } from '~/helpers/helpers'
import { mutationMixin } from '~/mixins/mutationMixin'
import { EXPORT_TYPES } from '~/constants/exportTypes'
export default {
  name: 'HQExportPurchases',
  components: {
    InputWithTitle,
    CustomSelect,
    PageContentWrapper,
    CustomTable,
    CustomTableRow,
    CustomRadioButton,
    InputRow,
  },
  apollo: {
    units: {
      query: Units,
    },
    periods: {
      query: Periods,
      variables: {
        hasUnits: true,
      },
    },
  },
  mixins: [mutationMixin],
  data() {
    return {
      periodEndDate: '',
      selectAllUnits: false,
      exportType: '',
      exportTypes: EXPORT_TYPES,
    }
  },
  computed: {
    selectedUnits() {
      return this.units && this.units.filter((unit) => unit.selected)
    },
    formattedPeriods() {
      return this.periods.map((period) => {
        return {
          ...period,
          periodEnd: this.formatDateFromAPI(period.periodEnd),
        }
      })
    },
  },
  watch: {
    units() {
      if (this.units.every((item) => item.selected)) {
        this.selectAllUnits = true
      }
    },
  },
  methods: {
    formatDateFromAPI,
    selectPeriodEndDate(item) {
      this.periodEndDate = item
    },
    selectExportType(exportType) {
      this.exportType = exportType
    },
    setSelectAllUnits() {
      this.units = this.units.map((item) => {
        return {
          ...item,
          selected: !this.selectAllUnits,
        }
      })
      this.selectAllUnits = !this.selectAllUnits
    },
    selectItem(unit) {
      this.selectAllUnits = false
      this.units = this.units.map((item) => {
        if (unit.id === item.id) {
          return {
            ...item,
            selected: !item.selected,
          }
        }

        return item
      })
    },
    async exportPurchases() {
      const {
        data: { exportData },
      } = await this.mutationAction(
        ExportData,
        {
          input: {
            period: this.periodEndDate.id,
            units: this.selectedUnits.map((unit) => unit.id),
            type: this.exportType.value,
          },
        },
        Units,
        'Export data success',
        null,
        null,
        true
      )

      
      if (exportData) {
        const download = document.getElementById('export')
        download.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(exportData))
        download.setAttribute('download', 'purchase.txt')
        download.click()
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  column-gap: 20px;
  padding: 12px 0;

  @media screen and (min-width: $md) {
    grid-template-columns: 40px 150px 320px;
  }

  @media screen and (max-width: $md) {
    grid-template-columns: 40px 120px 120px;
  }
}

.row {
  padding: 16.5px 10px;
}

.input {
  margin-bottom: 20px;

  @media screen and (max-width: $sm) {
    display: flex;
    flex-direction: column;
  }
}

.buttons-area {
  margin-top: 20px;
}
</style>
