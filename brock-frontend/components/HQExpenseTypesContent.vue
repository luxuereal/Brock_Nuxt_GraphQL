<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="780">
        <template #header>
          <div class="table-row">
            <span> Name </span>

            <span> Description </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="expenseType in queryData.data"
            :key="expenseType.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === expenseType.id"
              v-model="expenseTypeEdit.type"
              rules="required"
              do-not-show-error-message
              name='"ExpenseType Name"'
            />
            <span v-else>{{ expenseType.type }}</span>

            <CustomInput
              v-if="isEdit === expenseType.id"
              v-model="expenseTypeEdit.description"
              rules="required"
              do-not-show-error-message
              name='"ExpenseType Description"'
            />
            <span v-else>{{ expenseType.description }}</span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === expenseType.id"
              :is-delete-active="isDelete === expenseType.id"
              @edit="isAdd ? null : editExpenseType(expenseType)"
              @delete="isAdd ? null : deleteItem(expenseType.id)"
              @cancel="cancelExpenseTypeEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(expenseType)"
              @confirm-delete="confirmDelete(expenseType.id)"
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

          <CustomTableRow v-if="isAdd" class="table-row">
            <CustomInput
              v-model="expenseTypeNew.type"
              rules="required"
              do-not-show-error-message
              name='"ExpenseType Name"'
            />

            <CustomInput
              v-model="expenseTypeNew.description"
              rules="required"
              do-not-show-error-message
              name='"ExpenseType Description"'
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addExpenseTypeRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addExpenseType">+ Add Expense Type </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import ExpenseTypeList from '../graphql/queries/expenseTypeList.gql'
import CreateExpenseType from '../graphql/mutations/expenseType/createExpenseType.gql'
import UpdateExpenseType from '../graphql/mutations/expenseType/updateExpenseType.gql'
import DeleteExpenseType from '../graphql/mutations/expenseType/deleteExpenseType.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomInput from './CustomInput.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'

// pagination
import PaginationRow from './PaginationRow.vue'
import PaginationButton from './PaginationButton.vue'
import PaginationInput from './PaginationInput.vue'
// pagination

import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import { formMixin } from '~/mixins/formMixin'
import { mutationMixin } from '~/mixins/mutationMixin'

// pagination
import { paginatorMixin } from '~/mixins/paginatorMixin'
// pagination

export default {
  name: 'HQExpenseTypesContent',
  components: {
    ValidationObserver,
    PageContentWrapper,
    CustomTable,
    CustomTableRow,
    CustomInput,
    CustomTableAddIcon,

    // pagination
    PaginationRow,
    PaginationButton,
    PaginationInput,
    // pagination
  },
  mixins: [submitMessagesMixin, formMixin, mutationMixin, tableActionsMixin, paginatorMixin],
  apollo: {
  },
  data() {
    return {
      // pagination
      query: ExpenseTypeList,
      queryName: "expenseTypeList",
      currentPage: 1,
      queryData: {},
      // pagination

      expenseTypeNew: {
        type: '',
        description: '',
      },
      expenseTypeEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    editExpenseType(expenseType) {
      this.expenseTypeEdit = Object.assign({}, expenseType)
      this.edit(expenseType.id)
    },
    addExpenseTypeRow() {
      this.expenseTypeNew = {
        type: '',
        description: '',
      }
      this.addRow()
    },
    async addExpenseType() {
      const res = await this.mutationAction(
        CreateExpenseType,
        {
          expenseTypeInput: {
            type: this.expenseTypeNew.type,
            description: this.expenseTypeNew.description,
          },
        },
        null,
        'Add expense type success',
        'Add expense type error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    async confirmEdit(expenseType) {
      const editedExpenseType = {
        id: expenseType.id,
        type: this.expenseTypeEdit.type,
        description: this.expenseTypeEdit.description,
      }

      const res = await this.mutationAction(
        UpdateExpenseType,
        { expenseTypeInput: editedExpenseType },
        null,
        'Edit expense type success',
        'Edit expense type error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage();
      // pagination
    },
    async confirmDelete(id) {
      const res = await this.mutationAction(
        DeleteExpenseType,
        { id },
        null,
        'Delete expense type success',
        'Delete expense type error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelExpenseTypeEdit() {
      this.cancelEdit()
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  column-gap: 30px;
  padding: 12px 0;
  @media screen and (min-width: $lg) {
    grid-template-columns: 40% 40% auto;
  }
  @media screen and (max-width: $lg) {
    grid-template-columns: 200px 200px auto;
  }
}

.row {
  padding: 16.5px 10px;
}

.icon {
  cursor: pointer;

  &--add {
    grid-column: 4;
    justify-self: end;
  }
}

.icon--add {
  grid-column: 5;
}
</style>
