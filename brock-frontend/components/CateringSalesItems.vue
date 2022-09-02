<template>
  <ValidationObserver ref="form" v-slot="{ invalid }">
    <CustomTable>
      <template #header>
        <div class="table-row">
          <span>Quantity</span>

          <span>Menu Item</span>

          <span>Unit Price</span>

          <span>Ext</span>
        </div>
      </template>

      <template #content>
        <CustomTableRow
          v-for="item in combinedItemsArray"
          :key="item.id"
          class="table-row"
        >
          <span v-if="!getIsEdit">{{ item.quantity }}</span>
          <CustomInput
            v-else
            :value="item.quantity"
            do-not-show-error-message
            rules="required|numeric"
            name="Quantity"
            type="number"
            @input="(e) => updateItems(item, Number(e), 'quantity')"
          />

          <span v-if="!getIsEdit">{{ item.menuItem }}</span>
          <CustomInput
            v-else
            :value="item.menuItem"
            do-not-show-error-message
            rules="required|max:255"
            name="Menu Item"
            @input="(e) => updateItems(item, Number(e), 'menuItem')"
          />

          <span v-if="!getIsEdit">${{ parseFloat(item.price).toFixed(2) }}</span>
          <CustomInput
            v-else
            :value="item.price"
            rules="required|currency"
            name="Unit Price"
            do-not-show-error-message
            placeholder="0.00"
            symbol="$"
            type="double"
            @input="(e) => updateItems(item, Number(e), 'price')"
          />

          <span v-if="!getIsEdit">${{ parseFloat(item.ext).toFixed(2) }}</span>
          <CustomInput
            v-else
            :value="item.ext"
            rules="required|currency"
            name="Ext"
            do-not-show-error-message
            placeholder="0.00"
            symbol="$"
            type="double"
            @input="(e) => updateItems(item, Number(e), 'ext')"
          />

          <img
            src="~assets/images/icons/home/delete.svg"
            class="icon"
            @click="deleteItem(item)"
          />
        </CustomTableRow>

        <CustomTableRow v-if="isAdd" class="table-row">
          <CustomInput
            v-model.number="newItem.quantity"
            type="number"
            do-not-show-error-message
            rules="required|numeric"
            name="Quantity"
          />

          <CustomInput
            v-model.number="newItem.menuItem"
            do-not-show-error-message
            rules="required|max:255"
            name="Menu Item"
          />

          <CustomInput
            v-model.number="newItem.price"
            type="double"
            rules="required|currency"
            name="Unit Price"
            do-not-show-error-message
            placeholder="0.00"
            symbol="$"
            @change="onChangeFloatValue('price')"
          />

          <CustomInput
            v-model.number="newItem.ext"
            type="double"
            rules="required|currency"
            name="Ext"
            do-not-show-error-message
            placeholder="0.00"
            symbol="$"
            @change="onChangeFloatValue('ext')"
          />
        </CustomTableRow>

        <CustomTableRow class="table-row add-row">
          <CustomTableAddIcon :is-hide="isHide" @add-row="addRow" />
        </CustomTableRow>

        <div v-if="isAdd" class="buttons-area add-item-buttons">
          <DefaultButton @event="addItem">+ Add Item </DefaultButton>

          <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
        </div>

        <CustomTableRow v-if="isTaxable" class="table-footer table-row">
          <span class="table-footer-caption">Price</span>

          <span class="table-footer-item">${{ totalPrice.toFixed(2) }}</span>
        </CustomTableRow>

        <CustomTableRow v-if="isTaxable" class="table-footer table-row">
          <span class="table-footer-caption">Tax</span>

          <!-- <CustomInput
            v-model.number="tax"
            type="number"
            placeholder="0.00"
            do-not-show-error-message
            rules="currency"
            name="Tax"
            symbol="$"
            @change="onChangeFloatValue('tax')"
          /> -->

          <span class="table-footer-item">${{ totalTax.toFixed(2) }}</span>

        </CustomTableRow>

        <CustomTableRow class="table-footer table-row">
          <span class="table-footer-caption">Total</span>

          <span class="table-footer-item">${{ totalPriceWithTax.toFixed(2) }}</span>
        </CustomTableRow>
      </template>
    </CustomTable>

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
        @event="getIsEdit ? cancelEdit() : cancelCreate()"
        >Cancel</DefaultButton
      >
    </div>
  </ValidationObserver>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { formMixin } from '../mixins/formMixin'
import CustomTable from './CustomTable.vue'
import CustomInput from './CustomInput.vue'
import CustomTableRow from './CustomTableRow.vue'
import DefaultButton from './DefaultButton.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { cateringSalesMixin } from '~/mixins/cateringSalesMixin'
import { tabsViewMixin } from '~/mixins/tabsViewMixin'
import { meMixin } from '~/mixins/meMixin'

export default {
  name: 'CateringSalesItems',
  components: {
    CustomTable,
    CustomInput,
    CustomTableRow,
    DefaultButton,
    ValidationObserver,
    CustomTableAddIcon,
},
  mixins: [formMixin, tableActionsMixin, cateringSalesMixin, tabsViewMixin, meMixin],
  data() {
    return {
      newItem: {
        quantity: '',
        menuItem: '',
        price: '',
        ext: '',
      },
    }
  },
  computed: {
    isTaxable: {
      get() {
        return this.getIsTaxable
      },
    },
    combinedItemsArray() {
      return [...this.getItems]
    },
    totalPrice() {
      return this.getItems.reduce((prev, current) => {
        return (
          Number(prev) +
          Number(
            Number(current.quantity) * Number(current.price) + Number(current.ext)
          )
        )
      }, 0) +
          Number(
            Number(this.newItem.quantity) * Number(this.newItem.price) + Number(this.newItem.ext)
          )
    },
    totalTax() {
      if (!this.isTaxable)
        return 0;

      const salesTaxCafe = this.selectedUnit.city.state.salesTaxCafeteria
      const countyTax = this.selectedUnit.county.tax
      const cityTax = this.selectedUnit.city.tax

      const cateringTax = Number(this.totalPrice) * (Number(salesTaxCafe) + Number(countyTax) + Number(cityTax))
      return cateringTax
    },
    totalPriceWithTax() {
      return Number(this.totalPrice) + Number(this.getTax)
    }
  },
  methods: {
    onChangeFloatValue(stateProp) {
      if ( stateProp === 'price' || stateProp === 'ext' ) {
        this.newItem[stateProp] = parseFloat(Number(this.newItem[stateProp] !== '' ? this.newItem[stateProp] : 0).toFixed(2))
      }
    },
    updateItems(item, event, itemProp) {
      this.$store.commit(
        'cateringSales/SET_ITEMS',
        this.getItems.map((vuexItem) => {
          if (
            item.id
              ? vuexItem.id === item.id
              : Number(vuexItem.tempId) === Number(item.tempId)
          ) {
            return {
              ...vuexItem,
              [itemProp]: event,
            }
          }

          return vuexItem
        })
      )
    },
    deleteItem(cateringOrder) {
      if (this.getIsEdit && cateringOrder.id) {
        this.$store.commit(
          'cateringSales/SET_DELETE_ITEM_IDS',
          cateringOrder.id
        )
      }
      this.$store.commit(
        'cateringSales/SET_ITEMS',
        this.getItems.filter((vuexItem) =>
          cateringOrder.id
            ? Number(vuexItem.id) !== Number(cateringOrder.id)
            : Number(vuexItem.tempId) !== Number(cateringOrder.tempId)
        )
      )
    },
    async addItem() {
      const formValidated =
        this.$refs.form && (await this.$refs.form.validate())

      if (formValidated) {
        if (this.newItem.quantity) {
          this.$store.commit('cateringSales/SET_TAX', this.totalTax.toFixed(2))
          this.$store.commit('cateringSales/SET_ITEM', {
            ...this.newItem,
            tempId: new Date(),
          })
        }

        this.isAdd = false
        this.isHide = false
        this.newItem = {
          quantity: '',
          menuItem: '',
          price: '',
          ext: '',
        }
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  grid-template-columns: 207px 326px 194px 230px 20px;
  column-gap: 20px;
}

.table-footer {
  height: 63px;

  &:last-child {
    border: none;
  }

  &-caption {
    grid-column: 3;
  }

  &-item {
    grid-column: 4;
  }
}

.buttons-area {
  margin-top: 40px;

  button:first-child {
    margin-right: 11px;
  }
}

.add-item-buttons {
  margin-left: 25px;
}

.icon {
  cursor: pointer;

  &--add {
    grid-column: 5;
  }
}
</style>
