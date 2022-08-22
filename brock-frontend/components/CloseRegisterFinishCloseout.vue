<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid, pristine }">
      <InputRow>
        <InputWithTitle>
          <template #title>Actual Cash Deposit</template>

          <template #input>
            <CustomInput
              v-model="actualCashDeposit"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Actual Cash Deposit"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('actualCashDeposit')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Calculated Cash Deposit</template>

          <template #input>
            <CustomInput
              v-model="calculatedCashDeposit"
              placeholder="0.00"
              symbol="$"
              disabled
              is-float="true"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Over/Short</template>

          <template #input>
            <CustomInput v-model="overShort" placeholder="0.00" symbol="$" disabled is-float="true" />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Customer Count - Breakfast</template>

          <template #input>
            <CustomInput
              v-model="customerCountBreakfast"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Customer Count-Breakfast"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('customerCountBreakfast')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Net Sales - Breakfast</template>

          <template #input>
            <CustomInput
              v-model="netSalesBreakfast"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Net Sales-Breakfast"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('netSalesBreakfast')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Customer Count - Lunch</template>

          <template #input>
            <CustomInput
              v-model="customerCountLunch"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Customer Count-Lunch"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('customerCountLunch')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Net Sales - Lunch</template>

          <template #input>
            <CustomInput
              v-model="netSalesLunch"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Net Sales-Lunch"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('netSalesLunch')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Customer Count - Dinner</template>

          <template #input>
            <CustomInput
              v-model="customerCountDinner"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Customer Count-Dinner"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('customerCountDinner')"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Net Sales - Dinner</template>

          <template #input>
            <CustomInput
              v-model="netSalesDinner"
              placeholder="0.00"
              rules="required|currency|max:255"
              name="Net Sales-Dinner"
              type="number"
              symbol="$"
              @change="onChangeFloatValue('netSalesDinner')"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Customer Count - Totals</template>

          <template #input>
            <CustomInput
              v-model="customerCountTotals"
              placeholder="0.00"
              disabled
              symbol="$"
              is-float="true"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Net Sales - Totals</template>

          <template #input>
            <CustomInput
              v-model="netSalesTotals"
              placeholder="0.00"
              symbol="$"
              disabled
              is-float="true"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <div class="buttons-area">
        <DefaultButton
          button-color-gamma="red"
          :disabled="invalid"
          @event="closeRegisterOrderAction"
        >
          {{ `${!getIsEdit ? 'Save' : 'Edit'}` }}
        </DefaultButton>

        <DefaultButton
          button-color-gamma="white"
          :disabled="pristine && !getIsEdit"
          @event="getIsEdit ? cancelEdit() : cancelCreate()"
        >
          Cancel
        </DefaultButton>
      </div>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { formMixin } from '../mixins/formMixin'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomInput from './CustomInput.vue'
import { closeRegisterMixin } from '~/mixins/closeRegisterMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import CreateRegisterCloseout from '~/graphql/mutations/registerCloseout/createRegisterCloseout'
import UpdateRegisterCloseout from '~/graphql/mutations/registerCloseout/updateRegisterCloseout'
import RegisterCloseouts from '~/graphql/queries/registerCloseouts'
import { formatDateForCloseRegisterAPI } from '~/helpers/helpers'
import { CLOSE_REGISTER } from '~/constants/closeRegister'
import Me from '~/graphql/queries/me.query.gql'
import { meMixin } from '~/mixins/meMixin'
export default {
  name: 'CloseRegisterFinishCloseout',
  components: { InputRow, InputWithTitle, CustomInput, ValidationObserver },
  mixins: [formMixin, closeRegisterMixin, mutationMixin, meMixin],
  apollo: {
    me: {
      query: Me,
    },
  },
  data () {
    return {
      actualCashDeposit: '',
      customerCountBreakfast: '',
      customerCountLunch: '',
      netSalesBreakfast: '',
      netSalesLunch: '',
      customerCountDinner: '',
      netSalesDinner: '',
    }
  },
  computed: {
    /* actualCashDeposit: {
      get() {
        return this.getActualCashDeposit
      },
      set(value) {
        this.$store.dispatch('closeRegister/setActualCashDeposit', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    calculatedCashDeposit: {
      get() {
        return this.getCalculatedCashDeposit
      },
      set(value) {
        this.$store.commit('closeRegister/SET_CALCULATED_CASH_DEPOSIT', value)
      },
    },
    overShort: {
      get() {
        return this.getOverShort
      },
      set(value) {
        this.$store.commit('closeRegister/SET_OVER_SHORT', value)
      },
    },
    /* customerCountBreakfast: {
      get() {
        return this.getCustomerCountBreakfast
      },
      set(value) {
        this.$store.dispatch('closeRegister/setCustomerCountBreakfast', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    /* customerCountLunch: {
      get() {
        return this.getCustomerCountLunch
      },
      set(value) {
        this.$store.dispatch('closeRegister/setCustomerCountLunch', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    /* netSalesBreakfast: {
      get() {
        return this.getNetSalesBreakfast
      },
      set(value) {
        this.$store.dispatch('closeRegister/setNetSalesBreakfast', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    /* netSalesLunch: {
      get() {
        return this.getNetSalesLunch
      },
      set(value) {
        this.$store.dispatch('closeRegister/setNetSalesLunch', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    /* customerCountDinner: {
      get() {
        return this.getCustomerCountDinner
      },
      set(value) {
        this.$store.dispatch('closeRegister/setCustomerCountDinner', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    /* netSalesDinner: {
      get() {
        return this.getNetSalesDinner
      },
      set(value) {
        this.$store.dispatch('closeRegister/setNetSalesDinner', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
    customerCountTotals: {
      get() {
        return this.getCustomerCountTotals
      },
      set(value) {
        this.$store.commit('closeRegister/SET_CUSTOMER_COUNT_TOTALS', value)
      },
    },
    netSalesTotals: {
      get() {
        return this.getNetSalesTotals
      },
      set(value) {
        this.$store.commit('closeRegister/SET_NET_SALES_TOTAL', value)
      },
    },
  },
  methods: {
    onChangeFloatValue(stateProp) {
      this[stateProp] = parseFloat(this[stateProp] !== '' ? this[stateProp] : 0).toFixed(2);
      if ( stateProp === 'actualCashDeposit' ) {
        this.$store.dispatch('closeRegister/setActualCashDeposit', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      } else if ( stateProp === 'customerCountBreakfast' ) {
        this.$store.dispatch('closeRegister/setCustomerCountBreakfast', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      } else if ( stateProp === 'customerCountLunch' ) {
        this.$store.dispatch('closeRegister/setCustomerCountLunch', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      } else if ( stateProp === 'netSalesBreakfast' ) {
        this.$store.dispatch('closeRegister/setNetSalesBreakfast', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      } else if ( stateProp === 'netSalesLunch' ) {
        this.$store.dispatch('closeRegister/setNetSalesLunch', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      } else if ( stateProp === 'customerCountDinner' ) {
        this.$store.dispatch('closeRegister/setCustomerCountDinner', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      } else if ( stateProp === 'netSalesDinner' ) {
        this.$store.dispatch('closeRegister/setNetSalesDinner', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      }
    },
    formatDateForCloseRegisterAPI,
    async CreateCloseRegister() {
      const res = await this.mutationAction(
        CreateRegisterCloseout,
        {
          registerCloseoutInput: {
            nonResetable: String(this.getNonResetable),
            netTotal: String(this.getNetTotal),
            lastNonResetable: String(this.getLastNonResetable),
            netOV: String(this.getNetOV),
            totalToDistribute: String(this.getTotalToDistribute),
            netCharge: String(this.getNetCharge),
            taxFromTheTape: String(this.getTaxFromTheTape),
            netVoucher: String(this.getNetVoucher),
            overringVoidTax: String(this.getOverringVoidTax),
            netCash: String(this.getNetCash),
            chargeTax: String(this.getChargeTax),
            voucherTax: String(this.getVoucherTax),
            cashTax: String(this.getCashTax),
            totalPettyCash: String(this.getTotalPettyCash),
            actualCashDeposit: String(this.getActualCashDeposit),
            calculatedCashDeposit: String(this.getCalculatedCashDeposit),
            overShort: String(this.getOverShort),
            customerCountBreakfast: String(this.getCustomerCountBreakfast),
            netSalesBreakfast: String(this.getNetSalesBreakfast),
            customerCountLunch: String(this.getCustomerCountLunch),
            netSalesLunch: String(this.getNetSalesLunch),
            customerCountDinner: String(this.getCustomerCountDinner),
            netSalesDinner: String(this.getNetSalesDinner),
            customerCountTotals: String(this.getCustomerCountTotals),
            netSalesTotals: String(this.getNetSalesTotals),
            closeDate: this.formatDateForCloseRegisterAPI(new Date()),
            items: {
              create: this.getItems.map((item) => {
                return {
                  glAccountId: Number(item.glAccount.id),
                  amount: item.amount,
                }
              }),
            },
            register: {
              connect: this.getRegister.id,
            },
          },
        },
        RegisterCloseouts,
        'Close Register success',
        'Close Register error',
        {
          activePeriod: true,
        }
      )
      if (res) {
        this.$router.push('/home/close-register')
        this.$store.commit('closeRegister/SET_CLOSE_REGISTER', CLOSE_REGISTER)
      }
    },
    async UpdateCloseRegister() {
      const res = await this.mutationAction(
        UpdateRegisterCloseout,
        {
          registerCloseoutInput: {
            id: this.getId,
            nonResetable: String(this.getNonResetable),
            netTotal: String(this.getNetTotal),
            lastNonResetable: String(this.getLastNonResetable),
            netOV: String(this.getNetOV),
            totalToDistribute: String(this.getTotalToDistribute),
            netCharge: String(this.getNetCharge),
            taxFromTheTape: String(this.getTaxFromTheTape),
            netVoucher: String(this.getNetVoucher),
            overringVoidTax: String(this.getOverringVoidTax),
            netCash: String(this.getNetCash),
            chargeTax: String(this.getChargeTax),
            voucherTax: String(this.getVoucherTax),
            cashTax: String(this.getCashTax),
            totalPettyCash: String(this.getTotalPettyCash),
            actualCashDeposit: String(this.getActualCashDeposit),
            calculatedCashDeposit: String(this.getCalculatedCashDeposit),
            overShort: String(this.getOverShort),
            customerCountBreakfast: String(this.getCustomerCountBreakfast),
            netSalesBreakfast: String(this.getNetSalesBreakfast),
            customerCountLunch: String(this.getCustomerCountLunch),
            netSalesLunch: String(this.getNetSalesLunch),
            customerCountDinner: String(this.getCustomerCountDinner),
            netSalesDinner: String(this.getNetSalesDinner),
            customerCountTotals: String(this.getCustomerCountTotals),
            netSalesTotals: String(this.getNetSalesTotals),
            closeDate: this.getCloseDate,
            items: {
              delete: this.getDeleteItemIDs,
              update: this.getItems
                .filter((item) => item.id)
                .map((item) => {
                  return {
                    id: item.id,
                    glAccountId: Number(item.glAccount.id),
                    amount: String(item.amount),
                  }
                }),
              create: this.getItemsWithoutId.map((itm) => {
                return {
                  glAccountId: Number(itm.glAccount.id),
                  amount: itm.amount,
                }
              }),
            },
          },
        },
        RegisterCloseouts,
        'Close Register success',
        'Close Register error',
        {
          activePeriod: true,
        }
      )
      if (res) {
        this.$router.push('/review/register-closeout')
        this.$store.commit('closeRegister/SET_IS_EDIT', false)
        this.$store.commit('closeRegister/SET_CLOSE_REGISTER', CLOSE_REGISTER)
      }
    },
    closeRegisterOrderAction() {
      this.getIsEdit ? this.UpdateCloseRegister() : this.CreateCloseRegister()
    },
  },
}
</script>

<style lang="scss" scoped></style>
