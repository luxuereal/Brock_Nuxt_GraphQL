<template>
  <!-- <LoadingBar v-if="$apollo.loading" /> -->
  <PageContentWrapper>
    <div class="header">
      <InputRow>
        <InputWithTitle has-select>
          <template #title> Unit </template>

          <template #input>
            <multiselect
              v-if="units"
              v-model="unit"
              :options="units"
              :custom-label="nameWithId"
              placeholder="Select one"
              track-by="name"
              :preselect-first="false"
              :show-labels="false"
              :disabled="isAttachGlAccounts"
            ></multiselect>
          </template>
        </InputWithTitle>

        <InputWithTitle v-if="unit">
          <template #title> Name </template>

          <template #input>
            <CustomInput v-model="unit.name" readonly disabled />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow v-if="isAttachGlAccounts">
        <InputWithTitle has-select>
          <template #title> GL Account </template>

          <template #input>
            <multiselect
              v-if="glAccounts"
              v-model="glAccount"
              :options="glAccounts"
              :custom-label="nameWithId"
              placeholder="Select one"
              track-by="name"
              :preselect-first="false"
              :show-labels="false"
            ></multiselect>
          </template>
        </InputWithTitle>

        <InputWithTitle v-if="glAccount && glAccount.child" has-select>
          <template #title> GL Sub Account </template>

          <template #input>
            <multiselect
              v-if="glAccount && !glAccount.parent"
              v-model="glSubAccount"
              :options="glAccount.child"
              :custom-label="nameWithId"
              placeholder="Select one"
              track-by="name"
              :preselect-first="false"
              :show-labels="false"
            ></multiselect>
          </template>
        </InputWithTitle>
      </InputRow>
    </div>

    <DefaultButton
      :disabled="!unit"
      @event="isAttachGlAccounts ? addGlToUnit() : showAttachGlAccounts()"
    >
      Attach new GL account
    </DefaultButton>
    <DefaultButton v-if="isAttachGlAccounts" @event="cancelAttach">
      Cancel
    </DefaultButton>

    <ValidationObserver v-if="!isAttachGlAccounts" ref="form">
      <div>
        <div class="gl-table">
          <div v-if="(unit.glAccounts && unit.glAccounts.length) || searchAccount" class="gl-account-area">
            <h2 class="gl-account-header">
              Gl Accounts
            </h2>
            <div class="search-area">
              <span class="search-span">Search: </span>

              <CustomInput
                v-model="searchGlAccount"
                placeholder="GL(Sub) Name, ID"
              />
            </div>
          
          </div>
          <h2 v-else class="table-header">Please, attach new GL Account</h2>

          <CustomTable
            v-if="(unit.glAccounts && unit.glAccounts.length) || searchAccount"
            class="table table-gls"
            :w-table="1000"
          >
            <template #header>
              <div class="table-row">
                <!-- <span>ID</span> -->

                <span>GL account ID - GL account Name</span>

                <span>GL sub account ID - GL sub account Name</span>

                <span> Type </span>

                <!-- <span>Action</span> -->
              </div>
            </template>

            <template v-if="glAccounts" #content>
              <CustomTableRow
                v-for="glAcc in unit.glAccounts"
                :key="glAcc.id"
                class="table-row"
              >
                <!-- <span>{{ glAcc.id }}</span> -->

                <span v-if="!glAcc.parent">{{
                  `${glAcc.id} - ${glAcc.name}`
                }}</span>
                <span v-else></span>

                <div v-if="glAcc.parent">
                  {{ `${glAcc.id} - ${glAcc.name}` }}
                </div>
                <div v-else></div>

                <span v-if="glAcc.parent">{{
                  glAcc.parent.glTypeCode && glAcc.parent.glTypeCode.description
                }}</span>
                <span v-else-if="!glAcc.parent">{{
                  glAcc.glTypeCode && glAcc.glTypeCode.description
                }}</span>

                <CustomTableIconsColumn
                  :is-delete-active="isDelete === `${glAcc.id}-GL`"
                  :show-edit="false"
                  @delete="deleteItem(`${glAcc.id}-GL`)"
                  @cancel-delete="cancelDelete"
                  @confirm-delete="removeGlFromUnit(glAcc)"
                />
              </CustomTableRow>
            </template>
          </CustomTable>
        </div>

        <div>
          <div class="gl-type-area">
            <h2 class="gl-type-header">Gl Types</h2>

            <div class="search-area">
              <span class="search-span">Search: </span>

              <CustomInput
                v-model="searchGlType"
                placeholder="GL Type Code"
              />
            </div>
          </div>

          <CustomTable class="table table-gls" :w-table="600">
            <template #header>
              <div class="table-row table-row--gl-type">
                <!-- <span>ID</span> -->

                <span>Code</span>

                <span>Description</span>
              </div>
            </template>

            <template v-if="glTypeCodes" #content>
              <CustomTableRow
                v-for="glTypeCode in glTypeCodes"
                :key="glTypeCode.id"
                class="table-row table-row--gl-type"
              >
                <!-- <span>{{ glTypeCode.id }}</span> -->

                <CustomInput
                  v-if="editGlTypeCodeId === glTypeCode.id"
                  v-model="glTypeCodeEdit.code"
                  rules="required|max:255"
                  name='"GL Type Code"'
                  do-not-show-error-message
                />
                <span v-else>{{ glTypeCode.code }}</span>

                <CustomInput
                  v-if="editGlTypeCodeId === glTypeCode.id"
                  v-model="glTypeCodeEdit.description"
                  rules="required|max:255"
                  name='"GL Type Description"'
                  do-not-show-error-message
                />
                <span v-else>{{ glTypeCode.description }}</span>

                <CustomTableIconsColumn
                  :is-edit-active="editGlTypeCodeId === glTypeCode.id"
                  :is-delete-active="isDelete === glTypeCode.id"
                  @edit="editGlTypeCode(glTypeCode)"
                  @delete="deleteItem(glTypeCode.id)"
                  @cancel="cancelGlTypeCodesCopyEdit"
                  @cancel-delete="cancelDelete"
                  @confirm-edit="confirmEditGlTypeCode(glTypeCode)"
                  @confirm-delete="confirmDeleteGlTypeCode(glTypeCode.id)"
                />
              </CustomTableRow>

              <CustomTableRow
                v-if="isAddGlTypeCode"
                class="table-row table-row--gl-type"
              >
                <span>-</span>

                <CustomInput
                  v-model="glTypeCodeNew.code"
                  rules="required|max:255"
                  name='"GL Type Code"'
                  do-not-show-error-message
                />

                <CustomInput
                  v-model="glTypeCodeNew.description"
                  rules="required|max:255"
                  name='"GL Type Description  "'
                  do-not-show-error-message
                />
              </CustomTableRow>

              <CustomTableRow class="table-row add-row table-row--gl-type">
                <CustomTableAddIcon
                  :is-hide="isHideTypeCodes"
                  @add-row="addGlTypeRow"
                />
              </CustomTableRow>
            </template>
          </CustomTable>

          <div v-if="isAddGlTypeCode" class="buttons-area">
            <DefaultButton @event="createGlTypeCode">
              + Add Unit Type
            </DefaultButton>

            <DefaultButton @event="cancelAddGlTypeCode"> Cancel </DefaultButton>
          </div>
        </div>
      </div>
    </ValidationObserver>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import Multiselect from 'vue-multiselect'
import Units from '../graphql/queries/units.gql'
import GlAccounts from '../graphql/queries/glAccounts.gql'
import GlTypeCodes from '../graphql/queries/glTypeCodes.gql'
import UpdateUnit from '../graphql/mutations/unit/updateUnit.gql'
import CreateGlTypeCode from '../graphql/mutations/glTypeCode/createGlTypeCode.gql'
import UpdateGlTypeCode from '../graphql/mutations/glTypeCode/updateGlTypeCode.gql'
import DeleteGlTypeCode from '../graphql/mutations/glTypeCode/deleteGlTypeCode.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomInput from './CustomInput.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'
import DefaultButton from './DefaultButton.vue'
import { mutationMixin } from '~/mixins/mutationMixin'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
export default {
  name: 'HQUnitGLMaintenance',
  components: {
    ValidationObserver,
    PageContentWrapper,
    InputWithTitle,
    InputRow,
    CustomInput,
    CustomTable,
    CustomTableRow,
    CustomTableAddIcon,
    DefaultButton,
    Multiselect,
  },
  apollo: {
    units: {
      query: Units,
    },
    glAccounts: {
      query: GlAccounts,
    },
    glTypeCodes: {
      query: GlTypeCodes
    }
  },
  mixins: [mutationMixin, tableActionsMixin],
  data() {
    return {
      unit: '',
      isAddGlTypeCode: false,
      glTypeCodeNew: {
        code: '',
        description: '',
      },
      isHideTypeCodes: false,
      editGlTypeCodeId: '',
      glAccount: '',
      glSubAccount: '',
      isAttachGlAccounts: false,
      glTypeCodeEdit: false,
      
      searchType: '',
      searchAccount: '',
      
      glAccountsTmp: {},
      glTypeCodes: {},
      queryVariable: {
        search: '',
      },
      timeout: null
    }
  },
  computed: {
    searchGlType: {
      get() {
        return this.searchType
      },
      set(value) {
        this.searchType = value
      }
    },
    searchGlAccount: {
      get() {
        return this.searchAccount
      },
      set(value) {
        this.searchAccount = value
      }
    }
  },
  watch: {
    unit() {
      this.glAccountsTmp = this.unit.glAccounts
      // this.fetchAccountData()
    },
    glAccount() {
      this.glSubAccount = ''
    },
    searchGlType() {
      clearTimeout(this.timeout)
      this.timeout = setTimeout(() => this.fetchTypeData())
    },
    searchGlAccount() {
      this.fetchAccountData()
    }
  },
  beforeMount() {
    this.fetchTypeData()
  },
  methods: {
    fetchAccountData() {
      const glAccounts = this.glAccountsTmp?.filter((data) => data.name.toLowerCase().includes(this.searchAccount.toLowerCase()) || data.id.includes(this.searchAccount))
      this.unit.glAccounts = glAccounts
    },
    async fetchTypeData() {
      
      if(this.searchType !== '') this.queryVariable.search = '%' + this.searchType + '%';
      else this.queryVariable.search = '%';

      const queryData = await this.$apollo.query({
          query: GlTypeCodes,
          fetchPolicy: 'network-only',
          variables: this.queryVariable,
      });
      this.glTypeCodes = queryData.data.glTypeCodes
    },
    nameWithId({ name, code, id }) {
      if(code === undefined) {
        return `${id} — ${name}`
      }else {
        return `${code} — ${name}`
      }
    },
    showAttachGlAccounts() {
      this.isAttachGlAccounts = true
    },
    cancelAttach() {
      this.isAttachGlAccounts = false 
    },
    addGlTypeRow() {
      this.isAddGlTypeCode = true
      this.isHideTypeCodes = true
    },
    cancelAddGlTypeCode() {
      this.isAddGlTypeCode = false
      this.isHideTypeCodes = false
    },
    selectUnit(item) {
      this.unit = item
    },
    async createGlTypeCode() {
      const unit = this.unit
      const searchAccount = this.searchAccount

      await this.mutationAction(
        CreateGlTypeCode,
        {
          GlTypeCodeInput: {
            code: this.glTypeCodeNew.code,
            description: this.glTypeCodeNew.description,
          },
        },
        GlTypeCodes,
        'Add Gl Type success',
        'Add Gl Type error'
      )
      this.unit = unit
      this.searchAccount = searchAccount
    },
    async confirmEditGlTypeCode(GlType) {
      const unit = this.unit
      const searchAccount = this.searchAccount
      const editedUnitType = {
        id: GlType.id,
        code: this.glTypeCodeEdit.code,
        description: this.glTypeCodeEdit.description,
      }

      await this.mutationAction(
        UpdateGlTypeCode,
        {
          GlTypeCodeInput: editedUnitType,
        },
        GlTypeCodes,
        'Edit Gl Type success',
        'Edit Gl Type error'
      )
      this.unit = unit
      this.searchAccount = searchAccount
    },
    async confirmDeleteGlTypeCode(id) {
      const unit = this.unit
      const searchAccount = this.searchAccount

      await this.mutationAction(
        DeleteGlTypeCode,
        { id },
        GlTypeCodes,
        'Delete Gl Type success',
        'Delete Gl Type error'
      )
      this.unit = unit
      this.searchAccount = searchAccount
    },
    async addGlToUnit() {
      const searchType = this.searchType
      const glTypeCodes = this.glTypeCodes
      const { id } = this.unit

      const {
        data: { updateUnit },
      } = await this.mutationAction(
        UpdateUnit,
        {
          unitInput: {
            id,
            glAccounts: {
              sync: this.glSubAccount
                ? [
                    ...this.unit.glAccounts.map((glAccount) => glAccount.id),
                    this.glAccount.id,
                    this.glSubAccount.id,
                  ]
                : [
                    ...this.unit.glAccounts.map((glAccount) => glAccount.id),
                    this.glAccount.id,
                  ],
            },
          },
        },
        Units,
        'Add Gl account to unit success',
        'Add Gl account to unit error'
      )

      this.searchType = searchType
      this.glTypeCodes = glTypeCodes

      if (updateUnit) {
        this.unit = updateUnit
        this.cancelAttach()
      }
    },
    async removeGlFromUnit(glAccount) {
      const searchType = this.searchType
      const glTypeCodes = this.glTypeCodes
      const { id } = this.unit
      
      const {
        data: { updateUnit },
      } = await this.mutationAction(
        UpdateUnit,
        {
          unitInput: {
            id,
            glAccounts: {
              disconnect: glAccount.id,
            },
          },
        },
        Units,
        'Remove Gl account from unit success',
        'Remove Gl account from unit error'
      )

      this.searchType = searchType
      this.glTypeCodes = glTypeCodes

      if (updateUnit) {
        this.unit = updateUnit
      }
    },
    editGlTypeCode(glTypeCode) {
      this.glTypeCodeEdit = Object.assign({}, glTypeCode)
      this.editGlTypeCodeId = glTypeCode.id
    },
    cancelGlTypeCodesCopyEdit() {
      this.isHide = false
      this.editGlTypeCodeId = null
    },
  },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss">
.input {
  &-row--offset {
    display: flex;
    margin: 0 -15px;
  }

  &-col {
    min-width: 240px;
    padding: 0 15px;
  }
}

.mb-20 {
  margin-bottom: 20px;
}

.multiselect__tags {
  border: 1px solid gainsboro;
  border-radius: 3px;
}

.multiselect__option {
  padding: 10px 16px 10px 8px;
  color: #000;
  font-size: 14px;
  background: #fff;
}

.multiselect__option--highlight,
.multiselect__option--highlight:after {
  color: #fff;
  background-color: #b01d22;
}
.multiselect__option--selected.multiselect__option--highlight {
  background: rgba(#b01d22, 0.6);
}

.multiselect__tag {
  background-color: #b01d22;
}

.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
  background-color: #b01d22;
}

.multiselect__tag-icon:after {
  color: #fff;
}

.multiselect__select:before {
  border: none;
  width: 24px;
  height: 24px;
  background: url(assets/images/icons/chevron-down.svg);
  display: block;
  top: 0;
}

.input-row {
  @media screen and (max-width: $sm) {
    flex-direction: column;

    div:first-child {
      margin-right: 0px !important;
      margin-bottom: 16px;
    }
  }
}
</style>
<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: flex-start;
  column-gap: 30px;
  padding: 12px 0;
  @media screen and (min-width: $md) {
    grid-template-columns: 25% 30% 15% auto;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 200px 250px 150px auto;
  }
  &--gl-type {
    grid-template-columns: 20% 25% auto;
  }
}

.row {
  padding: 6px 10px;
  align-items: center;

  span {
    min-height: 40px;
    display: flex;
    align-items: center;
  }

  div {
    span {
      min-height: auto;
      padding-bottom: 10px;
    }
  }
}

.table-gls {
  @media screen and (min-width: $lg) and (max-width: $xxl) {
    width: calc(100vw - 280px);
  }
}

.icon {
  cursor: pointer;
}

.gl-table {
  margin: 20px 0;
}

.table-header {
  margin-bottom: 8px;
}

.gl-type-area, .gl-account-area {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}

.search-area {
  display: flex;
  align-items: center;

  .search-span {
    margin-right: 10px;
  }
}

</style>
