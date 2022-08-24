<template>
  <PageContentWrapper>
    
    <InputRow>
      <InputWithTitle has-select>
        <template #title> Unit </template>

        <template #input>
          <multiselect
            v-if="units"
            v-model="unit"
            :options="units"
            :custom-label="nameWithId"
            placeholder="-- Select --"
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

    <LoadingBar v-if="$apollo.loading" />
    <CustomTablesArea v-else>
      <CustomTable v-if="vendors" class="table table--left" :w-table="580">
        <template #header>
          <div class="table-row">
            <span> Vendor Name </span>

            <span> Vendor Code </span>

            <span> Vendor Term</span>

            <span> Vendor to Unit </span>
          </div>
        </template>

        <template #content>
          <CustomTableRow
            v-for="vendor in vendors"
            :key="vendor.id"
            class="table-row"
          >
            <span>
              {{ vendor.name }}
            </span>

            <span>
              {{ vendor.code }}
            </span>

            <span v-if="vendor.terms">
              {{ vendor.terms.map((vendor) => vendor.name).join(', ') }}
            </span>

            <DefaultButton
              @event="
                unit.vendors.find((item) => item.id === vendor.id)
                  ? removeVendorFromUnit(vendor)
                  : addVendorToUnit(vendor)
              "
            >
              {{
                unit.vendors &&
                unit.vendors.find((item) => item.id === vendor.id)
                  ? 'REMOVE'
                  : 'ADD'
              }}
            </DefaultButton>
          </CustomTableRow>
        </template>
      </CustomTable>

      <CustomTable
        v-if="unit && unit.vendors"
        class="table table--right"
        :w-table="350"
      >
        <template #header>
          <div class="table-row table-row--unit">
            <span> Vendor Name </span>

            <span> Vendor Code </span>

            <span> Vendor Term</span>
          </div>
        </template>

        <template #content>
          <CustomTableRow
            v-for="vendor in unit.vendors"
            :key="vendor.id"
            class="table-row table-row--unit"
          >
            <span>
              {{ vendor.name }}
            </span>

            <span>
              {{ vendor.code }}
            </span>

            <span v-if="vendor.terms">
              {{ vendor.terms.map((vendor) => vendor.name).join(', ') }}
            </span>
          </CustomTableRow>
        </template>
      </CustomTable>
    </CustomTablesArea>
  </PageContentWrapper>
</template>

<script>
import Vendors from '../graphql/queries/vendors.gql'
import Units from '../graphql/queries/units.gql'
import UpdateUnit from '../graphql/mutations/unit/updateUnit.gql'
import PageContentWrapper from './PageContentWrapper.vue'
import DefaultButton from './DefaultButton.vue'
import CustomTablesArea from './CustomTablesArea.vue'
import { mutationMixin } from '~/mixins/mutationMixin'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { multiselectMixin } from '~/mixins/multiselectMixin'
export default {
  name: 'HQUnitVendorContent',
  components: { PageContentWrapper, DefaultButton, CustomTablesArea },
  apollo: {
    units: {
      query: Units,
    },
  },
  mixins: [mutationMixin, tableActionsMixin, multiselectMixin],
  props: {
    search: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      unit: '',

      vendors: {},
      queryVariable: {
        search: '',
      },
      timeout: null
    }
  },
  watch: {
    search() {
      clearTimeout(this.timeout)
      this.timeout = setTimeout(() => this.fetchData(), 500)
    }
  },
  beforeMount() {
    this.fetchData()
  },
  methods: {
    async fetchData() {
      
      if(this.search !== '') this.queryVariable.search = '%' + this.search + '%';
      else this.queryVariable.search = '%';

      const queryData = await this.$apollo.query({
          query: Vendors,
          fetchPolicy: 'network-only',
          variables: this.queryVariable,
      });
      this.vendors = queryData.data.vendors
    },
    async addVendorToUnit(vendor) {
      const vendors = this.vendors

      const { id } = this.unit

      const {
        data: { updateUnit },
      } = await this.mutationAction(
        UpdateUnit,
        {
          unitInput: {
            id,
            vendors: {
              sync: [
                ...this.unit.vendors.map((vendor) => vendor.id),
                vendor.id,
              ],
            },
          },
        },
        Units,
        'Add vendor to unit success',
        'Add vendor to unit error'
      )
 
      this.vendors = vendors

      if (updateUnit) {
        this.unit = updateUnit
      }
    },
    async removeVendorFromUnit(vendor) {
      const vendors = this.vendors

      const { id } = this.unit

      const {
        data: { updateUnit },
      } = await this.mutationAction(
        UpdateUnit,
        {
          unitInput: {
            id,
            vendors: {
              disconnect: [Number(vendor.id)],
            },
          },
        },
        Units,
        'Remove vendor from unit success',
        'Remove vendor from unit error'
      )

      this.vendors = vendors

      if (updateUnit) {
        this.unit = updateUnit
      }
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
.table {
  width: fit-content;
  margin-bottom: 20px;
}

.table-row {
  display: grid;
  align-items: center;
  padding: 12px 0;

  @media screen and (min-width: $lg) {
    grid-template-columns: 100px 100px 180px 220px;
  }
  @media screen and (max-width: $lg) {
    grid-template-columns: 100px repeat(2, 26%) auto;
  }
  column-gap: 20px;

  &--unit {
    @media screen and (min-width: $lg) {
      grid-template-columns: 100px 100px calc(100% - 240px);
    }
    @media screen and (max-width: $lg) {
      grid-template-columns: 100px repeat(2, 26%);
    }
  }
}

.row {
  padding: 6px 10px;

  span {
    min-height: 41px;
    display: flex;
    align-items: center;
  }
}

.table {
  &--right {
    @media screen and (min-width: $xl) {
      width: 40% !important;
    }
    @media screen and (max-width: $xl) {
      width: 100% !important;
    }
  }
  &--left {
    @media screen and (min-width: $xl) {
      width: calc(60% - 20px) !important;
    }
    @media screen and (max-width: $xl) {
      width: 100% !important;
      margin: 0 !important;
    }
  }

  .table-content {
    .content {
      @media screen and (min-width: $xl) {
        .button {
          width: calc(100% - 20px);
        }
      }
    }
  }
}
</style>
