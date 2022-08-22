<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="780">
        <template #header>
          <div class="table-row">
            <span> Code </span>

            <span> Description </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="calculationCode in queryData.data"
            :key="calculationCode.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === calculationCode.id"
              v-model="calculationCodeEdit.code"
              rules="required|max:255"
              do-not-show-error-message
              name='"Calculation Code"'
            />
            <span v-else>{{ calculationCode.code }}</span>

            <CustomInput
              v-if="isEdit === calculationCode.id"
              v-model="calculationCodeEdit.description"
              rules="required|max:255"
              do-not-show-error-message
              name='"CalculationCode Description"'
            />
            <span v-else>{{ calculationCode.description }}</span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === calculationCode.id"
              :is-delete-active="isDelete === calculationCode.id"
              @edit="isAdd ? null : editCalculationCode(calculationCode)"
              @delete="isAdd ? null : deleteItem(calculationCode.id)"
              @cancel="cancelCalculationCodeEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(calculationCode)"
              @confirm-delete="confirmDelete(calculationCode.id)"
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
              v-model="calculationCodeNew.code"
              rules="required|max:255"
              do-not-show-error-message
              name='"Calculation Code"'
            />

            <CustomInput
              v-model="calculationCodeNew.description"
              rules="required|max:255"
              do-not-show-error-message
              name='"CalculationCode Description"'
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addCalculationCodeRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addCalculationCode">+ Add CalculationCode </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import CalculationCodeList from '../graphql/queries/calculationCodeList.gql'
import CreateCalculationCode from '../graphql/mutations/calculationCode/createCalculationCode.gql'
import UpdateCalculationCode from '../graphql/mutations/calculationCode/updateCalculationCode.gql'
import DeleteCalculationCode from '../graphql/mutations/calculationCode/deleteCalculationCode.gql'
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
  name: 'HQCalculationCodesContent',
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
      query: CalculationCodeList,
      queryName: "calculationCodeList",
      currentPage: 1,
      queryData: {},
      // pagination

      calculationCodeNew: {
        code: '',
        description: '',
      },
      calculationCodeEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    editCalculationCode(calculationCode) {
      this.calculationCodeEdit = Object.assign({}, calculationCode)
      this.edit(calculationCode.id)
    },
    addCalculationCodeRow() {
      this.calculationCodeNew = {
        code: '',
        description: '',
      }
      this.addRow()
    },
    async addCalculationCode() {
      const res = await this.mutationAction(
        CreateCalculationCode,
        {
          calculationCodeInput: {
            code: this.calculationCodeNew.code,
            description: this.calculationCodeNew.description,
          },
        },
        null,
        'Add calculationCode success',
        'Add calculationCode error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    async confirmEdit(calculationCode) {
      const editedCalculationCode = {
        id: calculationCode.id,
        code: this.calculationCodeEdit.code,
        description: this.calculationCodeEdit.description,
      }

      const res = await this.mutationAction(
        UpdateCalculationCode,
        {
          calculationCodeInput: editedCalculationCode,
        },
        null,
        'Edit calculationCode success',
        'Edit calculationCode error',
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
        DeleteCalculationCode,
        { id },
        null,
        'Delete calculationCode success',
        'Delete calculationCode error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelCalculationCodeEdit() {
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
