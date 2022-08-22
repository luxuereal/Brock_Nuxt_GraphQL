<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <InputRow class="input-row-mob">
        <InputWithTitle v-if="districts" has-select>
          <template #title>Select District</template>

          <template #input>
            <CustomSelect :options="districts" @input="selectDistrict" />
          </template>
        </InputWithTitle>

        <InputWithTitle v-if="periods" has-select>
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

      <CustomTable v-if="units" class="table-reports">
        <template #header>
          <div class="table-row">
            <CustomRadioButton
            :is-active="selectAllUnits"
            @set-is-active="setSelectAllUnits()"
          />

            <span>Unit</span>

            <span>Unit Name</span>
          </div>
        </template>

        <template #content>
          <CustomTableContent>
            <CustomTableRow
              v-for="unit in units"
              :key="unit.id"
              class="table-row"
            >
              <CustomRadioButton
                :is-active="unit.selected"
                @set-is-active="selectUnit(unit)"
              />

              <span>{{ unit.code }}</span>

              <span>{{ unit.name }}</span>
            </CustomTableRow>
          </CustomTableContent>

          <CustomTableRow class="table-row footer-row">
            <!-- <DefaultButton @event="selectAllUnits"> Select All </DefaultButton>

            <DefaultButton @event="selectNone"> Select None </DefaultButton> -->

            <DefaultButton
              :disabled="!selectedUnits.length || !periodEndDate.id"
              @event="openReport"
            >
              Open Report
            </DefaultButton>
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomRadioButton from './CustomRadioButton.vue'
import CustomTableContent from './CustomTableContent.vue'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomSelect from './CustomSelect.vue'
import Districts from '~/graphql/queries/districts.gql'
import Periods from '~/graphql/queries/periods.gql'
import Units from '~/graphql/queries/units.gql'
import MultiUnitLabor from '~/graphql/mutations/reports/multiUnitLabor.gql'
import { formatDateFromAPI } from '~/helpers/helpers'
import { mutationMixin } from '~/mixins/mutationMixin'
export default {
  name: 'HQLaborScheduleReport',
  components: {
    PageContentWrapper,
    ValidationObserver,
    CustomTable,
    CustomTableRow,
    CustomRadioButton,
    CustomTableContent,
    InputRow,
    InputWithTitle,
    CustomSelect,
  },
  mixins: [mutationMixin],
  apollo: {
    districts: {
      query: Districts,
    },
    periods: {
      query: Periods,
      variables: {
        hasUnits: true,
      },
    },
    units: {
      query: Units,
    },
  },
  data() {
    return {
      district: '',
      periodEndDate: '',
      selectAllUnits: false,
    }
  },
  computed: {
    selectedUnits() {
      return this.units.filter((unit) => unit.selected)
    },
  },
  methods: {
    formatDateFromAPI,
    selectPeriodEndDate(item) {
      this.periodEndDate = item
    },
    selectDistrict(item) {
      this.district = item
    },
    selectUnit(item) {
      this.units = this.units.map((unit) => {
        if (item.id === unit.id) {
          return {
            ...unit,
            selected: !unit.selected,
          }
        }

        return unit
      })
    },
    setSelectAllUnits(){
      this.units = this.units.map((item) => {
        return {
          ...item,
          selected: !this.selectAllUnits,
        }
      })
      this.selectAllUnits = !this.selectAllUnits
    },
    async openReport() {
      const {
        data: { multiUnitLabor },
      } = await this.mutationAction(
        MultiUnitLabor,
        {
          input: {
            period: this.periodEndDate.id,
            units: this.selectedUnits.map((unit) => unit.id),
            district: this.district.id,
          },
        },
        Units,
        'Open Report success',
        null,
        null,
        true
      )

      window.open(multiUnitLabor)
    },
  },
}
</script>

<style lang="scss" scoped>
.table-compact {
  width: fit-content;
}

.table-row {
  display: grid;
  align-items: center;
  column-gap: 20px;
  padding: 10px 0px;

  @media screen and (min-width: $sm) {
    grid-template-columns: 80px 200px auto;
  }

  @media screen and (max-width: $sm) {
    grid-template-columns: 50px 110px 110px;
  }
}

.row {
  padding: 16px 10px;
}
.footer-row {
  grid-template-columns: repeat(3, 150px);

  @media screen and (max-width: $sm) {
    grid-template-columns: repeat(2, 150px);

    button {
      margin-bottom: 20px;
    }
  }
}

.input-row-mob {
  @media screen and (max-width: $md) {
    display: block;
    > div {
      width: 100%;
      margin-bottom: 20px;
    }
  }
}

.table-reports {
  margin-top: 20px;

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
