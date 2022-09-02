import { mapGetters } from 'vuex'
import { CLOSE_REGISTER } from '~/constants/closeRegister'

export const closeRegisterMixin = {
  computed: {
    ...mapGetters({
      getId: 'closeRegister/getId',
      getRegister: 'closeRegister/getRegister',
      getItems: 'closeRegister/getItems',
      getUnit: 'closeRegister/getUnit',
      getNonResetable: 'closeRegister/getNonResetable',
      getNetTotal: 'closeRegister/getNetTotal',
      getLastNonResetable: 'closeRegister/getLastNonResetable',
      getNetOV: 'closeRegister/getNetOV',
      getTotalToDistribute: 'closeRegister/getTotalToDistribute',
      getNetCharge: 'closeRegister/getNetCharge',
      getTaxFromTheTape: 'closeRegister/getTaxFromTheTape',
      getNetVoucher: 'closeRegister/getNetVoucher',
      getOverringVoidTax: 'closeRegister/getOverringVoidTax',
      getNetCash: 'closeRegister/getNetCash',
      getChargeTax: 'closeRegister/getChargeTax',
      getVoucherTax: 'closeRegister/getVoucherTax',
      getCashTax: 'closeRegister/getCashTax',
      getTotalPettyCash: 'closeRegister/getTotalPettyCash',
      getActualCashDeposit: 'closeRegister/getActualCashDeposit',
      getCalculatedCashDeposit: 'closeRegister/getCalculatedCashDeposit',
      getOverShort: 'closeRegister/getOverShort',
      getCustomerCountBreakfast: 'closeRegister/getCustomerCountBreakfast',
      getNetSalesBreakfast: 'closeRegister/getNetSalesBreakfast',
      getCustomerCountLunch: 'closeRegister/getCustomerCountLunch',
      getNetSalesLunch: 'closeRegister/getNetSalesLunch',
      getCustomerCountDinner: 'closeRegister/getCustomerCountDinner',
      getNetSalesDinner: 'closeRegister/getNetSalesDinner',
      getCustomerCountTotals: 'closeRegister/getCustomerCountTotals',
      getNetSalesTotals: 'closeRegister/getNetSalesTotals',
      getCloseDate: 'closeRegister/getCloseDate',
      getIsEdit: 'closeRegister/getIsEdit',
      getIsCancel: 'closeRegister/getIsCancel',
      getDeleteItemIDs: 'closeRegister/getDeleteItemIDs',
      getItemsWithoutId: 'closeRegister/getItemsWithoutId',
      getTotalNetSale: 'closeRegister/getTotalNetSale',
      getTotalDailyDeposit: 'closeRegister/getTotalDailyDeposit',
      getPettyCash: 'closeRegister/getPettyCash',
      getCharge: 'closeRegister/getCharge',
      getCashTotal: 'closeRegister/getCashTotal',
      getCalcedDeposit: 'closeRegister/getCalcedDeposit',
      getActualDeposit: 'closeRegister/getActualDeposit',
    }),
  },
  methods: {
    resetForm() {
      this.$refs.form.reset()
    },
    cancelEdit() {
      this.$router.push('/review/register-closeout')
      this.resetForm()
    },
    cancelCreate() {
      this.$store.commit('closeRegister/SET_IS_CANCEL', true)
      this.$store.commit('closeRegister/SET_CLOSE_REGISTER', {
        ...CLOSE_REGISTER,
      })
      this.resetForm()
    },
  },
}
