<template>
  <PageContentWrapper>
    <ValidationObserver>
      <InputRow>
        <InputWithTitle has-select>
          <template #title> Report Type </template>

          <template #input>
            <CustomSelect :options="reportTypes" @input="selectReportType" />
          </template>
        </InputWithTitle>

        <InputWithTitle has-select>
          <template #title> Period </template>

          <template #input>
            <CustomSelect
              :options="periods"
              select-by="periodEnd"
              @input="selectPeriodEndDate"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle v-if="selectedUnit">
          <template #title> Name </template>

          <template #input>
            <CustomInput v-model="selectedUnit.name" readonly disabled />
          </template>
        </InputWithTitle>

        <InputWithTitle has-select>
          <template #title> Unit </template>

          <template #input>
            <CustomSelect
              v-if="units"
              :options="units"
              select-by="name"
              select-by-second="code"
              @input="selectUnit"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <DefaultButton
        :disabled="!reportType || !selectedUnit || !periodEndDate"
        @event="openReport"
      >
        Open Report
      </DefaultButton>
    </ValidationObserver>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { WeeklyReportsTypes } from '../constants/reportTypes'
import PageContentWrapper from './PageContentWrapper.vue'
import InputRow from './InputRow.vue'
import DefaultButton from './DefaultButton.vue'
import Units from '~/graphql/queries/units.gql'
import Periods from '~/graphql/queries/periods.gql'
import { mutationMixin } from '~/mixins/mutationMixin'
import OperatingReport from '~/graphql/mutations/reports/operatingReport.gql'
import { formatDateFromAPI } from '~/helpers/helpers'
export default {
  name: 'HQWeeklyOperatingReports',
  components: {
    PageContentWrapper,
    ValidationObserver,
    InputRow,
    DefaultButton,
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
      reportType: '',
      reportTypes: WeeklyReportsTypes,
      selectedUnit: '',
      periodEndDate: '',
    }
  },
  computed: {
    formattedPeriods() {
      return this.periods.map((period) => {
        return {
          ...period,
          periodEnd: this.formatDateFromAPI(period.periodEnd),
        }
      })
    },
  },
  methods: {
    formatDateFromAPI,
    selectReportType(item) {
      this.reportType = item
    },
    selectUnit(item) {
      this.selectedUnit = item
    },
    selectPeriodEndDate(item) {
      this.periodEndDate = item
    },
    async openReport() {
      const {
        data: { operatingReport },
      } = await this.mutationAction(
        OperatingReport,
        {
          input: {
            period: this.periodEndDate.id,
            unit: this.selectedUnit.id,
            type: this.reportType.type,
            typePeriod: this.reportType.typePeriod,
          },
        },
        Units,
        'Open Report Success',
        null,
        null,
        true
      )

      console.log(operatingReport)

      // window.open(operatingReport)
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  column-gap: 20px;

  @media screen and (min-width: $xs) {
    grid-template-columns: 100px 300px;
  }

  @media screen and (max-width: $md) {
    grid-template-columns: 60px 120px;
  }
}
.table-operating {
  margin-top: 25px;

  @media screen and (max-width: $xl) {
    width: 100% !important;

    &:last-child {
      margin-bottom: 20px;
    }

    &:first-child {
      margin-right: 0 !important;
    }
  }
}
</style>
