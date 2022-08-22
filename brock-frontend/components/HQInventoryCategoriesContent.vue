<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="780">
        <template #header>
          <div class="table-row">
            <span> Name </span>

            <span> GL account </span>

            <span> Vending </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="inventoryCategory in queryData.data"
            :key="inventoryCategory.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === inventoryCategory.id"
              v-model="inventoryCategoryEdit.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"InventoryCategory Name"'
            />
            <span v-else>{{ inventoryCategory.name }}</span>

            <CustomSelect
              v-if="glAccounts && isEdit === inventoryCategory.id"
              v-model="inventoryCategoryEdit.glAccount"
              :options="glAccounts"
              select-by="name"
              :selected-item="
                glAccounts.find((glAccount) =>
                  inventoryCategory.glAccountId
                    ? glAccount.id == inventoryCategory.glAccountId
                    : glAccount.id == inventoryCategory.glAccount.id
                )
              "
            />
            <span v-else>{{ inventoryCategory.glAccount.name }}</span>

            <CustomInput
              v-if="isEdit === inventoryCategory.id"
              v-model="inventoryCategoryEdit.vending"
              rules="required|max:255"
              do-not-show-error-message
              name='"InventoryCategory Vending"'
            />
            <span v-else>{{ inventoryCategory.vending }}</span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === inventoryCategory.id"
              :is-delete-active="isDelete === inventoryCategory.id"
              @edit="isAdd ? null : editInventoryCategory(inventoryCategory)"
              @delete="isAdd ? null : deleteItem(inventoryCategory.id)"
              @cancel="cancelInventoryCategoryEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(inventoryCategory)"
              @confirm-delete="confirmDelete(inventoryCategory.id)"
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
              v-model="inventoryCategoryNew.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"InventoryCategory Name"'
            />

            <CustomSelect
              v-if="glAccounts"
              v-model="inventoryCategoryNew.glAccount"
              :options="glAccounts"
              select-by="name"
            />

            <CustomInput
              v-model="inventoryCategoryNew.vending"
              rules="required|max:255"
              do-not-show-error-message
              name='"InventoryCategory Vending"'
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addInventoryCategoryRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addInventoryCategory">+ Add Inventory Category </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import InventoryCategoryList from '../graphql/queries/inventoryCategoryList.gql'
import CreateInventoryCategory from '../graphql/mutations/inventoryCategory/createInventoryCategory.gql'
import UpdateInventoryCategory from '../graphql/mutations/inventoryCategory/updateInventoryCategory.gql'
import DeleteInventoryCategory from '../graphql/mutations/inventoryCategory/deleteInventoryCategory.gql'
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

import GlAccounts from '~/graphql/queries/glAccounts.gql'

import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import { formMixin } from '~/mixins/formMixin'
import { mutationMixin } from '~/mixins/mutationMixin'

// pagination
import { paginatorMixin } from '~/mixins/paginatorMixin'
// pagination

export default {
  name: 'HQInventoryCategoriesContent',
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
    glAccounts: {
      query: GlAccounts,
    },
  },
  data() {
    return {
      // pagination
      query: InventoryCategoryList,
      queryName: "inventoryCategoryList",
      currentPage: 1,
      queryData: {},
      // pagination

      inventoryCategoryNew: {
        name: '',
        glAccount: '',
        vending: '',
      },
      inventoryCategoryEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    editInventoryCategory(inventoryCategory) {
      this.inventoryCategoryEdit = Object.assign({}, inventoryCategory)
      this.edit(inventoryCategory.id)
    },
    addInventoryCategoryRow() {
      this.inventoryCategoryNew = {
        name: '',
        glAccount: '',
        vending: '',
      }
      this.addRow()
    },
    async addInventoryCategory() {
      const res = await this.mutationAction(
        CreateInventoryCategory,
        {
          inventoryCategoryInput: {
            name: this.inventoryCategoryNew.name,
            glAccount: {
              connect: this.inventoryCategoryNew.glAccount.id,
            },
            vending: this.inventoryCategoryNew.vending,
          },
        },
        null,
        'Add inventory category success',
        'Add inventory category error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    async confirmEdit(inventoryCategory) {
      const editedInventoryCategory = {
        id: inventoryCategory.id,
        name: this.inventoryCategoryEdit.name,
        glAccount: {
          connect: this.inventoryCategoryEdit.glAccount.id,
        },
        vending: this.inventoryCategoryEdit.vending,
      }

      const res = await this.mutationAction(
        UpdateInventoryCategory,
        {
          inventoryCategoryInput: editedInventoryCategory,
        },
        null,
        'Edit inventory category success',
        'Edit inventory category error',
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
        DeleteInventoryCategory,
        { id },
        null,
        'Delete inventory category success',
        'Delete inventory category error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelInventoryCategoryEdit() {
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
    grid-template-columns: 30% 30% 10% auto;
  }
  @media screen and (max-width: $lg) {
    grid-template-columns: 200px 200px 100px auto;
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
