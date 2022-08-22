<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
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

      <!-- <LoadingBar v-if="$apollo.loading" /> -->
      <CustomTable v-if="unit" class="table-register" :w-table="1100">
        <template #header>
          <div class="table-row">
            <span>Code</span>

            <span>Name</span>

            <span>Type</span>

            <span>Reg Bank</span>

            <span>Non-Resetable</span>

            <span>Commission</span>

            <span>Active</span>

            <span>Reset Non-Resetable</span>
          </div>
        </template>

        <template v-if="registers" #content>
          <CustomTableRow
            v-for="register in unitRegisters"
            :key="register.id"
            class="table-row"
          >
            <CustomInput
              v-if="isEdit === register.id"
              v-model="registerEdit.code"
              rules="required|max:255"
              name='"Code"'
              do-not-show-error-message
            />
            <span v-else>
              {{ register.code }}
            </span>

            <CustomInput
              v-if="isEdit === register.id"
              v-model="registerEdit.name"
              rules="required|max:255"
              name='"Name"'
              do-not-show-error-message
            />
            <span v-else>
              {{ register.name }}
            </span>

            <CustomSelect
              v-if="registerTypes && isEdit === register.id"
              :options="registerTypes"
              @input="selectRegisterType"
            />
            <span v-else>
              {{ register.registerType.name }}
            </span>

            <CustomInput
              v-if="isEdit === register.id"
              v-model="registerEdit.bank"
              type="number"
              rules="required|double"
              name='"Reg Bank"'
              do-not-show-error-message
              is-float="true"
              @change="onChangeFloatValue('bank', true)"
            />
            <span v-else> ${{ parseFloat(register.bank).toFixed(2) }} </span>

            <CustomInput
              v-if="isEdit === register.id"
              v-model="registerEdit.nonResetable"
              type="number"
              rules="required|double"
              name='"Non-Resetable"'
              do-not-show-error-message
              is-float="true"
              @change="onChangeFloatValue('nonResetable', true)"
            />
            <span v-else> ${{ parseFloat(register.nonResetable).toFixed(2) }} </span>

            <CustomInput
              v-if="isEdit === register.id"
              v-model="registerEdit.commission"
              type="number"
              rules="required|double"
              name='"Commission"'
              do-not-show-error-message
              is-float="true"
              @change="onChangeFloatValue('commission', true)"
            />
            <span v-else> {{ parseFloat(register.commission).toFixed(2) }}% </span>

            <CustomRadioButton
              v-if="isEdit === register.id"
              :is-active="registerEdit.isActive"
              :disabled="isEdit !== register.id"
              @set-is-active="setIsActiveEdit(register)"
            />
            <CustomRadioButton
              v-else
              :is-active="register.isActive"
              :disabled="isEdit !== register.id"
              @set-is-active="setIsActive(register)"
            />

            <CustomRadioButton
              v-if="isEdit === register.id"
              :is-active="registerEdit.resetNonResetable"
              :disabled="isEdit !== register.id"
              @set-is-active="setResetNonResetableEdit(register)"
            />
            <CustomRadioButton
              v-else
              :is-active="register.resetNonResetable"
              :disabled="isEdit !== register.id"
              @set-is-active="setResetNonResetable(register)"
            />

            <CustomTableIconsColumn
              :is-edit-active="isEdit === register.id"
              :is-delete-active="isDelete === register.id"
              @edit="isAdd ? null : editRegister(register)"
              @delete="isAdd ? null : deleteItem(register.id)"
              @cancel="cancelRegisterEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(registerEdit)"
              @confirm-delete="confirmDelete(register.id)"
            />
          </CustomTableRow>

          <CustomTableRow v-if="isAdd" class="table-row">
            <CustomInput
              v-model="registerNew.code"
              rules="required|max:255"
              name='"Code"'
              do-not-show-error-message
            />

            <CustomInput
              v-model="registerNew.name"
              rules="required|max:255"
              name='"Name"'
              do-not-show-error-message
            />

            <CustomSelect
              v-if="registerTypes"
              :options="registerTypes"
              @input="selectRegisterType"
            />

            <CustomInput
              v-model="registerNew.bank"
              type="number"
              rules="required|double"
              name='"Reg Bank"'
              do-not-show-error-message
              is-float="true"
              @change="onChangeFloatValue('bank')"
            />

            <CustomInput
              v-model="registerNew.nonResetable"
              type="number"
              rules="required|double"
              name='"Non-Resetable"'
              do-not-show-error-message
              is-float="true"
              @change="onChangeFloatValue('nonResetable')"
            />

            <CustomInput
              v-model="registerNew.commission"
              type="number"
              rules="required|double"
              name='"Commission"'
              do-not-show-error-message
              is-float="true"
              @change="onChangeFloatValue('commission')"
            />

            <CustomRadioButton
              :is-active="registerNew.isActive"
              @set-is-active="setIsActive"
            />

            <CustomRadioButton
              :is-active="registerNew.resetNonResetable"
              @set-is-active="setResetNonResetable"
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addRow" />
          </CustomTableRow>
        </template>
      </CustomTable>

      <div v-if="isAdd" class="buttons-area">
        <DefaultButton @event="addRegister">+ Add Register </DefaultButton>

        <DefaultButton @event="cancelAddRegister"> Cancel </DefaultButton>
      </div>
    </ValidationObserver>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import Units from '../graphql/queries/units.gql'
import Registers from '../graphql/queries/registers.gql'
import RegisterTypes from '../graphql/queries/registersType.gql'
import CreateRegister from '../graphql/mutations/register/createRegister.gql'
import UpdateRegister from '../graphql/mutations/register/updateRegister.gql'
import DeleteRegister from '../graphql/mutations/register/deleteRegister.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomSelect from './CustomSelect.vue'
import CustomInput from './CustomInput.vue'
import CustomTable from './CustomTable.vue'
import CustomRadioButton from './CustomRadioButton.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import { multiselectMixin } from '~/mixins/multiselectMixin'
export default {
  name: 'HQRegistersContent',
  components: {
    PageContentWrapper,
    ValidationObserver,
    InputRow,
    InputWithTitle,
    CustomSelect,
    CustomInput,
    CustomTable,
    CustomRadioButton,
    CustomTableAddIcon,
  },
  mixins: [mutationMixin, tableActionsMixin, multiselectMixin],
  apollo: {
    units: {
      query: Units,
      prefetch: true,
    },
    registers: {
      query: Registers,
    },
    registerTypes: {
      query: RegisterTypes,
    },
  },
  data() {
    return {
      unit: '',
      registerNew: {
        code: '',
        name: '',
        registerType: {},
        bank: '',
        nonResetable: '',
        commission: '',
        isActive: false,
        resetNonResetable: false,
      },
      registerEdit: {},
    }
  },
  computed: {
    unitRegisters() {
      return this.registers.filter(
        (register) => register.unit?.id === this.unit.id
      )
    },
  },
  methods: {
    onChangeFloatValue(stateProp, isEdit = false) {
      if ( isEdit ) {
        this.registerEdit[stateProp] = parseFloat(this.registerEdit[stateProp] !== '' ? this.registerEdit[stateProp] : 0).toFixed(2)
      } else {
        this.registerNew[stateProp] = parseFloat(this.registerNew[stateProp] !== '' ? this.registerNew[stateProp] : 0).toFixed(2)
      }
    },
    editRegister(register) {
      this.registerEdit = Object.assign({}, register)
      this.edit(register.id)
    },
    selectRegisterType(type) {
      this.registerType = type
    },
    setIsActiveEdit() {
      this.registerEdit.isActive = !this.registerEdit.isActive
    },
    setIsActive(register) {
      if (register) {
        register.isActive = !register.isActive
      } else {
        this.registerNew.isActive = !this.registerNew.isActive
      }
    },
    setResetNonResetableEdit() {
      this.registerEdit.resetNonResetable = !this.registerEdit.resetNonResetable
    },
    setResetNonResetable(register) {
      if (register) {
        register.resetNonResetable = !register.resetNonResetable
      } else {
        this.registerNew.resetNonResetable = !this.registerNew.resetNonResetable
      }
    },
    async addRegister() {
      const unit = this.unit
      await this.mutationAction(
        CreateRegister,
        {
          registerInput: {
            unit: {
              connect: Number(this.unit.id),
            },
            ...this.registerNew,
            bank: +this.registerNew.bank,
            nonResetable: +this.registerNew.nonResetable,
            commission: +this.registerNew.commission,
            registerType: {
              connect: Number(this.registerType.id),
            },
          },
        },
        Registers,
        'Add register success',
        'Add register error',
        null,
        null
      )

      this.unit = unit
    },
    async confirmEdit(register) {
      const unit = this.unit
      const { __typename, createdAt, updatedAt, ...registerInput } = register

      await this.mutationAction(
        UpdateRegister,
        {
          registerInput: {
            ...registerInput,
            bank: +register.bank,
            nonResetable: +register.nonResetable,
            commission: +register.commission,
            registerType: {
              connect: Number(this.registerType.id),
            },
            unit: {
              connect: Number(register.unit.id),
            },
          },
        },
        Registers,
        'Edit register success',
        'Edit register error',
        null,
        null
      )

      this.unit = unit
    },
    async confirmDelete(id) {
      const unit = this.unit

      await this.mutationAction(
        DeleteRegister,
        { id },
        Registers,
        'Delete register success',
        'Delete register error'
      )
      this.unit = unit
    },
    cancelAddRegister() {
      this.isAdd = false
      this.isHide = false
    },
    cancelRegisterEdit() {
      this.cancelEdit()
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

.multiselect__content-wrapper {
  width: auto;
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
</style>
<style lang="scss" scoped>
.table-row {
  display: grid;
  align-items: center;
  padding: 12px 0;
  @media screen and (min-width: $md) {
    grid-template-columns: 50px 150px 200px 70px 100px 85px 50px 135px auto;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 50px 120px 120px 70px 100px 85px 50px 120px auto;
  }
  column-gap: 20px;
}

.row {
  padding: 16px 10px;  
}

.table-register {
  @media screen and (min-width: $lg) and (max-width: $xxl) {
    width: calc(100vw - 280px);
  }
}

.icon {
  cursor: pointer;

  &--add {
    grid-column: 9;
    justify-self: end;
  }
}

.buttons-area {
  margin-top: 25px;
}

</style>
