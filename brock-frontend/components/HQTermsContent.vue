<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <CustomTable v-else :w-table="780">
        <template #header>
          <div class="table-row">
            <span> Name </span>

            <span> Due Days </span>

            <span> Disc Percent </span>

            <span> Disc Days </span>
          </div>
        </template>

        <template v-if="queryData.data" #content>
          <CustomTableRow
            v-for="term in queryData.data"
            :key="term.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === term.id"
              v-model="termEdit.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"Term Name"'
            />
            <span v-else>{{ term.name }}</span>

            <CustomInput
              v-if="isEdit === term.id"
              v-model="termEdit.dueDays"
              type="number"
              rules="required"
              do-not-show-error-message
              name='"Term Due Days"'
            />
            <span v-else>{{ term.dueDays }}</span>

            <CustomInput
              v-if="isEdit === term.id"
              v-model="termEdit.discPercent"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Term Disc Percent"'
              @change="onChangeFloatValue('discPercent', true)"
            />
            <span v-else>
              {{ parseFloat(term.discPercent).toFixed(2) }}%
            </span>

            <CustomInput
              v-if="isEdit === term.id"
              v-model="termEdit.discDays"
              type="number"
              rules="required"
              do-not-show-error-message
              name='"Term Disc Days"'
            />
            <span v-else>{{ term.discDays }}</span>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === term.id"
              :is-delete-active="isDelete === term.id"
              @edit="isAdd ? null : editTerm(term)"
              @delete="isAdd ? null : deleteItem(term.id)"
              @cancel="cancelTermEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(term)"
              @confirm-delete="confirmDelete(term.id)"
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
              v-model="termNew.name"
              rules="required|max:255"
              do-not-show-error-message
              name='"Term Name"'
            />

            <CustomInput
              v-model="termNew.dueDays"
              type="number"
              rules="required"
              do-not-show-error-message
              name='"Term Due Days"'
            />

            <CustomInput
              v-model="termNew.discPercent"
              type="number"
              rules="required|double|between:0,100"
              do-not-show-error-message
              is-float="true"
              name='"Term Disc Percent"'
              @change="onChangeFloatValue('discPercent')"
            />

            <CustomInput
              v-model="termNew.discDays"
              type="number"
              rules="required"
              do-not-show-error-message
              name='"Term Disc Days"'
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addTermRow" />
          </CustomTableRow>
        </template>
      </CustomTable>
    </ValidationObserver>

    <div v-if="isAdd" class="buttons-area">
      <DefaultButton @event="addTerm">+ Add Term </DefaultButton>

      <DefaultButton @event="cancelAdd"> Cancel </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import TermList from '../graphql/queries/termList.gql'
import CreateTerm from '../graphql/mutations/term/createTerm.gql'
import UpdateTerm from '../graphql/mutations/term/updateTerm.gql'
import DeleteTerm from '../graphql/mutations/term/deleteTerm.gql'
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
  name: 'HQTermsContent',
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
      query: TermList,
      queryName: "termList",
      currentPage: 1,
      queryData: {},
      // pagination

      termNew: {
        name: '',
        dueDays: '',
        discPercent: '',
        discDays: '',
      },
      termEdit: {},
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    onChangeFloatValue(stateProp, isEdit = false) {
      if ( isEdit ) {
        this.termEdit[stateProp] = parseFloat(this.termEdit[stateProp] !== '' ? this.termEdit[stateProp] : 0).toFixed(2)
      } else {
        this.termNew[stateProp] = parseFloat(this.termNew[stateProp] !== '' ? this.termNew[stateProp] : 0).toFixed(2)
      }
    },
    editTerm(term) {
      this.termEdit = Object.assign({}, term)
      this.edit(term.id)
    },
    addTermRow() {
      this.termNew = {
        name: '',
        dueDays: '',
        discPercent: '',
        discDays: '',
      }
      this.addRow()
    },
    async addTerm() {
      const res = await this.mutationAction(
        CreateTerm,
        {
          termInput: {
            name: this.termNew.name,
            dueDays: this.termNew.dueDays,
            discPercent: +this.termNew.discPercent,
            discDays: +this.termNew.discDays,
          },
        },
        null,
        'Add term success',
        'Add term error',
        null,
        true
      )

      // pagination
      res !== false && this.clearTableActionState();
      res !== false && this.goToPage((this.queryData.paginatorInfo.total === this.queryData.paginatorInfo.perPage * this.queryData.paginatorInfo.lastPage) ? this.queryData.paginatorInfo.lastPage + 1 : this.queryData.paginatorInfo.lastPage)
      // pagination
    },
    async confirmEdit(term) {
      const editedTerm = {
        id: term.id,
        name: this.termEdit.name,
        dueDays: this.termEdit.dueDays,
        discPercent: +this.termEdit.discPercent,
        discDays: +this.termEdit.discDays,
      }

      const res = await this.mutationAction(
        UpdateTerm,
        {
          termInput: editedTerm,
        },
        null,
        'Edit term success',
        'Edit term error',
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
        DeleteTerm,
        { id },
        null,
        'Delete term success',
        'Delete term error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
    cancelTermEdit() {
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
    grid-template-columns: 20% 20% 20% 20% auto;
  }
  @media screen and (max-width: $lg) {
    grid-template-columns: 200px 100px 100px 100px auto;
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
