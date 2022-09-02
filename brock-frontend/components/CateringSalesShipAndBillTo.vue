<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid, pristine }">
      <InputRow>
        <InputWithTitle max-width="500px">
          <template #title>Ship To Name</template>

          <template #input>
            <CustomInput v-model="shipToName" rules="required|max:255" name="Ship To Name" />
          </template>
        </InputWithTitle>

        <InputWithTitle max-width="500px">
          <template #title>Bill To Name</template>

          <template #input>
            <CustomInput v-model="billToName" rules="required|max:255" name="Bill To Name" />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle max-width="500px">
          <template #title>Ship To Address</template>

          <template #input>
            <CustomTextarea
              v-model="shipToAddress"
              rules="required|max:255"
              name="Ship To Address"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle max-width="500px">
          <template #title>Bill To Address</template>

          <template #input>
            <CustomTextarea
              v-model="billToAddress"
              rules="required|max:255"
              name="Bill To Address"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <div class="buttons-area">
        <DefaultButton
          button-color-gamma="red"
          :disabled="invalid"
          @event="cateringOrderAction"
        >
          {{ `${!getIsEdit ? 'Save' : 'Edit'}` }}
        </DefaultButton>

        <DefaultButton
          button-color-gamma="white"
          :disabled="isEmptyForm && pristine && !getIsEdit"
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
import CreateCateringOrder from '../graphql/mutations/cateringOrder/createCateringOrder.gql'
import UpdateCateringOrder from '../graphql/mutations/cateringOrder/updateCateringOrder.gql'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomInput from './CustomInput.vue'
import CustomTextarea from './CustomTextarea.vue'
import { mutationMixin } from '~/mixins/mutationMixin'
import { cateringSalesMixin } from '~/mixins/cateringSalesMixin'
import CateringOrders from '~/graphql/queries/cateringOrders.gql'
import { formatDate, formatDateAndTime } from '~/helpers/helpers'
// import { CATERING_ORDER } from '~/constants/cateringOrder'

export default {
  name: 'CateringSalesShipAndBillTo',
  components: {
    InputRow,
    InputWithTitle,
    CustomTextarea,
    ValidationObserver,
    CustomInput,
  },
  mixins: [formMixin, mutationMixin, cateringSalesMixin],
  data() {
    return {}
  },
  computed: {
    shipToName: {
      get() {
        return this.getShipToName
      },
      set(value) {
        this.$store.commit('cateringSales/SET_SHIP_TO_NAME', value)
      },
    },
    billToName: {
      get() {
        return this.getBillToName
      },
      set(value) {
        this.$store.commit('cateringSales/SET_BILL_TO_NAME', value)
      },
    },
    shipToAddress: {
      get() {
        return this.getShipToAddress
      },
      set(value) {
        this.$store.commit('cateringSales/SET_SHIP_TO_ADDRESS', value)
      },
    },
    billToAddress: {
      get() {
        return this.getBillToAddress
      },
      set(value) {
        this.$store.commit('cateringSales/SET_BILL_TO_ADDRESS', value)
      },
    },
    isEmptyForm() {
      return !this.getShipToName && !this.getBillToName && !this.getShipToAddress && !this.getBillToAddress
    }
  },
  methods: {
    formatDate,
    formatDateAndTime,
    async CreateCateringOrder() {
      const res = await this.mutationAction(
        CreateCateringOrder,
        {
          cateringOrderInput: {
            description: this.getDescription,
            deliveryDate: this.formatDateAndTime(this.getDeliveryDate),
            headCount: Number(this.getHeadCount),
            items: {
              create: this.getItemsWithoutId.map((item) => {
                const { tempId, ...rest } = item
                return rest
              }),
            },
            phoneNumber: this.getPhoneNumber,
            orderBy: this.getOrderBy,
            orderFor: this.getOrderFor,
            orderDate: this.formatDate(this.getOrderDate),
            isTaxable: this.getIsTaxable,
            tax: Number(this.getTax),
            shipToName: this.getShipToName,
            shipToAddress: this.getShipToAddress,
            billToName: this.getBillToName,
            billToAddress: this.getBillToAddress,
            isCashOrder: this.getIsCashOrder,
            chargeNumber: this.getChargeNumber,
          },
        },
        CateringOrders,
        'Add catering order success',
        'Add catering order error',
        {
          activePeriod: true,
        }
      )
      if (res) {
        this.$store.commit('tabsView/SET_ACTIVE_TAB', 0)
        this.$store.commit('cateringSales/SET_ID', res.data.createCateringOrder.id)
        // this.$store.commit('cateringSales/SET_CATERING_ORDER', CATERING_ORDER)
      }
    },
    async UpdateCateringOrder() {
      await this.mutationAction(
        UpdateCateringOrder,
        {
          cateringOrderInput: {
            id: this.getId,
            description: this.getDescription,
            deliveryDate: this.formatDateAndTime(this.getDeliveryDate),
            headCount: Number(this.getHeadCount),
            items: {
              delete: this.getDeleteItemIDs,
              update: this.getItems
                .map((item) => {
                  const { __typename, ...obj } = item

                  return obj
                })
                .filter((item) => item.id),
              create: this.getItemsWithoutId.map((item) => {
                const { tempId, ...rest } = item
                return rest
              }),
            },
            phoneNumber: this.getPhoneNumber,
            orderBy: this.getOrderBy,
            orderFor: this.getOrderFor,
            orderDate: this.formatDate(this.getOrderDate),
            isTaxable: this.getIsTaxable,
            tax: Number(this.getTax),
            shipToName: this.getShipToName,
            shipToAddress: this.getShipToAddress,
            billToName: this.getBillToName,
            billToAddress: this.getBillToAddress,
            isCashOrder: this.getIsCashOrder,
            chargeNumber: this.getChargeNumber,
          },
        },
        CateringOrders,
        'Edit catering order success',
        'Edit catering order error',
        {
          activePeriod: true,
        }
      )
      this.$router.push('/review/catering-sales')
    },
    cateringOrderAction() {
      this.getIsEdit ? this.UpdateCateringOrder() : this.CreateCateringOrder()
    },
  },
}
</script>

<style lang="scss" scoped>
.buttons-area {
  display: flex;
  margin-top: 30px;

  button:first-child {
    margin-right: 11px;
  }
}
</style>
