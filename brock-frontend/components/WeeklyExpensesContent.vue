<template>
  <PageContentWrapper>
    <InputRow>
      <InputWithTitle has-select>
        <template #title>Expense Type</template>

        <template v-if="expenseTypes" #input>
          <CustomSelect
            :options="expenseTypes"
            select-by="type"
            :selected-item="expenseType"
            @input="setExpensesType"
          />
        </template>
      </InputWithTitle>
    </InputRow>
    <LoadingBar v-if="$apollo.loading" />

    <div v-else class="table">
      <CustomTable class="" :w-table="750">
        <template #header>
          <div class="table-row">
            <span> Expense Date </span>

            <span> Expense Type </span>

            <span> Gl Account </span>

            <span> Amount </span>

            <span> Comment </span>
          </div>
        </template>

        <template v-if="expenses" #content>
          <CustomTableRow
            v-for="expense in expensesFilteredByExpenseType"
            :key="expense.id"
            class="table-row table-content-row"
          >
            <span> {{ formatDateFromAPI(expense.expenseDate) }}</span>

            <span> {{ expense.expenseType.description }} </span>

            <span> {{ expense.glAccount.name }} </span>

            <span> {{ Number(expense.amount).toFixed(2) }} </span>

            <span> {{ expense.comments }} </span>

            <CustomTableIconsColumn
              :is-edit-active="canCreate && isEdit === expense.id"
              :is-delete-active="isDelete === expense.id"
              :show-edit="canCreate"
              :show-delete="canManage"
              @edit="editExpense(expense)"
              @delete="deleteItem(expense.id)"
              @cancel-delete="cancelDelete"
              @confirm-delete="confirmDelete(expense.id)"
            />
          </CustomTableRow>
        </template>
      </CustomTable>
    </div>
  </PageContentWrapper>
</template>

<script>
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import Expenses from '~/graphql/queries/expenses.gql'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import { formatDateFromAPI } from '~/helpers/helpers'
import DeleteExpense from '~/graphql/mutations/expense/deleteExpense.gql'
import { meMixin } from '~/mixins/meMixin'
import ExpenseTypes from '~/graphql/queries/expenseTypes.gql'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";
export default {
  name: 'WeeklyExpensesContent',
  components: { CustomTable, CustomTableRow, InputRow, InputWithTitle },
  apollo: {
    expenses: {
      query: Expenses,
      fetchPolicy: 'network-only',
      variables: {
        activePeriod: true,
      },
    },
    expenseTypes: {
      query: ExpenseTypes,
    },
    RolePrivileges: {
      query: RolePrivileges,
    },
  },
  mixins: [tableActionsMixin, mutationMixin, meMixin],
  data() {
    return {
      canCreate: false,
      canManage: false,
      expenseType: '',
    }
  },
  computed: {
    expensesFilteredByExpenseType() {
      return this.expenses.filter(
        (expense) => expense.expenseType.type === this.expenseType.type
      )
    },
  },
  mounted () {
    this.canCreate = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'expenses') && (privilege.permissionType === 'CREATE')
    }).length
    this.canManage = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'expenses') && (privilege.permissionType === 'MODIFY')
    }).length
  },
  methods: {
    formatDateFromAPI,
    setExpensesType(expenseType) {
      this.expenseType = expenseType
    },
    selectPeriodEndDate(item) {
      this.periodEndDate = item
    },
    editExpense(expense) {
      this.$store.commit('expense/SET_EXPENSE', {
        ...expense,
        amount: Number(expense.amount).toFixed(2),
        expenseDate: this.formatDateFromAPI(expense.expenseDate),
      })
      this.$store.commit('expense/SET_IS_EDIT', true)
      this.$router.push('/home/expenses')
    },
    confirmDelete(id) {
      this.mutationAction(
        DeleteExpense,
        { id },
        Expenses,
        'Delete expense success',
        'Delete expense error',
        {
          activePeriod: true,
        }
      )
    },
  },
}
</script>

<style lang="scss" scoped>
.table {
  margin-top: 30px;
}

.table-row {
  display: grid;
  align-items: center;
  padding: 12px 0;
  @media screen and (min-width: $xl) {
    grid-template-columns: 12% 30% 20% 10% 10% 8%;
  }
  @media screen and (min-width: $lg) and (max-width: $xl) {
    grid-template-columns: 12% 30% 15% 10% 10% 10%;
  }
  @media screen and (min-width: $md) and (max-width: $lg) {
    grid-template-columns: 12% 30% 15% 10% 10% 10%;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 80px 120px 120px 120px 90px 68px;
  }
  column-gap: 20px;
}

.table-content-row {
  height: 53px;
  padding: 5px 10px;
}

.icon {
  margin-right: 15px;
  cursor: pointer;

  &:last-child {
    margin-right: 0;
  }
}
</style>
