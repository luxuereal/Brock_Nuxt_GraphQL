<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="520">
        <template #header>
          <div class="table-row">
            <span> Code </span>

            <span> Name </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="district in queryData.data"
            :key="district.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === district.id"
              v-model="districtEdit.code"
              rules="required|max:255"
              do-not-show-error-message
              name='"District Code"'
            />
            <span v-else>{{ district.code }}</span>

            <CustomInput
              v-if="isEdit === district.id"
              v-model="districtEdit.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"District Name"'
            />
            <span v-else>{{ district.name }}</span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === district.id"
              :is-delete-active="isDelete === district.id"
              @edit="isAdd ? null : editDistrict(district)"
              @delete="isAdd ? null : deleteItem(district.id)"
              @cancel="cancelDistrictEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(district)"
              @confirm-delete="confirmDelete(district.id)"
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
              v-model="districtNew.code"
              rules="required|max:255"
              do-not-show-error-message
              name='"District Code"'
            />

            <CustomInput
              v-model="districtNew.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"District Name"'
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addDistrictRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addDistrict">+ Add District </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import DistrictList from '../graphql/queries/districtList.gql'
import CreateDistrict from '../graphql/mutations/district/createDistrict.gql'
import UpdateDistrict from '../graphql/mutations/district/updateDistrict.gql'
import DeleteDistrict from '../graphql/mutations/district/deleteDistrict.gql'
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
  name: 'HQDistrictContent',
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
      query: DistrictList,
      queryName: "districtList",
      currentPage: 1,
      queryData: {},
      // pagination

      districtNew: {
        code: '',
        name: '',
      },
      districtEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    editDistrict(district) {
      this.districtEdit = Object.assign({}, district)
      this.edit(district.id)
    },
    addDistrictRow() {
      this.districtNew = {
        code: '',
        name: '',
      }
      this.addRow()
    },
    async addDistrict() {
      const res = await this.mutationAction(
        CreateDistrict,
        {
          districtInput: {
            name: this.districtNew.name,
            code: this.districtNew.code,
          },
        },
        null,
        'Add district success',
        'Add district error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    async confirmEdit(district) {
      const editedDistrict = {
        id: district.id,
        code: this.districtEdit.code,
        name: this.districtEdit.name,
      }

      const res = await this.mutationAction(
        UpdateDistrict,
        { districtInput: editedDistrict },
        null,
        'Edit district success',
        'Edit district error',
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
        DeleteDistrict,
        { id },
        null,
        'Delete district success',
        'Delete district error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelDistrictEdit() {
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
  @media screen and (min-width: $md) {
    grid-template-columns: 100px 200px auto;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 100px 120px auto;
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
</style>
