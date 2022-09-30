<template>
  <div class="content">
    <PageSubHeaderContent />

    <PageContentWrapper>
      <ValidationObserver ref="form" v-slot="{ invalid, pristine }">
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
              />
            </template>
          </InputWithTitle>
        </InputRow>

        <div class="buttons-area">
          <DefaultButton
            button-color-gamma="red"
            :disabled="invalid"
            @event="createPayroll"
          >
            Save
          </DefaultButton>

          <DefaultButton
            button-color-gamma="white"
            :disabled="pristine"
            @event="cancelCreate()"
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
import CustomTextarea from './CustomTextarea.vue'
import DefaultButton from './DefaultButton.vue'
import PageSubHeaderContent from './PageSubHeaderContent.vue'
import { mutationMixin } from '~/mixins/mutationMixin'
import ExpenseTypes from '~/graphql/queries/expenseTypes.gql'
import GlAccounts from '~/graphql/queries/glAccounts.gql'
import CreateExpense from '~/graphql/mutations/expense/createExpense.gql'

export default {
  name: 'PayrollContent',
  components: {
    PageContentWrapper,
    InputRow,
    InputWithTitle,
    CustomInput,
    CustomTextarea,
    DefaultButton,
    ValidationObserver,
    PageSubHeaderContent,
  },
  mixins: [formMixin, mutationMixin],
  apollo: {
    expenseTypes: {
      query: ExpenseTypes
    },
    glAccounts: {
      query: GlAccounts,
    },
  },
  computed: {
    ...mapGetters({
      getAmount: 'payroll/getAmount',
      getComments: 'payroll/getComments',
    }),
    getPayroll() {
      return this.expenseTypes.find((item) => item.type === 'PayrollAdj')
    },
    getGLAccount() {
      return this.glAccounts.find((item) => item.name === 'Payroll Payable')
    },
    amount: {
      get() {
        return this.getAmount
      },
      set(value) {
        this.$store.commit('payroll/SET_AMOUNT', value)
      },
    },
    comments: {
      get() {
        return this.getComments
      },
      set(value) {
        this.$store.commit('payroll/SET_COMMENTS', value)
      },
    },
  },
  destroyed() {
    this.cancelCreate()
  },
  methods: {
    async createPayroll() {
        const currentDate = new Date().toJSON().slice(0,10).replace(/-/g,'-')

        const res = await this.mutationAction(
          CreateExpense,
          {
              expenseInput: {
                  comments: this.comments,
                  expenseDate: currentDate,
                  glAccount: {
                      connect: this.getGLAccount.id,
                  },
                  expenseType: {
                      connect: this.getPayroll.id,
                  },
                  amount: String(this.amount),
              },
          },
          null,
          'Add Payroll Success',
          'Add Payroll Error',
          {
              activePeriod: true,
          }
        )
        if (res) {
          this.cancelCreate()
        }
    },
    cancelCreate() {
      this.cancelEvent()
      this.$store.commit('payroll/SET_PAYROLL', {amount: '', comments: ''})
    },
  }
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
