<template>
  <PageContentWrapper>
    <!-- <LoadingBar v-if="$apollo.loading"/> -->
    <div class="header">
      <div class="unit-type-desc">
        <InputRow>
          <InputWithTitle has-select>
            <template #title> Unit</template>

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
            <template #title> Name</template>

            <template #input>
              <CustomInput v-model="unit.name" readonly disabled/>
            </template>
          </InputWithTitle>
        </InputRow>

        <InputRow v-if="unit && unit.unitType">
          <InputWithTitle>
            <template #title> Unit Type ID</template>

            <template #input>
              <span>{{ unit.unitType.id }}</span>
            </template>
          </InputWithTitle>

          <InputWithTitle>
            <template #title> Unit Type Name</template>

            <template #input>
              <span>{{ unit.unitType.name }}</span>
            </template>
          </InputWithTitle>
        </InputRow>
        <span v-else>Unit Type has not been assigned to unit yet</span>
      </div>
    </div>

    <ValidationObserver ref="form">
      <h2 class="unit-type-header">Create Unit Type</h2>

      <CustomTable class="table" :w-table="400">
        <template #header>
          <div class="table-row">
            <!-- <span>ID</span> -->

            <span>Name</span>
            <span></span>
          </div>
        </template>

        <template v-if="unitTypes" #content>
          <CustomTableRow
            v-for="unitType in unitTypes"
            :key="unitType.id"
            class="table-row"
          >
            <!-- <span>{{ unitType.id }}</span> -->

            <CustomInput
              v-if="isEdit === unitType.id"
              v-model="unitTypeEdit.name"
              rules="required|max:255"
              name='"Unit Type Name"'
              do-not-show-error-message
            />
            <span v-else>{{ unitType.name }}</span>

            <div class="button">
              <DefaultButton
                @event="
                  unit.unitType && unit.unitType.id === unitType.id
                    ? removeUnitTypeFromUnit()
                    : addUnitTypeToUnit(unitType)
                "
              >
                {{
                  unit.unitType && unit.unitType.id === unitType.id
                    ? 'Remove Unit Type From Unit'
                    : 'Add Unit Type to Unit'
                }}
              </DefaultButton>
            </div>

            <CustomTableIconsColumn
              :is-edit-active="isEdit === unitType.id"
              :is-delete-active="isDelete === unitType.id"
              @edit="editUnitType(unitType)"
              @delete="deleteItem(unitType.id)"
              @cancel="cancelUnitTypeEdit"
              @cancel-delete="cancelDelete"
              @confirm-edit="confirmEdit(unitType)"
              @confirm-delete="confirmDelete(unitType.id)"
            />
          </CustomTableRow>

          <CustomTableRow v-if="isAdd" class="table-row">
            <span>-</span>

            <CustomInput
              v-model="unitTypeNew.name"
              rules="required|max:255"
              name='"Unit Type Name"'
              do-not-show-error-message
            />
          </CustomTableRow>

          <CustomTableRow class="table-row add-row">
            <CustomTableAddIcon :is-hide="isHide" @add-row="addRow"/>
          </CustomTableRow>
        </template>
      </CustomTable>

      <div v-if="isAdd" class="buttons-area">
        <DefaultButton @event="addUnitType">+ Add UnitType</DefaultButton>

        <DefaultButton @event="cancelAdd"> Cancel</DefaultButton>
      </div>
    </ValidationObserver>
  </PageContentWrapper>
</template>

<script>
import {ValidationObserver} from 'vee-validate'
import UnitTypes from '../graphql/queries/unitTypes.gql'
import Units from '../graphql/queries/units.gql'
import UpdateUnit from '../graphql/mutations/unit/updateUnit.gql'
import CreateUnitType from '../graphql/mutations/unitType/createUnitType.gql'
import DeleteUnitType from '../graphql/mutations/unitType/deleteUnitType.gql'
import UpdateUnitType from '../graphql/mutations/unitType/updateUnitType.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomInput from './CustomInput.vue'
import CustomTableAddIcon from './CustomTableAddIcon.vue'
import {mutationMixin} from '~/mixins/mutationMixin'
import {tableActionsMixin} from '~/mixins/tableActionsMixin'
import {multiselectMixin} from '~/mixins/multiselectMixin'
import {submitMessagesMixin} from '~/mixins/submitMessagesMixin'

export default {
  name: 'HQUnitTypeContent',
  components: {
    PageContentWrapper,
    ValidationObserver,
    CustomTable,
    CustomTableRow,
    CustomInput,
    CustomTableAddIcon,
  },
  mixins: [mutationMixin, tableActionsMixin, multiselectMixin, submitMessagesMixin],
  apollo: {
    units: {
      query: Units,
    },
    unitTypes: {
      query: UnitTypes,
    },
  },
  data() {
    return {
      unit: '',
      unitTypeNew: {
        name: '',
      },
      unitTypeEdit: {},
    }
  },
  methods: {
    editUnitType(unitType) {
      this.unitTypeEdit = Object.assign({}, unitType)
      this.edit(unitType.id)
    },
    selectUnit(item) {
      this.unit = item
    },
    async addUnitType() {
      const unit = this.unit
      await this.mutationAction(
        CreateUnitType,
        {
          unitTypeInput: {
            name: this.unitTypeNew.name,
          },
        },
        UnitTypes,
        'Add unitType success',
        'Add unitType error'
      )
      this.unit = unit
    },
    async confirmEdit(unitType) {
      const unit = this.unit
      const editedUnitType = {
        id: unitType.id,
        name: this.unitTypeEdit.name,
      }

      await this.mutationAction(
        UpdateUnitType,
        {
          unitTypeInput: editedUnitType,
        },
        UnitTypes,
        'Add unitType success',
        'Add unitType error'
      )
      this.unit = unit
    },
    async confirmDelete(id) {
      const unit = this.unit

      await this.mutationAction(
        DeleteUnitType,
        {id},
        UnitTypes,
        'Delete unitType success',
        'Delete unitType error'
      )
      this.unit = unit
    },
    async addUnitTypeToUnit(unitType) {
      const {id} = this.unit
      if(!id) {
        this.showSubmitMessage('The "Unit ID" is required. Choose the Unit.', 'error')
        return
      } 
      
      const {
        data: {updateUnit},
      } = await this.mutationAction(
        UpdateUnit,
        {
          unitInput: {
            id,
            unitType: {
              connect: Number(unitType.id),
            },
          },
        },
        Units,
        'Add Unit Type to unit success',
        'Add Unit Type to unit error',
        null,
        null
      )
     
      if (updateUnit) {
        this.unit = updateUnit
      }
    },
    async removeUnitTypeFromUnit() {
      const {id} = this.unit

      const {
        data: {updateUnit},
      } = await this.mutationAction(
        UpdateUnit,
        {
          unitInput: {
            id,
            unitType: {
              disconnect: true,
            },
          },
        },
        Units,
        'Remove Unit Type from unit success',
        'Remove Unit Type from unit error'
      )

      if (updateUnit) {
        this.unit = updateUnit
      }
    },
    async cancelUnitTypeEdit() {
      this.unitTypes = await this.fetchData()
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
.header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;

  .unit-type-desc {
    width: 100%;
  }

  .table-row {
    padding: 12px 0;
  }

  @media screen and (max-width: $xl) {
    flex-direction: column;
  }
}

.col-left {
  @media screen and (max-width: $md) {
    width: 100%;
  }
}

.table-row {
  display: grid;
  align-items: center;
  padding: 6px 10px;
  @media screen and (min-width: $md) {
    grid-template-columns: 250px auto auto;
  }

  @media screen and (max-width: $md) {
    grid-template-columns: 125px auto auto;
  }
  column-gap: 30px;

  &--unit-types {
    @media screen and (min-width: $md) {
      grid-template-columns: 100px 200px auto auto;
    }

    @media screen and (max-width: $md) {
      grid-template-columns: 80px 150px auto 250px;
    }
  }
}

.unit-types-table {
  margin-top: 50px;
}

.icon {
  cursor: pointer;

  &--add {
    grid-column: 4;
    justify-self: end;
  }
}

.button {
  width: 250px;
  justify-self: end;
}

.buttons-area {
  margin-top: 25px;
}

.unit-type-header {
  margin-top: 30px;
  margin-bottom: 25px;
}
</style>
