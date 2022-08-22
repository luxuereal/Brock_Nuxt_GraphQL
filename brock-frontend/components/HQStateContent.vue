<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else class="table-full" :w-table="1100">
        <template #header>
          <div class="table-row">
            <span>State</span>

            <span>Sales Tax - Cafeteria</span>

            <span>Sales Tax - Vending</span>

            <span>Sales Tax - Restaurant</span>

            <span>Sales Tax - C Store</span>

            <span>Gross Receipts Tax</span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="state in queryData.data"
            :key="state.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === state.id"
              v-model="stateEdit.code"
              rules="required|alpha"
              do-not-show-error-message
              name='"State Code"'
            />
            <span v-else>{{ state.code }}</span>

            <CustomInput
              v-if="isEdit === state.id"
              v-model="stateEdit.salesTaxCafeteria"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Cafeteria"'
              @change="onChangeFloatValue('salesTaxCafeteria', true)"
            />
            <span v-else>{{ parseFloat(state.salesTaxCafeteria).toFixed(2) }}%</span>

            <CustomInput
              v-if="isEdit === state.id"
              v-model="stateEdit.salesTaxVending"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Vending"'
              @change="onChangeFloatValue('salesTaxVending', true)"
            />
            <span v-else> {{ parseFloat(state.salesTaxVending).toFixed(2) }}%</span>

            <CustomInput
              v-if="isEdit === state.id"
              v-model="stateEdit.salesTaxRestaurant"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Restaurant"'
              @change="onChangeFloatValue('salesTaxRestaurant', true)"
            />
            <span v-else>
              {{ parseFloat(state.salesTaxRestaurant).toFixed(2) }}%
            </span>

            <CustomInput
              v-if="isEdit === state.id"
              v-model="stateEdit.salesTaxStore"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Store"'
              @change="onChangeFloatValue('salesTaxStore', true)"
            />
            <span v-else>
              {{ parseFloat(state.salesTaxStore).toFixed(2) }}%
            </span>

            <CustomInput
              v-if="isEdit === state.id"
              v-model="stateEdit.grossReceiptsTax"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Gross Receipts Tax"'
              @change="onChangeFloatValue('grossReceiptsTax', true)"
            />
            <span v-else>
              {{ parseFloat(state.grossReceiptsTax).toFixed(2) }}%
            </span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === state.id"
              :is-delete-active="isDelete === state.id"
              @edit="isAdd ? null : editState(state)"
              @delete="isAdd ? null : deleteItem(state.id)"
              @cancel="cancelStateEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(state)"
              @confirm-delete="confirmDelete(state.id)"
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
              v-model="stateNew.code"
              rules="required|alpha"
              do-not-show-error-message
              name='"State Code"'
            />

            <CustomInput
              v-model="stateNew.salesTaxCafeteria"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Cafeteria"'
              @change="onChangeFloatValue('salesTaxCafeteria')"
            />

            <CustomInput
              v-model="stateNew.salesTaxVending"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sa       les Tax - Vending"'
              @change="onChangeFloatValue('salesTaxVending')"
            />

            <CustomInput
              v-model="stateNew.salesTaxRestaurant"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Restaurant"'
              @change="onChangeFloatValue('salesTaxRestaurant')"
            />

            <CustomInput
              v-model="stateNew.salesTaxStore"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Sales Tax - Store"'
              @change="onChangeFloatValue('salesTaxStore')"
            />

            <CustomInput
              v-model="stateNew.grossReceiptsTax"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Gross Receipts Tax"'
              @change="onChangeFloatValue('grossReceiptsTax')"
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addStateRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addState">+ Add State </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import StateList from '../graphql/queries/stateList.gql'
import CreateState from '../graphql/mutations/state/createState.gql'
import UpdateState from '../graphql/mutations/state/updateState.gql'
import DeleteState from '../graphql/mutations/state/deleteState.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomInput from './CustomInput.vue'
import DefaultButton from './DefaultButton.vue'
import CustomTableIconsColumn from './CustomTableIconsColumn.vue'
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
  name: 'HQStateContent',
  components: {
    ValidationObserver,
    PageContentWrapper,
    CustomTable,
    CustomInput,
    DefaultButton,
    CustomTableIconsColumn,
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
      query: StateList,
      queryName: "stateList",
      currentPage: 1,
      queryData: {},
      // pagination

      stateNew: {
        code: '',
        salesTaxCafeteria: '',
        salesTaxVending: '',
        salesTaxRestaurant: '',
        salesTaxStore: '',
        grossReceiptsTax: '',
      },
      stateEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    onChangeFloatValue(stateProp, isEdit = false) {
      if ( isEdit ) {
        this.stateEdit[stateProp] = parseFloat(this.stateEdit[stateProp] !== '' ? this.stateEdit[stateProp] : 0).toFixed(2)
      } else {
        this.stateNew[stateProp] = parseFloat(this.stateNew[stateProp] !== '' ? this.stateNew[stateProp] : 0).toFixed(2)
      }
    },
    addStateRow() {
      this.stateNew = {
        code: '',
        salesTaxCafeteria: '',
        salesTaxVending: '',
        salesTaxRestaurant: '',
        salesTaxStore: '',
        grossReceiptsTax: '',
      }
      this.addRow()
    },
    async addState() {
      const res = await this.mutationAction(
        CreateState,
        {
          stateInput: {
            code: this.stateNew.code,
            salesTaxCafeteria: +this.stateNew.salesTaxCafeteria,
            salesTaxVending: +this.stateNew.salesTaxVending,
            salesTaxRestaurant: +this.stateNew.salesTaxRestaurant,
            salesTaxStore: +this.stateNew.salesTaxStore,
            grossReceiptsTax: +this.stateNew.grossReceiptsTax,
          },
        },
        null,
        'Add state success',
        'Add state error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    editState(state) {
      this.stateEdit = Object.assign({}, state)
      this.edit(state.id)
    },
    async confirmEdit(state) {
      const editedState = {
        id: state.id,
        code: this.stateEdit.code,
        salesTaxCafeteria: +this.stateEdit.salesTaxCafeteria,
        salesTaxVending: +this.stateEdit.salesTaxVending,
        salesTaxRestaurant: +this.stateEdit.salesTaxRestaurant,
        salesTaxStore: +this.stateEdit.salesTaxStore,
        grossReceiptsTax: +this.stateEdit.grossReceiptsTax,
      }

      const res = await this.mutationAction(
        UpdateState,
        { stateInput: editedState },
        null,
        'Edit state success',
        'Edit state error',
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
        DeleteState,
        { id },
        null,
        'Delete state success',
        'Delete state error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelStateEdit() {
      this.cancelEdit()
    },
  },
}
</script>

<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  grid-template-columns: 40px repeat(5, 150px) auto;
  column-gap: 30px;
  padding: 12px 0;
}

.row {
  padding: 16.5px 10px;
}
.icon {
  cursor: pointer;

  &--add {
    grid-column: 7;
    justify-self: end;
  }
}

.table-full {
  @media screen and (min-width: $lg) and (max-width: $xxl) {
    width: calc(100vw - 280px);
  }
}

.buttons-area {
  margin-top: 25px;
}
</style>
