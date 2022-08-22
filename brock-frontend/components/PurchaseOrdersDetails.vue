<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid, pristine }">
      <InputRow>
        <InputWithTitle>
          <template #title>Invoice Number</template>

          <template #input>
            <CustomInput v-model="invoiceNumber" rules="required|max:255" name="Invoice Number" />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Purchase Date</template>

          <template #input>
            <CustomDatePicker
              v-model="purchaseDate"
              rules="required|date"
              name="Purchase Date"
              placeholder="mm/dd/yyyy"
              type="date"
              @input="(e) => onChangeDateValue(e)"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle has-select>
          <template #title>Vendor</template>

          <template #input>
            <CustomSelect
              v-if="vendors"
              :options="vendors"
              :selected-item="getIsEdit ? getVendor : null"
              select-by="name"
              @input="selectVendor"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>PO Number</template>

          <template #input>
            <CustomInput v-model="getId" disabled />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Purchase Total</template>

          <template #input>
            <CustomInput
              v-model.number="purchaseTotal"
              type="number"
              rules="required|currency"
              name="Purchase Total"
              placeholder="0.00"
              symbol="$"
              @change="onChangeFloatValue()"
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
import InputWithTitle from './InputWithTitle.vue'
import CustomInput from './CustomInput.vue'
import CustomDatePicker from './CustomDatePicker.vue'
import InputRow from './InputRow.vue'
import DefaultButton from './DefaultButton.vue'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { purchaseOrderMixin } from '~/mixins/purchaseOrderMixin'
import { tabsViewMixin } from '~/mixins/tabsViewMixin'
import Vendors from '~/graphql/queries/vendors.gql'
export default {
  name: 'PurchaseOrdersDetails',
  components: {
    InputWithTitle,
    CustomInput,
    CustomDatePicker,
    InputRow,
    DefaultButton,
    ValidationObserver,
  },
  apollo: {
    vendors: {
      query: Vendors,
    },
  },
  mixins: [formMixin, tabsViewMixin, tableActionsMixin, purchaseOrderMixin],
  computed: {
    invoiceNumber: {
      get() {
        return this.getInvoiceNumber
      },
      set(value) {
        this.$store.commit('purchaseOrders/SET_INVOICE_NUMBER', value)
      },
    },
    purchaseDate: {
      get() {
        return this.getPurchaseDate
      },
      set(value) {
        this.$store.commit('purchaseOrders/SET_PURCHASE_DATE', value)
      },
    },
    vendor: {
      get() {
        return this.getVendor
      },
      set(value) {
        this.$store.commit('purchaseOrders/SET_VENDOR', value)
      },
    },
    poNumber: {
      get() {
        return this.getPoNumber
      },
      set(value) {
        this.$store.commit('purchaseOrders/SET_PO_NUMBER', value)
      },
    },
    purchaseTotal: {
      get() {
        if (!this.getPurchaseTotal && this.getActiveTab !== 1) {
          this.$store.commit('tabsView/SET_ALLOW_SWITCH', false)
        }
        return this.getPurchaseTotal
      },
      set(value) {
        this.$store.commit('purchaseOrders/SET_PURCHASE_TOTAL', value)
      },
    },
  },
  watch: {
    purchaseTotal() {
      if (this.purchaseTotal) {
        this.$store.commit('tabsView/SET_ALLOW_SWITCH', true)
      } else if (this.getActiveTab !== 1) {
        this.$store.commit('tabsView/SET_ALLOW_SWITCH', false)
      }
    },
  },
  mounted() {
    if (this.getIsEdit) {
      this.$store.commit(
        'purchaseOrders/SET_PURCHASE_TOTAL',
        (this.purchaseTotal = this.getItems.reduce((prev, current) => {
          return Number(prev) + Number(current.amount)
        }, 0))
      )
    }
  },
  destroyed() {
    this.$store.commit('tabsView/SET_ALLOW_SWITCH', true)
  },
  methods: {
    selectVendor(vendor) {
      this.vendor = vendor
    },
    onChangeFloatValue() {
      this.purchaseTotal = parseFloat(this.purchaseTotal !== '' ? this.purchaseTotal : 0).toFixed(2);
      this.$store.dispatch('closeRegister/setPurchaseTotal', {
        ...this.calculationVariables,
        value: this.purchaseTotal,
      })
      // this.$store.commit('purchaseOrders/SET_PURCHASE_TOTAL', Number(this.purchaseTotal));
    },
    onChangeDateValue(value) {
      this.$store.commit('purchaseOrders/SET_PURCHASE_DATE', value)
    }
  },
}
</script>

<style lang="scss" scoped>
.buttons-area {
  display: flex;
  margin-top: 50px;

  button:first-child {
    margin-right: 11px;
  }
}
</style>
