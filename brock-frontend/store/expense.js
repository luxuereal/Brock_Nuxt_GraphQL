import { EXPENSE } from '~/constants/expense'

export const state = () => ({
  isEdit: false,
  expense: EXPENSE,
})

export const mutations = {
  SET_EXPENSE(state, payload) {
    state.expense = payload
  },
  SET_ID(state, payload) {
    state.expense.id = payload
  },
  SET_EXPENSE_DATE(state, payload) {
    state.expense.expenseDate = payload
  },
  SET_EXPENSE_TYPE(state, payload) {
    state.expense = {
      ...state.expense,
      expenseType: payload,
    }
  },
  SET_GL_ACCOUNT(state, payload) {
    state.expense = {
      ...state.expense,
      glAccount: payload,
    }
  },
  SET_AMOUNT(state, payload) {
    state.expense.amount = payload
  },
  SET_COMMENTS(state, payload) {
    state.expense.comments = payload
  },
  SET_VENDOR(state, payload) {
    state.expense = {
      ...state.expense,
      vendor: payload,
    }
  },
  SET_IS_EDIT(state, payload) {
    state.isEdit = payload
  },
}

export const getters = {
  getIsEdit: (state) => state.isEdit,
  getId: (state) => state.expense.id,
  getExpenseDate: (state) => state.expense.expenseDate,
  getExpenseType: (state) => state.expense.expenseType,
  getGlAccount: (state) => state.expense.glAccount,
  getAmount: (state) => state.expense.amount,
  getComments: (state) => state.expense.comments,
  getVendor: (state) => state.expense.vendor,
}
