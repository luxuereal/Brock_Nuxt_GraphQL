<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid }">
      <InputRow>
        <InputWithTitle>
          <template #title> Payroll Tax </template>

          <template #input>
            <CustomInput
              v-model="payrollTaxPercent"
              type="number"
              rules="double|between:0,100"
              placeholder="0.00"
              symbol="%"
              name="unit-payrollTaxPercent"
              @change="onChangeFloatValue('payrollTaxPercent')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Benefit Dollars </template>

          <template #input>
            <CustomInput
              v-model="benefitsAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-benefitsAmount"
              @change="onChangeFloatValue('benefitsAmount')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Vending Income </template>

          <template #input>
            <CustomInput
              v-model="vendingIncome"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-vendingIncome"
              @change="onChangeFloatValue('vendingIncome')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Commission Dollars </template>

          <template #input>
            <CustomInput
              v-model="commissionAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-commissionAmount"
              @change="onChangeFloatValue('commissionAmount')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Vacation Dollars </template>

          <template #input>
            <CustomInput
              v-model="vacationAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-vacationAmount"
              @change="onChangeFloatValue('vacationAmount')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Vending </template>

          <template #input>
            <CustomRadioButton
              class="radio-button"
              :is-active="isVending"
              @set-is-active="setIsVending"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Business Insurance </template>

          <template #input>
            <CustomInput
              v-model="businessInsuranceAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-businessInsuranceAmount"
              @change="onChangeFloatValue('businessInsuranceAmount')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Active </template>

          <template #input>
            <CustomRadioButton
              class="radio-button"
              :is-active="isActive"
              @set-is-active="setIsActive"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <div class="buttons-area">
        <DefaultButton
          button-color-gamma="red"
          :disabled="invalid"
          @event="nextTab"
        >
          Continue
        </DefaultButton>

        <DefaultButton button-color-gamma="white" @event="cancel">
          Cancel
        </DefaultButton>
      </div>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { formMixin } from '../mixins/formMixin'
import { unitMaintenanceMixin } from '../mixins/unitMaintenanceMixin'
import InputRow from './InputRow.vue'
import CustomInput from './CustomInput.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomRadioButton from './CustomRadioButton.vue'
import { tabsViewMixin } from '~/mixins/tabsViewMixin'
export default {
  name: 'HQUnitMaintenanceFinancials',
  components: {
    ValidationObserver,
    InputRow,
    InputWithTitle,
    CustomInput,
    CustomRadioButton,
  },
  mixins: [formMixin, unitMaintenanceMixin, tabsViewMixin],
  data () {
    return {
      /* payrollTaxPercent: '',
      benefitsAmount: '',
      vendingIncome: '',
      commissionAmount: '',
      vacationAmount: '',
      businessInsuranceAmount: '', */
    }
  },
  computed: {
    payrollTaxPercent: {
      get() {
        return this.unit.payrollTaxPercent
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_PAYROLL_TAX', value)
      },
    },
    benefitsAmount: {
      get() {
        return this.unit.benefitsAmount
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_BENEFIT_DOLLARS', value)
      },
    },
    vendingIncome: {
      get() {
        return this.unit.vendingIncome
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_VENDING_INCOME', value)
      },
    },
    commissionAmount: {
      get() {
        return this.unit.commissionAmount
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_COMMISSION_DOLLARS', value)
      },
    },
    vacationAmount: {
      get() {
        return this.unit.vacationAmount
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_VACATION_DOLLARS', value)
      },
    },
    isVending() {
      return this.unit.isVending
    },
    isActive() {
      return this.unit.isActive
    },
    businessInsuranceAmount: {
      get() {
        return this.unit.businessInsuranceAmount
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_BUSINESS_INSURANCE', value)
      },
    },
  },
  watch: {
    activeValidate() {
      if(this.activeValidate === 'Financials') this.$refs.form.validate()
    }
  },
  methods: {
    onChangeFloatValue(stateProp) {
      const value = parseFloat(this.unit[stateProp] !== '' ? this.unit[stateProp] : 0).toFixed(2);
      if ( stateProp === 'payrollTaxPercent' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_PAYROLL_TAX', value)
      } else if ( stateProp === 'benefitsAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_BENEFIT_DOLLARS', value)
      } else if ( stateProp === 'vendingIncome' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_VENDING_INCOME', value)
      } else if ( stateProp === 'commissionAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_COMMISSION_DOLLARS', value)
      } else if ( stateProp === 'vacationAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_VACATION_DOLLARS', value)
      } else if ( stateProp === 'businessInsuranceAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_BUSINESS_INSURANCE', value)
      }
    },
    setIsVending() {
      this.$store.commit(
        'unitMaintenance/SET_UNIT_IS_VENDING',
        !this.unit.isVending
      )
    },
    setIsActive() {
      this.$store.commit(
        'unitMaintenance/SET_UNIT_IS_ACTIVE',
        !this.unit.isActive
      )
    },
  },
}
</script>

<style lang="scss" scoped>
.radio-button {
  display: flex;
  align-items: center;
  height: 42px;
}

.buttons-area {
  display: flex;
  margin-top: 50px;

  button:first-child {
    margin-right: 11px;
  }
}
</style>
