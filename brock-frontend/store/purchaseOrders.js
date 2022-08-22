import { PURCHASE_ORDER } from '~/constants/purchaseOrder'

export const state = () => ({
  isEdit: false,
  purchaseOrder: PURCHASE_ORDER,
  deleteItemIDs: [],
})

export const mutations = {
  SET_PURCHASE_ORDER(state, payload) {
    state.purchaseOrder = payload
  },
  SET_ID(state, payload) {
    state.purchaseOrder.id = payload
  },
  SET_IS_EDIT(state, payload) {
    state.isEdit = payload
  },
  SET_DELETE_ITEM_IDS(state, payload) {
    state.deleteItemIDs = [...state.deleteItemIDs, payload]
  },
  SET_INVOICE_NUMBER(state, payload) {
    state.purchaseOrder.invoiceNumber = payload
  },
  SET_PURCHASE_DATE(state, payload) {
    state.purchaseOrder.purchaseDate = payload
  },
  SET_VENDOR(state, payload) {
    state.purchaseOrder = {
      ...state.purchaseOrder,
      vendor: payload,
    }
  },
  SET_PO_NUMBER(state, payload) {
    state.purchaseOrder.poNumber = payload
  },
  SET_PURCHASE_TOTAL(state, payload) {
    state.purchaseOrder.purchaseTotal = payload
  },
  SET_ITEM(state, payload) {
    state.purchaseOrder.items = [...state.purchaseOrder.items, payload]
  },
  SET_ITEMS(state, payload) {
    state.purchaseOrder.items = [...payload]
  },
}

export const getters = {
  getId: (state) => state.purchaseOrder.id,
  getInvoiceNumber: (state) => state.purchaseOrder.invoiceNumber,
  getPurchaseDate: (state) => state.purchaseOrder.purchaseDate,
  getVendor: (state) => state.purchaseOrder.vendor,
  getPoNumber: (state) => state.purchaseOrder.poNumber,
  getPurchaseTotal: (state) => state.purchaseOrder.purchaseTotal,
  getIsEdit: (state) => state.isEdit,
  getItems: (state) => state.purchaseOrder.items,
  getDeleteItemIDs: (state) => state.deleteItemIDs,
  getItemsWithoutId: (state) =>
    state.purchaseOrder.items.filter((item) => !item.id),
}
