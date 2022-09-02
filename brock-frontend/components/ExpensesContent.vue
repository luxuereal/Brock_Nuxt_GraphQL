<template>
  <div class="content">
    <PageSubHeaderContent />

    <PageContentWrapper>
      <ValidationObserver ref="form" v-slot="{ invalid, pristine }">
        <InputRow class="input-row-mob">
          <InputWithTitle>
            <template #title>Expense Date</template>

            <template #input>
              <CustomDatePicker
                v-model="expensesDate"
                placeholder="mm/dd/yyyy"
                rules="required|date"
                name="Expense Date"
                type="date"
                :disabled="getIsEdit && expenseType.type === 'ReAccrual'"
                @input="(e) => onChangeDateValue(e)"
              />
            </template>
          </InputWithTitle>

          <InputWithTitle class="radio-buttons-row" has-select>
            <template #title>Expense Type</template>

            <template v-if="ExpenseTypes" #input>
              <CustomSelect
                :options="ExpenseTypes"
                select-by="type"
                :selected-item="expenseType"
                :disabled="getIsEdit && expenseType.type === 'ReAccrual'"
                @input="setExpensesType"
              />
            </template>
          </InputWithTitle>
        </InputRow>

        <InputRow>
          <InputWithTitle has-select>
            <template #title>GL Account</template>

            <template v-if="glAccounts" #input>
              <CustomSelect
                :options="glAccounts"
                select-by="name"
                select-by-second="id"
                select-by-parent="parent"
                :error="selectError"
                :selected-item="glAccount"
                :disabled="getIsEdit && expenseType.type === 'ReAccrual'"
                input-select
                @input="selectGlAccount"
              />
            </template>
          </InputWithTitle>

          <InputWithTitle
            v-if="
              vendors &&
              expenseType &&
              (expenseType.type === 'Accrual' ||
                expenseType.type === 'ReAccrual')
            "
            class="radio-buttons-row"
            has-select
          >
            <template #title>Vendor</template>

            <template #input>
              <CustomSelect
                :options="vendors"
                :selected-item="vendor"
                :disabled="getIsEdit && expenseType.type === 'ReAccrual'"
                @input="setVendor"
              />
            </template>
          </InputWithTitle>
        </InputRow>

        <InputRow>
          <InputWithTitle>
            <template #title>Amount</template>

            <template #input>
              <CustomInput
                v-model.number="amount"
                placeholder="0.00"
                symbol="$"
                rules="required|currency"
                name="Amount"
                type="double"
                :disabled="getIsEdit && expenseType.type === 'ReAccrual'"
                @change="onChangeFloatValue"
              />
            </template>
          </InputWithTitle>
        </InputRow>

        <InputRow>
          <InputWithTitle>
            <template #title>Comments</template>

            <template #input>
              <CustomTextarea
                v-model="comments"
                name="Comments"
                rules="required|max:255"
                :disabled="getIsEdit && expenseType.type === 'ReAccrual'"
              />
            </template>
          </InputWithTitle>
        </InputRow>

        <div class="buttons-area">
          <DefaultButton
            button-color-gamma="red"
            :disabled="invalid"
            @event="expenseAction"
          >
            Accept
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
    </PageContentWrapper>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { mapGetters } from 'vuex'
import { formMixin } from '../mixins/formMixin'
import PageContentWrapper from './PageContentWrapper.vue'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomInput from './CustomInput.vue'
import CustomDatePicker from './CustomDatePicker.vue'
import CustomSelect from './CustomSelect.vue'
import CustomTextarea from './CustomTextarea.vue'
import DefaultButton from './DefaultButton.vue'
import PageSubHeaderContent from './PageSubHeaderContent.vue'
import { EXPENSE } from '~/constants/expense'
import { mutationMixin } from '~/mixins/mutationMixin'
import Expenses from '~/graphql/queries/expenses.gql'
import ExpenseTypesFiltered from '~/graphql/queries/expenseTypesFiltered.gql'
import Vendors from '~/graphql/queries/vendors.gql'
import GlAccounts from '~/graphql/queries/glAccounts.gql'
import { formatDate } from '~/helpers/helpers'
import CreateExpense from '~/graphql/mutations/expense/createExpense.gql'
import UpdateExpense from '~/graphql/mutations/expense/updateExpense.gql'
export default {
  name: 'ExpensesContent',
  components: {
    PageContentWrapper,
    InputRow,
    InputWithTitle,
    CustomInput,
    CustomDatePicker,
    CustomSelect,
    CustomTextarea,
    DefaultButton,
    ValidationObserver,
    PageSubHeaderContent,
  },
  mixins: [formMixin, mutationMixin],
  apollo: {
    ExpenseTypes: {
      query: ExpenseTypesFiltered,
    },
    glAccounts: {
      query: GlAccounts,
    },
    vendors: {
      query: Vendors,
    },
  },
  data() {
    return {
      selectError: false,
    }
  },
  computed: {
    ...mapGetters({
      getIsEdit: 'expense/getIsEdit',
      getId: 'expense/getId',
      getExpenseDate: 'expense/getExpenseDate',
      getExpenseType: 'expense/getExpenseType',
      getGlAccount: 'expense/getGlAccount',
      getAmount: 'expense/getAmount',
      getComments: 'expense/getComments',
      getVendor: 'expense/getVendor',
    }),
    expensesDate: {
      get() {
        return this.getExpenseDate
      },
      set(value) {
        this.$store.commit('expense/SET_EXPENSE_DATE', value)
      },
    },
    expenseType: {
      get() {
        return this.getExpenseType
      },
      set(value) {
        this.$store.commit('expense/SET_EXPENSE_TYPE', value)
      },
    },
    glAccount: {
      get() {
        return this.getGlAccount
      },
      set(value) {
        this.$store.commit('expense/SET_GL_ACCOUNT', value)
      },
    },
    amount: {
      get() {
        return this.getAmount
      },
      set(value) {
        this.$store.commit('expense/SET_AMOUNT', value)
      },
    },
    comments: {
      get() {
        return this.getComments
      },
      set(value) {
        this.$store.commit('expense/SET_COMMENTS', value)
      },
    },
    vendor: {
      get() {
        return this.getVendor
      },
      set(value) {
        this.$store.commit('expense/SET_VENDOR', value)
      },
    },
  },
  destroyed() {
    this.$store.commit('expense/SET_IS_EDIT', false)
    this.cancelCreate()
  },
  methods: {
    onChangeFloatValue() {
      const value = this.amount;
      this.amount = Number(value === '' ? 0 : value).toFixed(2);
    },
    onChangeDateValue(value) {
      this.$store.commit('expense/SET_EXPENSE_DATE', value)
    },
    formatDate,
    setExpensesType(expenseType) {
      this.expenseType = expenseType
    },
    setVendor(vendor) {
      this.vendor = vendor
    },
    async CreateExpense() {
      if (!this.glAccount) {
        this.selectError = true
      }
      const res = await this.mutationAction(
        CreateExpense,
        {
          expenseInput: {
            comments: this.comments,
            ...((this.expenseType.type === 'Accrual' ||
              this.expenseType.type === 'ReAccrual') && {
              vendor: {
                connect: this.vendor.id,
              },
            }),
            expenseDate: this.formatDate(this.expensesDate),
            glAccount: {
              connect: this.glAccount.id,
            },
            expenseType: {
              connect: this.expenseType.id,
            },
            amount: String(this.amount),
          },
        },
        Expenses,
        'Add Expense Success',
        'Add Expense Error',
        {
          activePeriod: true,
        }
      )
      if (res) {
        this.cancelCreate()
      }
    },
    async UpdateExpense() {
      await this.mutationAction(
        UpdateExpense,
        {
          expenseInput: {
            id: this.getId,
            comments: this.comments,
            ...((this.expenseType.type === 'Accrual' ||
              this.expenseType.type === 'ReAccrual') && {
              vendor: {
                connect: this.vendor.id,
              },
            }),
            expenseDate: this.formatDate(this.expensesDate),
            glAccount: {
              connect: this.glAccount.id,
            },
            expenseType: {
              connect: this.expenseType.id,
            },
            amount: this.amount,
          },
        },
        Expenses,
        'Update Expense Success',
        'Update Expense Error',
        {
          activePeriod: true,
        }
      )
      this.$router.push('/review/weekly-expenses')
    },
    expenseAction() {
      this.getIsEdit ? this.UpdateExpense() : this.CreateExpense()
    },
    selectGlAccount(account) {
      this.glAccount = account
    },
    cancelEdit() {
      this.cancelEvent()
      this.$router.push('/review/weekly-expenses')
    },
    cancelCreate() {
      this.cancelEvent()
      this.$store.commit('expense/SET_EXPENSE', { ...EXPENSE })
    },
    cancelReAccrual() {
      this.$store.commit('expense/SET_EXPENSE', { ...EXPENSE })
      this.$router.push('/home/reaccruals')
    },
  },
}
</script>

<style lang="scss" scoped>
.content {
  div.subheader {
    justify-content: flex-start;
    overflow: auto;
    div {
      @media screen and (min-width: $lg) {
        margin-right: 120px;
      }
      @media screen and (max-width: $lg) {
        margin-right: 30px;
      }
    }
  }
}

.radio-buttons {
  &-row {
    position: relative;
  }

  &-area {
    @media screen and (min-width: $xs) {
      position: absolute;
      top: 30px;
    }
    div.container {
      margin-bottom: 18px;

      &:last-child {
        margin-bottom: 0;
      }
    }
  }
}

.input-row-mob {
  @media screen and (max-width: $xs) {
    display: block;
  }
  .container {
    &:first-child {
      @media screen and (max-width: $xs) {
        margin-bottom: 16px;
      }
    }
  }
}

.buttons-area {
  display: flex;
  margin-top: 30px;

  button:first-child {
    margin-right: 11px;
  }

  button:nth-child(2) {
    margin-right: 11px;
  }
}
</style>
