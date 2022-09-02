<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid, pristine }">
      <div class="input-row">
        <InputWithTitle>
          <template #title> Total Petty Cash </template>

          <template #input>
            <CustomInput
              v-model.number="totalPettyCash"
              type="double"
              rules="required|currency"
              placeholder="0.00"
              name="Total Petty Cash"
              symbol="$"
              @change="onChangeFloatValue('totalPettyCash')"
            />
          </template>
        </InputWithTitle>
      </div>

      <CustomTable>
        <template #header>
          <div class="table-row">
            <span>GL Account</span>

            <span>Amount</span>
          </div>
        </template>

        <template #content>
          <CustomTableRow
            v-for="item in getItems"
            :key="item.id"
            class="table-row"
          >
            <CustomSelect
              v-if="me.selectedUnit.glAccounts && getIsEdit"
              :options="me.selectedUnit.glAccounts"
              select-by="name"
              select-by-second="id"
              select-by-parent="parent"
              :selected-item="
                me.selectedUnit.glAccounts.find((glAccount) =>
                  item.glAccountId
                    ? glAccount.id == item.glAccountId
                    : glAccount.id == item.glAccount.id
                )
              "
              input-select
              @input="selectGlAccount(item, $event)"
            />
            <span v-else-if="!getIsEdit && item.glAccount.parent">{{ item.glAccount.parent.id }}-{{ item.glAccount.id }} - {{ item.glAccount.name }}</span>
            <span v-else>{{ item.glAccount.id }} - {{ item.glAccount.name }}</span>

            <CustomInput
              :value="item.amount"
              do-not-show-error-message
              placeholder="0.00"
              symbol="$"
              rules="required|currency"
              name="Petty Cash Amount"
              type="double"
              is-float="true"
              @input="(e) => updateItems(item, e, 'amount')"
            />
            <img
              src="~assets/images/icons/home/delete.svg"
              class="icon"
              @click="deleteRow(item)"
            />
          </CustomTableRow>

          <CustomTableRow v-if="isAdd" class="table-row">
            <CustomSelect
              v-if="me.selectedUnit.glAccounts"
              :options="me.selectedUnit.glAccounts"
              select-by="name"
              select-by-second="id"
              select-by-parent="parent"
              input-select
              @input="selectWewItemGlAccount"
            />

            <CustomInput
              v-model.number="newItem.amount"
              placeholder="0.00"
              symbol="$"
              do-not-show-error-message
              type="double"
              rules="required|currency"
              name="Petty Cash Amount"
              @change="onChangeFloatValue('amount', true)"
            />
          </CustomTableRow>

          <CustomTableRow v-if="leftToDistribute > 0" class="table-row add-row">
            <img
              src="~assets/images/icons/home/add.svg"
              class="icon icon--add"
              @click="addRow"
            />
          </CustomTableRow>

          <div v-if="isAdd" class="buttons-area add-item-buttons">
            <DefaultButton @event="addItem">+ Add Item </DefaultButton>

            <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
          </div>

          <CustomTableRow class="table-row footer">
            <span>Left To Distribute</span>

            <span>${{ leftToDistribute }}</span>
          </CustomTableRow>
        </template>
      </CustomTable>

      <div class="buttons-area">
        <DefaultButton
          button-color-gamma="red"
          :disabled="leftToDistribute < 0 || invalid"
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
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomSelect from './CustomSelect.vue'
import CustomInput from './CustomInput.vue'
import InputWithTitle from './InputWithTitle.vue'
import Me from '~/graphql/queries/me.query.gql'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { closeRegisterMixin } from '~/mixins/closeRegisterMixin'
import { tabsViewMixin } from '~/mixins/tabsViewMixin'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import { meMixin } from '~/mixins/meMixin'
export default {
  name: 'ClosRegisterPettyCash',
  components: {
    ValidationObserver,
    CustomTable,
    CustomTableRow,
    CustomSelect,
    CustomInput,
    InputWithTitle,
  },
  mixins: [
    formMixin,
    tableActionsMixin,
    closeRegisterMixin,
    tabsViewMixin,
    submitMessagesMixin,
    meMixin,
  ],
  apollo: {
    me: {
      query: Me,
    },
  },
  data() {
    return {
      newItem: {
        glAccount: '',
        amount: '',
      },

      totalPettyCash: '',
    }
  },
  computed: {
    leftToDistribute() {
      const totalAmount = this.getItems.reduce((prev, current) => {
        return Number(prev) + Number(current.amount)
      }, 0)

      return parseFloat(this.totalPettyCash - totalAmount).toFixed(2)
    },
    /* totalPettyCash: {
      get() {
        return this.getTotalPettyCash
      },
      set(value) {
        this.$store.dispatch('closeRegister/setTotalPettyCash', {
          ...this.calculationVariables,
          value,
        })
      },
    }, */
  },
  watch: {
    getIsCancel(value) {
      if(!value) return
      this.totalPettyCash = ''
    }
  },
  methods: {
    onChangeFloatValue(stateProp, crud = false) {
      this.$store.commit('closeRegister/SET_IS_CANCEL', false)
      if ( crud ) {
        this.newItem[stateProp] = parseFloat(typeof this[stateProp] !== 'string' ? this.newItem[stateProp] : 0).toFixed(2)
        return ;
      }
      this[stateProp] = parseFloat(typeof this[stateProp] !== 'string' ? this[stateProp] : 0).toFixed(2)
      if ( stateProp === 'totalPettyCash' ) {
        this.$store.dispatch('closeRegister/setTotalPettyCash', {
          ...this.calculationVariables,
          value: this[stateProp],
        })
      }
    },
    async addItem() {
      const formValidated =
        this.$refs.form && (await this.$refs.form.validate())

      if (formValidated) {
        if (this.newItem.amount) {
          this.$store.commit('closeRegister/SET_ITEM', {
            ...this.newItem,
            tempId: new Date(),
          })
        }

        this.isSelectedGlAccount = false

        this.isAdd = false
        this.isHide = false
        this.newItem = {
          amount: '',
          glAccount: '',
        }
      } else {
        this.showSubmitMessage('The Pretty Cash Amount is required', 'error')
      }
    },
    deleteRow(item) {
      if (this.getIsEdit && item.id) {
        this.$store.commit('closeRegister/SET_DELETE_ITEM_IDS', item.id)
      }
      this.$store.commit(
        'closeRegister/SET_ITEMS',
        this.getItems.filter((vuexItem) =>
          item.id
            ? Number(vuexItem.id) !== Number(item.id)
            : Number(vuexItem.tempId) !== Number(item.tempId)
        )
      )
    },
    updateItems(item, event, itemProp) {
      this.$store.commit(
        'closeRegister/SET_ITEMS',
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
    selectGlAccount(item, glAccount) {
      this.updateItems(item, glAccount, 'glAccount')
    },
    selectWewItemGlAccount(glAccount) {
      this.newItem.glAccount = glAccount
    },
  },
}
</script>

<style lang="scss" scoped>
.input-row {
  max-width: 240px;
  margin-bottom: 20px;
}

.table-row {
  display: grid;
  align-items: center;
  grid-template-columns: 453px 206px 20px;
  column-gap: 30px;
}

.add-row {
  height: 60px;
}

.icon {
  cursor: pointer;

  &--add {
    grid-column: 3;
  }
}

.footer {
  color: $night-rider;
  font-weight: 700;
  text-align: right;
  height: 60px;
}

.buttons-area {
  margin-top: 25px;
}

.add-item-buttons {
  padding-left: 20px;
}
</style>
