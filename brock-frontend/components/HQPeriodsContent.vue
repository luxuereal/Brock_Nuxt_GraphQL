<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="780">
        <template #header>
          <div class="table-row">
            <span> Period end </span>

            <span class="text-center"> Year number </span>

            <span class="text-center"> Month number </span>

            <span class="text-center"> Week number </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="period in mutablePeriods"
            :key="period.id"
            class="table-row"
          >
            <CustomDatePicker
              v-if="isEdit === period.id"
              v-model="periodEdit.periodEnd"
              rules="required|date"
              placeholder="mm/dd/yyyy"
              type="date"
              do-not-show-error-message
              name='"Period End"'
            />
            <span v-else>{{ period.periodEnd }}</span>

            <CustomInput
              v-if="isEdit === period.id"
              v-model="periodEdit.year"
              rules="required|numeric"
              type="number"
              do-not-show-error-message
              name='"Period Year"'
            />
            <span v-else class="text-center">{{ period.year }}</span>

            <CustomInput
              v-if="isEdit === period.id"
              v-model="periodEdit.month"
              rules="required|numeric"
              type="number"
              do-not-show-error-message
              name='"Period Month"'
            />
            <span v-else class="text-center">{{ period.month }}</span>

            <CustomInput
              v-if="isEdit === period.id"
              v-model="periodEdit.week"
              rules="required|numeric"
              type="number"
              do-not-show-error-message
              name='"Period Week"'
            />
            <span v-else class="text-center">{{ period.week }}</span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === period.id"
              :is-delete-active="isDelete === period.id"
              @edit="isAdd ? null : editPeriod(period)"
              @delete="isAdd ? null : deleteItem(period.id)"
              @cancel="cancelPeriodEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(period)"
              @confirm-delete="confirmDelete(period.id)"
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
            <CustomDatePicker
              v-model="periodNew.periodEnd"
              rules="required|date"
              type="date"
              placeholder="mm/dd/yyyy"
              do-not-show-error-message
              name='"Period End"'
            />

            <CustomInput
              v-model="periodNew.year"
              rules="required|numeric"  
              type="number"
              do-not-show-error-message
              name='"Period Year"'
            />

            <CustomInput
              v-model="periodNew.month"
              rules="required|numeric"
              type="number"
              do-not-show-error-message
              name='"Period Month"'
            />

            <CustomInput
              v-model="periodNew.week"
              rules="required|numeric"
              type="number"
              do-not-show-error-message
              name='"Period Week"'
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addPeriodRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addPeriod">+ Add Period </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import PeriodList from '../graphql/queries/periodList.gql'
import CreatePeriod from '../graphql/mutations/period/createPeriod.gql'
import UpdatePeriod from '../graphql/mutations/period/updatePeriod.gql'
import DeletePeriod from '../graphql/mutations/period/deletePeriod.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomInput from './CustomInput.vue'
import CustomDatePicker from './CustomDatePicker.vue'
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
import {formatDateFromAPI, formatDate} from "~/helpers/helpers";

// pagination
import { paginatorMixin } from '~/mixins/paginatorMixin'
// pagination

export default {
  name: 'HQPeriodsContent',
  components: {
    ValidationObserver,
    PageContentWrapper,
    CustomTable,
    CustomTableRow,
    CustomInput,
    CustomTableAddIcon,
    CustomDatePicker,

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
      query: PeriodList,
      hasQueryVariable: true,
      queryVariable: {
        hasUnits: false,
      },
      queryName: "periodList",
      currentPage: 1,
      queryData: {},
      // pagination
      
      mutablePeriods: [],
      periodNew: {
        periodEnd: '',
        year: null,
        month: null,
        week: null,
      },
      periodEdit: {},
    }
  },
  computed: {
    formattedPeriods() {
      return this.queryData.data && this.queryData.data.length && this.queryData.data.map((period) => {
        return {
          ...period,
          periodEnd: this.formatDateFromAPI(period.periodEnd),
        }
      })
    },
  },
  watch: {
    queryData() {
      if (this.queryData.data && this.queryData.data.length)
        this.mutablePeriods = Object.assign({}, this.formattedPeriods);
    },
  },
  beforeMount(){
    this.fetchData();
  },
  mounted() {
    if (this.queryData.data && this.queryData.data.length)
      this.mutablePeriods = Object.assign({}, this.formattedPeriods);
  },
  methods: {
    formatDate,
    formatDateFromAPI,
    editPeriod(period) {
      this.periodEdit = Object.assign({}, period)
      this.edit(period.id)
    },
    addPeriodRow() {
      this.periodNew = {
        periodEnd: '',
        year: null,
        month: null,
        week: null,
      }
      this.addRow()
    },
    async addPeriod() {
      const res = await this.mutationAction(
        CreatePeriod,
        {
          periodInput: {
            periodEnd: this.formatDate(this.periodNew.periodEnd),
            year: Number(this.periodNew.year),
            month: Number(this.periodNew.month),
            week: Number(this.periodNew.week),
          },
        },
        null,
        'Add period success',
        'Add period error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage(1)
      // pagination
    },
    async confirmEdit(period) {
      const editedPeriod = {
        id: period.id,
        periodEnd: this.formatDate(this.periodEdit.periodEnd),
        year: Number(this.periodEdit.year),
        month: Number(this.periodEdit.month),
        week: Number(this.periodEdit.week),
      }

      const res = await this.mutationAction(
        UpdatePeriod,
        { periodInput: editedPeriod },
        null,
        'Edit period success',
        'Edit period error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage(1);
      // pagination
    },
    async confirmDelete(id) {
      const res = await this.mutationAction(
        DeletePeriod,
        { id },
        null,
        'Delete period success',
        'Delete period error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelPeriodEdit() {
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
    grid-template-columns: 20% 10% 10% 10% auto;
  }
  @media screen and (max-width: $lg) {
    grid-template-columns: 100px 60px 60px 60px auto;
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

.text-center {
  text-align: center;
}

.icon--add {
  grid-column: 5;
}
</style>
