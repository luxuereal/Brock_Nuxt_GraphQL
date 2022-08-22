export const state = () => ({
  showAddUnit: 'HQUnitsTableContent',
  unitID: '',
  unit: {
    code: '',
    address: '',
    name: '',
    city: {
      id: '',
      name: '',
      tax: '',
      createdAt: '',
      updatedAt: '',
      state: {
        id: '',
        code: '',
      },
    },
    district: '',
    county: '',
    population: '',
    state: {
      id: '',
      code: '',
      salesTaxCafeteria: '',
      salesTaxVending: '',
      salesTaxRestaurant: '',
      salesTaxStore: '',
      grossReceiptsTax: '',
      createdAt: '',
      updatedAt: '',
      cities: [],
      counties: [],
    },
    managerFirstName: '',
    zip: '',
    managerLastName: '',
    payrollPassword: '',
    emailAccount: '',
    users: [],
    sysco: '',
    payrollTaxPercent: '',
    benefitsAmount: '',
    vendingIncome: '',
    commissionAmount: '',
    vacationAmount: '',
    isVending: false,
    isActive: false,
    businessInsuranceAmount: '',
    managementFeeType: '',
    managementAmount: '',
    managementPercent: '',
    administrativeFeeType: '',
    administrativeAmount: '',
    administrativePercent: '',
    supportAmount: '',
    supportFeeType: '',
    supportPercent: '',
    benefitsPercent: '',
    regTax: '',
    commissionPercent: '',
    isKronos: false,
  },
})

export const mutations = {
  SET_SHOW_ADD_UNIT(state, payload) {
    state.showAddUnit = payload
  },
  SET_UNIT_ID(state, payload) {
    state.unitID = payload
  },
  SET_UNIT(state, payload) {
    state.unit = payload
  },
  SET_UNIT_NUM(state, payload) {
    state.unit.code = payload
  },
  SET_UNIT_STREET_ADDRESS(state, payload) {
    state.unit.address = payload
  },
  SET_UNIT_NAME(state, payload) {
    state.unit.name = payload
  },
  SET_UNIT_CITY(state, payload) {
    state.unit = {
      ...state.unit,
      city: payload,
    }
  },
  SET_UNIT_DISTRICT(state, payload) {
    state.unit = {
      ...state.unit,
      district: payload,
    }
  },
  SET_UNIT_COUNTY(state, payload) {
    state.unit = {
      ...state.unit,
      county: payload,
    }
  },
  SET_UNIT_START_PERIOD(state, payload) {
    state.unit = {
      ...state.unit,
      startPeriod: payload,
    }
  },
  SET_UNIT_POPULATION(state, payload) {
    state.unit.population = payload
  },
  SET_UNIT_STATE(state, payload) {
    state.unit = {
      ...state.unit,
      state: payload,
    }
  },
  SET_UNIT_MGR_FIRST_NAME(state, payload) {
    state.unit.managerFirstName = payload
  },
  SET_UNIT_MGR_LAST_NAME(state, payload) {
    state.unit.managerLastName = payload
  },
  SET_UNIT_MGR_ZIP_CODE(state, payload) {
    state.unit.zip = payload
  },
  SET_UNIT_PASSWORD(state, payload) {
    state.unit.payrollPassword = payload
  },
  SET_UNIT_EMAIL(state, payload) {
    state.unit.emailAccount = payload
  },
  SET_UNIT_SYSCO(state, payload) {
    state.unit.sysco = payload
  },

  SET_UNIT_USERS(state, payload) {
    state.unit = {
      ...state.unit,
      users: [payload],
    }
  },
  SET_UNIT_PAYROLL_TAX(state, payload) {
    state.unit.payrollTaxPercent = payload
  },
  SET_UNIT_BENEFIT_DOLLARS(state, payload) {
    state.unit.benefitsAmount = payload
  },
  SET_UNIT_VENDING_INCOME(state, payload) {
    state.unit.vendingIncome = payload
  },
  SET_UNIT_COMMISSION_DOLLARS(state, payload) {
    state.unit.commissionAmount = payload
  },
  SET_UNIT_VACATION_DOLLARS(state, payload) {
    state.unit.vacationAmount = payload
  },
  SET_UNIT_IS_VENDING(state, payload) {
    state.unit.isVending = payload
  },
  SET_UNIT_IS_ACTIVE(state, payload) {
    state.unit.isActive = payload
  },
  SET_UNIT_BUSINESS_INSURANCE(state, payload) {
    state.unit.businessInsuranceAmount = payload
  },
  SET_UNIT_MANAGEMENT_FEE_TYPE(state, payload) {
    state.unit.managementFeeType = payload
  },
  SET_UNIT_MANAGEMENT_FEE_DOLLAR(state, payload) {
    state.unit.managementAmount = payload
  },
  SET_UNIT_MANAGEMENT_FEE_PERCENT(state, payload) {
    state.unit.managementPercent = payload
  },
  SET_UNIT_ADMINISTRATIVE_FEE_TYPE(state, payload) {
    state.unit.administrativeFeeType = payload
  },
  SET_UNIT_ADMINISTRATIVE_FEE_DOLLAR(state, payload) {
    state.unit.administrativeAmount = payload
  },
  SET_UNIT_ADMINISTRATIVE_FEE_PERCENT(state, payload) {
    state.unit.administrativePercent = payload
  },
  SET_UNIT_SUPPORT_FEE_TYPE(state, payload) {
    state.unit.supportFeeType = payload
  },
  SET_UNIT_SUPPORT_FEE_DOLLAR(state, payload) {
    state.unit.supportAmount = payload
  },
  SET_UNIT_SUPPORT_FEE_PERCENT(state, payload) {
    state.unit.supportPercent = payload
  },
  SET_UNIT_BENEFITS_PERCENT(state, payload) {
    state.unit.benefitsPercent = payload
  },
  SET_UNIT_REG_TAX(state, payload) {
    state.unit = {
      ...state.unit,
      regTax: payload,
    }
  },
  SET_UNIT_COMMISSION_PERCENT(state, payload) {
    state.unit.commissionPercent = payload
  },
  SET_UNIT_KRONOS(state, payload) {
    state.unit.isKronos = payload
  },
}

export const actions = {
  setShowAddUnit({ commit }, data) {
    commit('SET_SHOW_ADD_UNIT', data)
  },
  setUnitID({ commit }, data) {
    commit('SET_UNIT_ID', data)
  },
  setUnit({ commit }, data) {
    commit('SET_UNIT', data)
  },
}

export const getters = {
  getShowAddUnit: (state) => state.showAddUnit,
  getUnitID: (state) => state.unitID,
  getUnit: (state) => state.unit,
}
