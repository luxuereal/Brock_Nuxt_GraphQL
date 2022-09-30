<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid }">
      <InputRow>
        <InputWithTitle has-select>
          <template #title> Management Fee - Type </template>

          <template #input>
            <CustomSelect
              v-if="calculationCodes"
              :options="calculationCodes"
              select-by="description"
              :selected-item="calculationCodes.find((calculationCode) =>
                  calculationCode.code === unit.managementFeeType
                )"
              @input="selectManagementFeeType"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Management Fee - Dollar </template>

          <template #input>
            <CustomInput
              v-model="managementAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-managementAmount"
              @change="onChangeFloatValue('managementAmount')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Management Fee - Percent </template>

          <template #input>
            <CustomInput
              v-model="managementPercent"
              type="number"
              rules="double|between:0,100"
              placeholder="0.00"
              symbol="%"
              name="unit-managementPercent"
              @change="onChangeFloatValue('managementPercent')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle has-select>
          <template #title> Administrative Fee - Type </template>

          <template #input>
            <CustomSelect
              v-if="calculationCodes"
              :options="calculationCodes"
              select-by="description"
              :selected-item="calculationCodes.find((calculationCode) =>
                  calculationCode.code === unit.administrativeFeeType
                )"
              @input="selectAdministrativeFeeType"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Administrative Fee - Dollar </template>

          <template #input>
            <CustomInput
              v-model="administrativeAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-administrativeAmount"
              @change="onChangeFloatValue('administrativeAmount')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Administrative Fee - Percent </template>

          <template #input>
            <CustomInput
              v-model="administrativePercent"
              type="number"
              rules="double|between:0,100"
              placeholder="0.00"
              symbol="%"
              name="unit-administrativePercent"
              @change="onChangeFloatValue('administrativePercent')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle has-select>
          <template #title> Support Fee - Type </template>

          <template #input>
            <CustomSelect
              v-if="calculationCodes"
              :options="calculationCodes"
              select-by="description"
              :selected-item="calculationCodes.find((calculationCode) =>
                  calculationCode.code === unit.supportFeeType
                )"
              @input="selectSupportFeeType"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Support Fee - Dollar </template>

          <template #input>
            <CustomInput
              v-model="supportAmount"
              type="number"
              rules="currency"
              placeholder="0.00"
              symbol="$"
              name="unit-supportAmount"
              @change="onChangeFloatValue('supportAmount')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Support Fee - Percent </template>

          <template #input>
            <CustomInput
              v-model="supportPercent"
              type="number"
              rules="double|between:0,100"
              placeholder="0.00"
              symbol="%"
              name="unit-supportPercent"
              @change="onChangeFloatValue('supportPercent')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Benefits Percent </template>

          <template #input>
            <CustomInput
              v-model="benefitsPercent"
              type="number"
              rules="double|between:0,100"
              placeholder="0.00"
              symbol="%"
              name="unit-benefitsPercent"
              @change="onChangeFloatValue('benefitsPercent')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Commission Percent </template>

          <template #input>
            <CustomInput
              v-model="commissionPercent"
              type="number"
              rules="double|between:0,100"
              placeholder="0.00"
              symbol="%"
              name="unit-commissionPercent" 
              @change="onChangeFloatValue('commissionPercent')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Kronos </template>

          <template #input>
            <CustomRadioButton
              class="radio-button"
              :is-active="isKronos"
              @set-is-active="setIsKronos"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle has-select>
          <template #title> Reg Tax </template>

          <template #input>
            <CustomSelect
              v-if="glAccounts"
              :options="glAccounts"
              :selected-item="unitID && unit.regTax"
              select-by="name"
              select-by-second="itemId"
              select-by-gl-account="glAccount"
              input-select
              @input="selectRegTax"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <div class="buttons-area">
        <DefaultButton
          button-color-gamma="red"
          :disabled="invalid"
          @event="unitID ? updateUnit() : addUnit()"
        >
          {{ unitID ? 'Edit' : 'Save' }}
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
import { unitMaintenanceMixin } from '../mixins/unitMaintenanceMixin'
import CreateUnit from '../graphql/mutations/unit/createUnit.gql'
import UpdateUnit from '../graphql/mutations/unit/updateUnit.gql'
import Units from '../graphql/queries/units.gql'
import GlAccounts from '../graphql/queries/glAccounts.gql'
import CalculationCodes from '../graphql/queries/calculationCodes.gql'
import InputRow from './InputRow.vue'
import CustomInput from './CustomInput.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomSelect from './CustomSelect.vue'
import CustomRadioButton from './CustomRadioButton.vue'
import { mutationMixin } from '~/mixins/mutationMixin'
import { UNIT } from '~/constants/unit'
export default {
  name: 'HQUnitMaintenanceFees',
  components: {
    ValidationObserver,
    InputRow,
    InputWithTitle,
    CustomInput,
    CustomSelect,
    CustomRadioButton,
  },
  mixins: [unitMaintenanceMixin, mutationMixin],
  apollo: {
    calculationCodes: {
      query: CalculationCodes,
    },
    glAccounts: {
      query: GlAccounts,
    },
  },
  data () {
    return {
      /* managementAmount: '',
      managementPercent: '',

      administrativeAmount: '',
      administrativePercent: '',

      supportAmount: '',
      supportPercent: '',

      benefitsPercent: '',
      commissionPercent: '', */
    }
  },
  computed: {
    managementFeeType() {
      return this.unit.managementFeeType
    },
    managementAmount: {
      get() {
        return this.unit.managementAmount
      },
      set(value) {
        this.$store.commit(
          'unitMaintenance/SET_UNIT_MANAGEMENT_FEE_DOLLAR',
          value
        )
      },
    },
    managementPercent: {
      get() {
        return this.unit.managementPercent
      },
      set(value) {
        this.$store.commit(
          'unitMaintenance/SET_UNIT_MANAGEMENT_FEE_PERCENT',
          value
        )
      },
    },
    administrativeFeeType() {
      return this.unit.administrativeFeeType
    },
    administrativeAmount: {
      get() {
        return this.unit.administrativeAmount
      },
      set(value) {
        this.$store.commit(
          'unitMaintenance/SET_UNIT_ADMINISTRATIVE_FEE_DOLLAR',
          value
        )
      },
    },
    administrativePercent: {
      get() {
        return this.unit.administrativePercent
      },
      set(value) {
        this.$store.commit(
          'unitMaintenance/SET_UNIT_ADMINISTRATIVE_FEE_PERCENT',
          value
        )
      },
    },
    supportAmount: {
      get() {
        return this.unit.supportAmount
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_SUPPORT_FEE_DOLLAR', value)
      },
    },
    supportFeeType() {
      return this.unit.supportFeeType
    },
    supportPercent: {
      get() {
        return this.unit.supportPercent
      },
      set(value) {
        this.$store.commit(
          'unitMaintenance/SET_UNIT_SUPPORT_FEE_PERCENT',
          value
        )
      },
    },
    benefitsPercent: {
      get() {
        return this.unit.benefitsPercent
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_BENEFITS_PERCENT', value)
      },
    },
    regTax: {
      get() {
        return this.unit.regTax
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_REG_TAX', value)
      },
    },
    commissionPercent: {
      get() {
        return this.unit.commissionPercent
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_COMMISSION_PERCENT', value)
      },
    },
    isKronos() {
      return this.unit.isKronos
    },
  },
  watch: {
    activeValidate() {
      if(this.activeValidate === 'Fees') this.$refs.form.validate()
    }
  },
  methods: {
    onChangeFloatValue(stateProp) {
      const value = parseFloat(this.unit[stateProp] !== '' ? this.unit[stateProp] : 0).toFixed(2);
      if ( stateProp === 'managementAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_MANAGEMENT_FEE_DOLLAR', value)
      } else if ( stateProp === 'managementPercent' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_MANAGEMENT_FEE_PERCENT', value)
      } else if ( stateProp === 'administrativeAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_ADMINISTRATIVE_FEE_DOLLAR', value)
      } else if ( stateProp === 'administrativePercent' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_ADMINISTRATIVE_FEE_PERCENT', value)
      } else if ( stateProp === 'supportAmount' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_SUPPORT_FEE_DOLLAR', value)
      } else if ( stateProp === 'supportPercent' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_SUPPORT_FEE_PERCENT', value)
      } else if ( stateProp === 'benefitsPercent' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_BENEFITS_PERCENT', value)
      } else if ( stateProp === 'commissionPercent' ) {
        this.$store.commit('unitMaintenance/SET_UNIT_COMMISSION_PERCENT', value)
      }
    },
    selectManagementFeeType(managementFeeType) {
      this.$store.commit(
        'unitMaintenance/SET_UNIT_MANAGEMENT_FEE_TYPE',
        managementFeeType.code
      )
    },
    selectAdministrativeFeeType(administrativeFeeType) {
      this.$store.commit(
        'unitMaintenance/SET_UNIT_ADMINISTRATIVE_FEE_TYPE',
        administrativeFeeType.code
      )
    },
    selectSupportFeeType(supportFeeType) {
      this.$store.commit(
        'unitMaintenance/SET_UNIT_SUPPORT_FEE_TYPE',
        supportFeeType.code
      )
    },
    selectRegTax(regTax) {
      this.regTax = regTax
    },
    setIsKronos() {
      this.$store.commit('unitMaintenance/SET_UNIT_KRONOS', !this.unit.isKronos)
    },
    async addUnit() {
      // eslint-disable-next-line no-unused-vars
      const { state, users, ...unitInput } = this.unit
      const res = await this.mutationAction(
        CreateUnit,
        {
          unitInput: {
            ...unitInput,
            payrollTaxPercent: +this.unit.payrollTaxPercent,
            benefitsAmount: +this.unit.benefitsAmount,
            vendingIncome: +this.unit.vendingIncome,
            commissionAmount: +this.unit.commissionAmount,
            vacationAmount: +this.unit.vacationAmount,
            businessInsuranceAmount: +this.unit.businessInsuranceAmount,
            managementAmount: +this.unit.managementAmount,
            managementPercent: +this.unit.managementPercent,
            administrativeAmount: +this.unit.administrativeAmount,
            administrativePercent: +this.unit.administrativePercent,
            supportAmount: +this.unit.supportAmount,
            supportPercent: +this.unit.supportPercent,
            benefitsPercent: +this.unit.benefitsPercent,
            commissionPercent: +this.unit.commissionPercent,
            district: {
              connect: Number(this.unit.district.id),
            },
            county: {
              connect: Number(this.unit.county.id),
            },
            city: {
              connect: Number(this.unit.city.id),
            },
            startPeriod: {
              connect: Number(this.unit.startPeriod.id)
            },
            regTax: {
              connect: Number(this.unit.regTax.id),
            },
            users: {
              sync: users.map((user) => Number(user.id)),
            },
          },
        },
        Units,
        'Add unit success',
        'Add unit error'
      )
      if (res) {
        this.hideAddUnit()
        this.setUnitID(null)
        this.$store.dispatch('unitMaintenance/setUnit', { ...UNIT })
      }
    },
    async updateUnit() {
      if (this.unitID) {
        const {
          state,
          users,
          __typename,
          unitType,
          glAccounts,
          vendors,
          activePeriod,
          periods,
          ...unitInput
        } = this.unit
        const updateUnitInput = {
              ...unitInput,
              payrollTaxPercent: +this.unit.payrollTaxPercent,
              benefitsAmount: +this.unit.benefitsAmount,
              vendingIncome: +this.unit.vendingIncome,
              commissionAmount: +this.unit.commissionAmount,
              vacationAmount: +this.unit.vacationAmount,
              businessInsuranceAmount: +this.unit.businessInsuranceAmount,
              managementAmount: +this.unit.managementAmount,
              managementPercent: +this.unit.managementPercent,
              administrativeAmount: +this.unit.administrativeAmount,
              administrativePercent: +this.unit.administrativePercent,
              supportAmount: +this.unit.supportAmount,
              supportPercent: +this.unit.supportPercent,
              benefitsPercent: +this.unit.benefitsPercent,
              commissionPercent: +this.unit.commissionPercent,
              district: {
                connect: Number(this.unit.district.id),
              },
              county: {
                connect: Number(this.unit.county.id),
              },
              city: {
                connect: Number(this.unit.city.id),
              },
              regTax: {
                connect: Number(this.unit.regTax.id),
              },
              users: {
                sync: users.map((user) => user.id),
              },
            }
        delete updateUnitInput.startPeriod
        const res = await this.mutationAction(
          UpdateUnit,
          {
            unitInput: updateUnitInput,
          },
          Units,
          'Edit unit success',
          'Edit unit error'
        )
        if (res) {
          this.hideAddUnit()
          this.setUnitID(null)
          this.$store.dispatch('unitMaintenance/setUnit', UNIT)
        }
      }
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
