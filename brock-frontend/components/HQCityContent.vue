<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="520">
        <template #header>
          <div class="table-row">
            <span> State </span>

            <span> City </span>

            <span> City Sales Tax </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="city in queryData.data"
            :key="city.id"
            class="table-row"
          >
            <CustomSelect
              v-if="isEdit === city.id"
              :options="states"
              :selected-item="city.state"
              select-by="code"
              @input="selectStateEdit"
            />
            <span v-else>
              {{ city.state && city.state.code }}
            </span>

            <CustomInput
              v-if="isEdit === city.id"
              v-model="cityEdit.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"City Name"'
            />
            <span v-else>
              {{ city.name }}
            </span>

            <CustomInput
              v-if="isEdit === city.id"
              v-model="cityEdit.tax"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"City Sales Tax"'
              @change="onChangeFloatValue('tax', true)"
            />
            <span v-else>
              {{ parseFloat(city.tax).toFixed(2) }}%
            </span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === city.id"
              :is-delete-active="isDelete === city.id"
              @edit="isAdd ? null : editCity(city)"
              @delete="isAdd ? null : deleteItem(city.id)"
              @cancel="cancelCityEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(city)"
              @confirm-delete="confirmDelete(city.id)"
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
            <CustomSelect
              :options="states"
              select-by="code"
              @input="selectState"
            />

            <CustomInput
              v-model="cityNew.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"City Name"'
            />

            <CustomInput
              v-model="cityNew.tax"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"City Sales Tax"'
              @change="onChangeFloatValue('tax')"
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addCityRow" />
          </CustomTableRow>

          <CustomTableRow>
            <LoadingBar v-if="$apollo.loading" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addCity">+ Add City </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import CityList from '../graphql/queries/cityList.gql'
import States from '../graphql/queries/states.gql'
import CreateCity from '../graphql/mutations/city/createCity.gql'
import UpdateCity from '../graphql/mutations/city/updateCity.gql'
import DeleteCity from '../graphql/mutations/city/deleteCity.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomSelect from './CustomSelect.vue'
import CustomInput from './CustomInput.vue'
import DefaultButton from './DefaultButton.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'
import LoadingBar from './LoadingBar.vue'

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
  name: 'HQCityContent',
  components: {
    ValidationObserver,
    PageContentWrapper,
    CustomTable,
    CustomTableRow,
    CustomSelect,
    CustomInput,
    DefaultButton,
    CustomTableAddIcon,
    LoadingBar,

     // pagination
    PaginationRow,
    PaginationButton,
    PaginationInput,
    // pagination

  },
  mixins: [submitMessagesMixin, formMixin, mutationMixin, tableActionsMixin,  paginatorMixin],
  apollo: {
    states: {
      query: States,
    },
  },
  data() {
    return {
      // pagination
      query: CityList,
      queryName: "cityList",
      currentPage: 1,
      queryData: {},
      // pagination
      
      cityNew: {
        name: '',
        state: null,
        tax: '',
      },
      cityEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    onChangeFloatValue(stateProp, isEdit = false) {
      if ( isEdit ) {
        this.cityEdit[stateProp] = parseFloat(this.cityEdit[stateProp] !== '' ? this.cityEdit[stateProp] : 0).toFixed(2)
      } else {
        this.cityNew[stateProp] = parseFloat(this.cityNew[stateProp] !== '' ? this.cityNew[stateProp] : 0).toFixed(2)
      }
    },
    editCity(city) {
      this.cityEdit = Object.assign({}, city)
      this.edit(city.id)
    },
    selectStateEdit(state) {
      this.cityEdit.state = state
    },
    selectState(state) {
      this.cityNew.state = state
    },
    addCityRow() {
      this.cityNew = {
        name: '',
        state: null,
        tax: '',
      }
      this.addRow()
    },
    async addCity() {
      const res = await this.mutationAction(
        CreateCity,
        {
          cityInput: {
            name: this.cityNew.name,
            state: {
              connect: Number(this.cityNew.state.id),
            },
            tax: +this.cityNew.tax,
          },
        },
        null,
        'Add city success',
        'Add city error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    async confirmEdit(city) {
      const editedCity = {
        id: city.id,
        name: this.cityEdit.name,
        state: {
          connect: this.cityEdit.state.id,
        },
        tax: +this.cityEdit.tax,
      }

      const res = await this.mutationAction(
        UpdateCity,
        { cityInput: editedCity },
        null,
        'Edit city success',
        'Edit city error',
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
        DeleteCity,
        { id },
        null,
        'Delete city success',
        'Delete city error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelCityEdit() {
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
    grid-template-columns: 100px 250px 150px auto;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 100px 120px 120px auto;
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

.buttons-area {
  margin-top: 25px;
}
</style>
