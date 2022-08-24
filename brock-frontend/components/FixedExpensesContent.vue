<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <CustomTable class="table-full" :w-table="700">
        <template #header>
          <div class="table-row">
            <span>Monthly</span>

            <span>GL Account</span>

            <span>Amount</span>

            <span>Comments</span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="item in queryData.data"
            :key="item.id"
            class="table-row"
          >
            <CustomRadioButton
              v-if="isEdit === item.id"
              :is-active="itemEdit.monthly"
              :disabled="isEdit !== item.id"
              @set-is-active="setIsMonthlyEdit(item)"
            />
            <CustomRadioButton
              v-else
              :is-active="item.monthly"
              :disabled="isEdit !== item.id"
              @set-is-active="setIsMonthly(item)"
            />

            <CustomSelect
              v-if="glAccounts && isEdit === item.id"
              :options="glAccounts"
              select-by="name"
              :selected-item="item.glAccount"
              @input="selectGlAccountEdit"
            />
            <span v-else>{{ item.glAccount.name }}</span>

            <CustomInput
              v-if="isEdit === item.id"
              v-model.number="itemEdit.amount"
              rules="required|double|currency"
              do-not-show-error-message
              type="double"
              placeholder="0.00"
              symbol="$"
              name="fixedExpense-amount"
              @change="onChangeFloatValue(true)"
            />

            <span v-else>{{ parseFloat(item.amount).toFixed(2) }}</span>

            <CustomInput
              v-if="isEdit === item.id"
              v-model="itemEdit.comments"
              rules="required|max255"
              do-not-show-error-message
              name="fixedExpense-comments"
            />
            <span v-else>{{ item.comments }}</span>

            <CustomTableIconsColumn
              v-if="canManage"
              :is-edit-active="isEdit === item.id"
              :is-delete-active="isDelete === item.id"
              @edit="isAdd ? null : editItem(item)"
              @delete="isAdd ? null : deleteItem(item.id)"
              @cancel="cancelExpensesEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(item)"
              @confirm-delete="confirmDelete(item.id)"
            />
          </CustomTableRow>

          <!-- pagination -->
          <PaginationRow v-if="queryData.data.length">
            <div :class="(!isHide || isAdd ? 'show' : 'hide') + ' button-bar'">
              <PaginationButton
                :disabled="currentPage == 1"
                :loading="fetchingData"
                @event="firstPage"
              > << </PaginationButton>
              <PaginationButton
                :disabled="currentPage == 1"
                :loading="fetchingData"
                @event="prevPage"
              > < </PaginationButton>
              <PaginationInput
                v-model="page"
                :disabled="fetchingData"
                @change="goToPage"
                @event="goToPage"
                >
              </PaginationInput>
              <PaginationButton
                :disabled="currentPage >= queryData.paginatorInfo.lastPage"
                :loading="fetchingData"
                @event="nextPage"
              > > </PaginationButton>
              <PaginationButton
                :disabled="currentPage >= queryData.paginatorInfo.lastPage"
                :loading="fetchingData"
                @event="lastPage"
              > >> </PaginationButton>
            </div>
            <div class='description-bar'>
              Showing {{queryData.paginatorInfo.firstItem}}-{{queryData.paginatorInfo.lastItem}} of {{queryData.paginatorInfo.total}}
            </div>
          </PaginationRow>
          <!-- pagination -->

          <CustomTableRow v-if="isAdd && canCreate" class="table-row">
            <CustomRadioButton
              :is-active="newItem.monthly"
              @set-is-active="setIsMonthly"
            />

            <CustomSelect
              v-if="glAccounts"
              :options="glAccounts"
              select-by="name"
              @input="selectGlAccount"
            />

            <CustomInput
              v-model.number="newItem.amount"
              rules="required|double|currency"
              do-not-show-error-message
              type="double"
              placeholder="0.00"
              symbol="$"
              name="fixedExpense-amount"
              @change="onChangeFloatValue()"
            />

            <CustomInput
              v-model="newItem.comments"
              rules="required|max255"
              do-not-show-error-message
              name="fixedExpense-comments"
            />
          </CustomTableRow>

          <CustomTableRow v-if="canCreate" class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addFixedExpenseRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd && canCreate" class="buttons-area">
      <DefaultButton button-color-gamma="red" @event="createFixedExpense">
       + Add Expenses
      </DefaultButton>

      <DefaultButton button-color-gamma="white" @event="cancelEvent">
        Cancel
      </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { formMixin } from '../mixins/formMixin'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomRadioButton from './CustomRadioButton.vue'
import CustomSelect from './CustomSelect.vue'
import CustomInput from './CustomInput.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'

// pagination
import PaginationRow from './PaginationRow.vue'
import PaginationButton from './PaginationButton.vue'
import PaginationInput from './PaginationInput.vue'
// pagination

import GlAccounts from '~/graphql/queries/glAccounts.gql'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import FixedExpensesFiltered from '~/graphql/queries/fixedExpensesFiltered.gql'
import Me from '~/graphql/queries/me.query.gql'
import { mutationMixin } from '~/mixins/mutationMixin'
import CreateFixedExpense from '~/graphql/mutations/fixedExpense/createFixedExpenses.gql'
import DeleteFixedExpense from '~/graphql/mutations/fixedExpense/deleteFixedExpenses.gql'
import UpdateFixedExpense from '~/graphql/mutations/fixedExpense/updateFixedExpense.gql'

// pagination
import { paginatorMixin } from '~/mixins/paginatorMixin'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";
// pagination

export default {
  name: 'FixedExpensesContent',
  components: {
    PageContentWrapper,
    CustomTableRow,
    CustomRadioButton,
    CustomSelect,
    CustomInput,
    ValidationObserver,
    CustomTableAddIcon,

    // pagination
    PaginationRow,
    PaginationButton,
    PaginationInput,
    // pagination
  },
  mixins: [formMixin, tableActionsMixin, mutationMixin, paginatorMixin],
  apollo: {
    glAccounts: {
      query: GlAccounts,
    },
    RolePrivileges: {
      query: RolePrivileges,
    },
  },
  data() {
    return {
      // pagination
      query: FixedExpensesFiltered,
      queryName: "FixedExpenses",
      currentPage: 1,
      queryData: {},
      hasQueryVariable: true,
      queryVariable: {
        unit_id: null
      },
      // pagination

      newItem: {
        id: '',
        comments: '',
        monthly: false,
        glAccount: '',
        amount: '',
      },
      itemEdit: {},
      canCreate: false,
      canManage: false
    }
  },
  beforeMount(){
    this.getMyData().then((me) => {
      this.queryVariable.unit_id = me.selectedUnit.id;
      this.fetchData();
    });
  },
  mounted () {
    this.canCreate = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'fixed-expense') && (privilege.permissionType === 'CREATE')
    }).length
    this.canManage = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'fixed-expense') && (privilege.permissionType === 'MODIFY')
    }).length
  },
  methods: {
    onChangeFloatValue(isEdit = false) {
      if ( isEdit ) {
        this.itemEdit.amount = parseFloat(this.itemEdit.amount !== '' ? this.itemEdit.amount : 0).toFixed(2);
      } else {
        this.newItem.amount = parseFloat(this.newItem.amount !== '' ? this.newItem.amount : 0).toFixed(2);
      }
    },
    async getMyData() {
      const me = await this.$apollo.query({
        query: Me,
        fetchPolicy: 'network-only'
      });
      return me.data.me;
    },
    editItem(item) {
      this.itemEdit = Object.assign({}, item)
      this.onChangeFloatValue(true);
      this.edit(item.id)
    },
    selectGlAccountEdit(glAccount) {
      this.itemEdit.glAccount = glAccount
    },
    selectGlAccount(glAccount) {
      this.newItem.glAccount = glAccount
    },
    addFixedExpenseRow() {
      this.newItem = {
        id: '',
        comments: '',
        monthly: false,
        glAccount: '',
        amount: '',
      }
      this.addRow()
    },
    async createFixedExpense() {
      const res = await this.mutationAction(
        CreateFixedExpense,
        {
          fixedExpenseInput: {
            comments: this.newItem.comments,
            glAccount: {
              connect: this.newItem.glAccount.id,
            },
            amount: this.newItem.amount,
            monthly: this.newItem.monthly,
          },
        },
        null,
        'Add Fixed Expense success',
        'Add Fixed Expense error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    setIsMonthlyEdit() {
      this.itemEdit.monthly = !this.itemEdit.monthly
    },
    setIsMonthly(fixedExpenses) {
      if (fixedExpenses) {
        fixedExpenses.monthly = !fixedExpenses.monthly
      } else {
        this.newItem.monthly = !this.newItem.monthly
      }
    },
    async confirmDelete(id) {
      const res = await this.mutationAction(
        DeleteFixedExpense,
        { id },
        null,
        'Delete Fixed Expense success',
        'Delete Fixed Expense error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    async confirmEdit(expense) {
      const editedFixedExpense = {
        id: expense.id,
        comments: this.itemEdit.comments,
        glAccount: {
          connect: this.itemEdit.glAccount.id,
        },
        amount: this.itemEdit.amount,
        monthly: this.itemEdit.monthly,
      }

      const res = await this.mutationAction(
        UpdateFixedExpense,
        { fixedExpenseInput: editedFixedExpense },
        null,
        'Add Fixed Expense success',
        'Add Fixed Expense error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage();
      // pagination
    },
    cancelEvent() {
      this.isAdd = false
      this.isHide = false
    },
    cancelExpensesEdit() {
      this.cancelEdit()
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  column-gap: 20px;
  @media screen and (min-width: $lg) {
    grid-template-columns: 8% 32% 18% 30% 5%;
  }
  @media screen and (min-width: $md) and (max-width: $lg) {
    grid-template-columns: 8% 32% 18% 30% 5%;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 60px 180px 120px 200px 20px;
  }
}

.table-full {
  @media screen and (min-width: $lg) and (max-width: $xxl) {
    width: calc(100vw - 280px);
  }
}

.buttons-area {
  display: flex;
  margin-top: 36px;

  button:first-child {
    margin-right: 11px;
  }
}

.add-row {
  height: 86px;
}

.icon {
  cursor: pointer;

  &--add {
    grid-column: 5;
  }
}
</style>
