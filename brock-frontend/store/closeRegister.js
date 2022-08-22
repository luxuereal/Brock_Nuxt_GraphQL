import { CLOSE_REGISTER } from '~/constants/closeRegister'
import RegisterCloseoutCalculation
  from '~/graphql/mutations/registerCloseout/registerCloseoutCalculation'

export const state = () => ({
  isEdit: false,
  closeRegister: CLOSE_REGISTER,
  deleteItemIDs: [],
})

export const mutations = {
  SET_CLOSE_REGISTER(state, payload) {
    state.closeRegister = payload
  },
  SET_IS_EDIT(state, payload) {
    state.isEdit = payload
  },
  SET_DELETE_ITEM_IDS(state, payload) {
    state.deleteItemIDs = [...state.deleteItemIDs, payload]
  },
  SET_ID(state, payload) {
    state.closeRegister.id = payload
  },
  SET_REGISTER(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      register: payload,
    }
  },
  SET_ITEMS(state, payload) {
    state.closeRegister.items = [...payload]
  },
  SET_ITEM(state, payload) {
    state.closeRegister.items = [...state.closeRegister.items, payload]
  },
  SET_UNIT(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      unit: payload,
    }
  },
  SET_NON_RESETABLE(state, payload) {
    state.closeRegister.nonResetable = payload
  },
  SET_NET_TOTAL(state, payload) {
    state.closeRegister.netTotal = payload
  },
  SET_LAST_NON_RESETTABLE(state, payload) {
    state.closeRegister.lastNonResetable = payload
  },
  SET_NET_OV(state, payload) {
    state.closeRegister.netOV = payload
  },
  SET_TOTAL_TO_DISTRIBUTE(state, payload) {
    state.closeRegister.totalToDistribute = payload
  },
  SET_NET_CHARGE(state, payload) {
    state.closeRegister.netCharge = payload
  },
  SET_TAX_FROM_THE_TAPE(state, payload) {
    state.closeRegister.taxFromTheTape = payload
  },
  SET_NET_VOUCHER(state, payload) {
    state.closeRegister.netVoucher = payload
  },
  SET_OVERRING_TAX(state, payload) {
    state.closeRegister.overringVoidTax = payload
  },
  SET_NET_CASH(state, payload) {
    state.closeRegister.netCash = payload
  },
  SET_CHARGE_TAX(state, payload) {
    state.closeRegister.chargeTax = payload
  },
  SET_VOUCHER_TAX(state, payload) {
    state.closeRegister.voucherTax = payload
  },
  SET_CASH_TAX(state, payload) {
    state.closeRegister.cashTax = payload
  },
  SET_TOTAL_PETTY_CASH(state, payload) {
    state.closeRegister.totalPettyCash = payload
  },
  SET_ACTUAL_CASH_DEPOSIT(state, payload) {
    state.closeRegister.actualCashDeposit = payload
  },
  SET_CALCULATED_CASH_DEPOSIT(state, payload) {
    state.closeRegister.calculatedCashDeposit = payload
  },
  SET_OVER_SHORT(state, payload) {
    state.closeRegister.overShort = payload
  },
  SET_CUSTOMER_COUNT_BREAKFAST(state, payload) {
    state.closeRegister.customerCountBreakfast = payload
  },
  SET_NET_SALES_BREAKFAST(state, payload) {
    state.closeRegister.netSalesBreakfast = payload
  },
  SET_CUSTOMER_COUNT_LUNCH(state, payload) {
    state.closeRegister.customerCountLunch = payload
  },
  SET_NET_SALES_LUNCH(state, payload) {
    state.closeRegister.netSalesLunch = payload
  },
  SET_CUSTOMER_COUNT_DINNER(state, payload) {
    state.closeRegister.customerCountDinner = payload
  },
  SET_NET_SALES_DINNER(state, payload) {
    state.closeRegister.netSalesDinner = payload
  },
  SET_CUSTOMER_COUNT_TOTALS(state, payload) {
    state.closeRegister.customerCountTotals = payload
  },
  SET_NET_SALES_TOTAL(state, payload) {
    state.closeRegister.netSalesTotals = payload
  },
  SET_CLOSE_DATE(state, payload) {
    state.closeRegister.closeDate = payload
  },
  SET_TOTAL_NET_SALES(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      totalNetSales: payload,
    }
  },
  SET_TOTAL_DAILY_DEPOSIT(state, payload) {
    state.closeRegister.totalDailyDeposit = payload
  },
  SET_PETTY_CASH(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      pettyCash: payload,
    }
  },
  SET_CHARGE(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      charge: payload,
    }
  },
  SET_CASH_TOTAL(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      cashTotal: payload,
    }
  },
  SET_CALCED_DEPOSIT(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      calcedDeposit: payload,
    }
  },
  SET_ACTUAL_DEPOSIT(state, payload) {
    state.closeRegister = {
      ...state.closeRegister,
      actualDeposit: payload,
    }
  },
}

export const actions = {
  calculate({ getters, commit }, data) {
    if (this.timer) {
      clearTimeout(this.timer)
      this.timer = null
    }
    this.timer = setTimeout(async () => {
      const fields = {
        nonResetable: getters.getNonResetable,
        NetOV: getters.getNetOV,
        netCharge: getters.getNetCharge,
        taxFromTheTape: getters.getTaxFromTheTape,
        netVoucher: getters.getNetVoucher,
        overringVoidTax: getters.getOverringVoidTax,
        chargeTax: getters.getChargeTax,
        voucherTax: getters.getVoucherTax,
        totalPettyCash: getters.getTotalPettyCash,
        actualCashDeposit: getters.getActualCashDeposit,
        customerCountBreakfast: getters.getCustomerCountBreakfast,
        netSalesBreakfast: getters.getNetSalesBreakfast,
        customerCountLunch: getters.getCustomerCountLunch,
        netSalesLunch: getters.getNetSalesLunch,
        customerCountDinner: getters.getCustomerCountDinner,
        netSalesDinner: getters.getNetSalesDinner,
      }

      const {
        data: { registerCloseoutCalculation },
      } = await this.app.apolloProvider.defaultClient.mutate({
        mutation: RegisterCloseoutCalculation,
        variables: {
          registerCloseoutCalculationInput: {
            registerId: getters.getRegister.id,
            unitId: data.unitId,
            periodId: data.periodId,
            fields,
          },
        },
      })

      const fieldsResponse = registerCloseoutCalculation.fields
      const statistics = registerCloseoutCalculation.statistics

      for (const [key, value] of Object.entries({
        ...fieldsResponse,
        ...statistics,
      })) {
        if (key !== '__typename') {
          const transformedKey = key
            .split(/(?=[A-Z])/)
            .join('_')
            .toUpperCase()
          await commit(`SET_${transformedKey}`, value)
        }
      }
    }, 1000)
  },
  async setNonResetable({ dispatch, commit }, data) {
    await commit('SET_NON_RESETABLE', data.value)
    dispatch('calculate', data)
  },
  async setNetOV({ dispatch, commit }, data) {
    await commit('SET_NET_OV', data.value)
    dispatch('calculate', data)
  },
  async setNetCharge({ dispatch, commit }, data) {
    await commit('SET_NET_CHARGE', data.value)
    dispatch('calculate', data)
  },
  async setTaxFromTheTape({ dispatch, commit }, data) {
    await commit('SET_TAX_FROM_THE_TAPE', data.value)
    dispatch('calculate', data)
  },
  async setNetVoucher({ dispatch, commit }, data) {
    await commit('SET_NET_VOUCHER', data.value)
    dispatch('calculate', data)
  },
  async setOverringTax({ dispatch, commit }, data) {
    await commit('SET_OVERRING_TAX', data.value)
    dispatch('calculate', data)
  },
  async setChargeTax({ dispatch, commit }, data) {
    await commit('SET_CHARGE_TAX', data.value)
    dispatch('calculate', data)
  },
  async setVoucherTax({ dispatch, commit }, data) {
    await commit('SET_VOUCHER_TAX', data.value)
    dispatch('calculate', data)
  },
  async setTotalPettyCash({ dispatch, commit }, data) {
    await commit('SET_TOTAL_PETTY_CASH', data.value)
    dispatch('calculate', data)
  },
  async setActualCashDeposit({ dispatch, commit }, data) {
    await commit('SET_ACTUAL_CASH_DEPOSIT', data.value)
    dispatch('calculate', data)
  },
  async setCustomerCountBreakfast({ dispatch, commit }, data) {
    await commit('SET_CUSTOMER_COUNT_BREAKFAST', data.value)
    dispatch('calculate', data)
  },
  async setCustomerCountLunch({ dispatch, commit }, data) {
    await commit('SET_CUSTOMER_COUNT_LUNCH', data.value)
    dispatch('calculate', data)
  },
  async setNetSalesBreakfast({ dispatch, commit }, data) {
    await commit('SET_NET_SALES_BREAKFAST', data.value)
    dispatch('calculate', data)
  },
  async setNetSalesLunch({ dispatch, commit }, data) {
    await commit('SET_NET_SALES_LUNCH', data.value)
    dispatch('calculate', data)
  },
  async setCustomerCountDinner({ dispatch, commit }, data) {
    await commit('SET_CUSTOMER_COUNT_DINNER', data.value)
    dispatch('calculate', data)
  },
  async setNetSalesDinner({ dispatch, commit }, data) {
    await commit('SET_NET_SALES_DINNER', data.value)
    dispatch('calculate', data)
  },
  async setCloseRegister({ dispatch, commit }, data) {
    await commit('SET_CLOSE_REGISTER', data)
    dispatch('calculate', {
      unitId: +data.unit.id,
      periodId: +data.unit.activePeriod.id,
    })
  },
}

export const getters = {
  getId: (state) => state.closeRegister.id,
  getRegister: (state) => state.closeRegister.register,
  getItems: (state) => state.closeRegister.items,
  getUnit: (state) => state.closeRegister.unit,
  getNonResetable: (state) => Number(state.closeRegister.nonResetable),
  getNetTotal: (state) => Number(state.closeRegister.netTotal),
  getLastNonResetable: (state) => Number(state.closeRegister.lastNonResetable),
  getNetOV: (state) => Number(state.closeRegister.netOV),
  getTotalToDistribute: (state) =>
    Number(state.closeRegister.totalToDistribute),
  getNetCharge: (state) => Number(state.closeRegister.netCharge),
  getTaxFromTheTape: (state) => Number(state.closeRegister.taxFromTheTape),
  getNetVoucher: (state) => Number(state.closeRegister.netVoucher),
  getOverringVoidTax: (state) => Number(state.closeRegister.overringVoidTax),
  getNetCash: (state) => Number(state.closeRegister.netCash),
  getChargeTax: (state) => Number(state.closeRegister.chargeTax),
  getVoucherTax: (state) => Number(state.closeRegister.voucherTax),
  getCashTax: (state) => Number(state.closeRegister.cashTax),
  getTotalPettyCash: (state) => Number(state.closeRegister.totalPettyCash),
  getActualCashDeposit: (state) =>
    Number(state.closeRegister.actualCashDeposit),
  getCalculatedCashDeposit: (state) =>
    Number(state.closeRegister.calculatedCashDeposit),
  getOverShort: (state) => Number(state.closeRegister.overShort),
  getCustomerCountBreakfast: (state) =>
    Number(state.closeRegister.customerCountBreakfast),
  getNetSalesBreakfast: (state) =>
    Number(state.closeRegister.netSalesBreakfast),
  getCustomerCountLunch: (state) =>
    Number(state.closeRegister.customerCountLunch),
  getNetSalesLunch: (state) => Number(state.closeRegister.netSalesLunch),
  getCustomerCountDinner: (state) =>
    Number(state.closeRegister.customerCountDinner),
  getNetSalesDinner: (state) => Number(state.closeRegister.netSalesDinner),
  getCustomerCountTotals: (state) =>
    Number(state.closeRegister.customerCountTotals),
  getNetSalesTotals: (state) => Number(state.closeRegister.netSalesTotals),
  getCloseDate: (state) => state.closeRegister.closeDate,
  getIsEdit: (state) => state.isEdit,
  getDeleteItemIDs: (state) => state.deleteItemIDs,
  getItemsWithoutId: (state) =>
    state.closeRegister.items.filter((item) => !item.id),
  getTotalNetSale: (state) => state.closeRegister.totalNetSales,
  getTotalDailyDeposit: (state) =>
    Number(state.closeRegister.totalDailyDeposit),
  getPettyCash: (state) => state.closeRegister.pettyCash,
  getCharge: (state) => state.closeRegister.charge,
  getCashTotal: (state) => state.closeRegister.cashTotal,
  getCalcedDeposit: (state) => state.closeRegister.calcedDeposit,
  getActualDeposit: (state) => state.closeRegister.actualDeposit,
}
