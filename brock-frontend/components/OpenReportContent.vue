<template>
  <PageContentWrapper>
    <InputRow>
      <InputWithTitle has-select>
        <template #title> Report Type </template>

        <template #input>
          <CustomSelect :options="reportTypes" @input="selectReportType" />
        </template>
      </InputWithTitle>

      <InputWithTitle has-select>
        <template #title> Period End Date </template>

        <template v-if="formattedPeriods" #input>
          <CustomSelect
            :options="formattedPeriods"
            select-by="periodEnd"
            @input="selectPeriodEndDate"
          />
        </template>
      </InputWithTitle>
    </InputRow>

    <DefaultButton @event="openReport"> Open Report </DefaultButton>
  </PageContentWrapper>
</template>

<script>
import { locationReportTypes } from '../constants/reportTypes'
import PageContentWrapper from './PageContentWrapper'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomSelect from './CustomSelect.vue'
import DefaultButton from './DefaultButton.vue'
import { meMixin } from '~/mixins/meMixin'
import { formatDateFromAPI } from '~/helpers/helpers'
import { mutationMixin } from '~/mixins/mutationMixin'
import Me from '~/graphql/queries/me.query.gql'
import OperatingReport from '~/graphql/mutations/reports/operatingReport.gql'
export default {
  name: 'OpenReportContent',
  components: {
    PageContentWrapper,
    InputRow,
    InputWithTitle,
    CustomSelect,
    DefaultButton,
  },
  mixins: [meMixin, mutationMixin],
  data() {
    return {
      reportType: '',
      reportTypes: locationReportTypes,
      periodEnd: '',
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
    selectPeriodEndDate(item) {
      this.periodEnd = item
    },
    async openReport() {
      const {
        data: { operatingReport },
      } = await this.mutationAction(
        OperatingReport,
        {
          input: {
            period: this.periodEnd.id,
            unit: this.selectedUnit.id,
            type: this.reportType.type,
            typePeriod: this.reportType.typePeriod,
          },
        },
        Me,
        'Open Report Success',
        null,
        null,
        true
      )

      window.open(operatingReport)
    },
  },
}
</script>

<style lang="scss" scoped></style>
