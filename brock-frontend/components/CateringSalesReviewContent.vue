<template>
  <PageContentWrapper>
    <LoadingBar v-if="$apollo.loading" />
    <div class="table">
      <CustomTable :w-table="500">
        <template #header>
          <div class="table-row">
            <span>Order Number</span>

            <span>Order Date</span>

            <span>Charge #</span>
            <span></span>
          </div>
        </template>

        <template v-if="cateringOrders" #content>
          <CustomTableRow
            v-for="cateringOrder in cateringOrders"
            :key="cateringOrder.id"
            class="table-row table-content-row"
          >
            <span>{{ cateringOrder.id }}</span>
            <span>{{ formatDateFromAPI(cateringOrder.orderDate) }}</span>
            <span>{{ cateringOrder.chargeNumber }}</span>
            <CustomTableIconsColumn
              :is-edit-active="isEdit === cateringOrder.id"
              :is-delete-active="isDelete === cateringOrder.id"
              :show-edit="canCreate"
              :show-delete="canManage"
              @edit="editCateringOrder(cateringOrder)"
              @delete="deleteItem(cateringOrder.id)"
              @cancel-delete="cancelDelete"
              @confirm-delete="confirmDelete(cateringOrder.id)"
            />
          </CustomTableRow>
        </template>
      </CustomTable>
    </div>
  </PageContentWrapper>
</template>

<script>
import CustomTableRow from './CustomTableRow.vue'
import CustomTable from './CustomTable.vue'
import CateringOrders from '~/graphql/queries/cateringOrders'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import DeleteCateringOrder from '~/graphql/mutations/cateringOrder/deleteCateringOrder'
import { formatDateFromAPI, formatDateAndTimeFromAPI } from '~/helpers/helpers'
import { meMixin } from '~/mixins/meMixin'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";
export default {
  name: 'CateringSalesReviewContent',
  components: { CustomTable, CustomTableRow },
  apollo: {
    cateringOrders: {
      query: CateringOrders,
      fetchPolicy: 'network-only',
      variables: {
        activePeriod: true,
      },
    },
    RolePrivileges: {
      query: RolePrivileges,
    },
  },
  mixins: [tableActionsMixin, mutationMixin, meMixin],
  data () {
    return {
      canCreate: false,
      canManage: false
    }
  },
  mounted () {
    this.canCreate = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'catering-sales') && (privilege.permissionType === 'CREATE')
    }).length
    this.canManage = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'catering-sales') && (privilege.permissionType === 'MODIFY')
    }).length
  },
  methods: {
    formatDateFromAPI,
    formatDateAndTimeFromAPI,
    editCateringOrder(cateringOrder) {
      this.$store.commit('cateringSales/SET_CATERING_ORDER', {
        ...cateringOrder,
        orderDate: this.formatDateFromAPI(cateringOrder.orderDate),
        deliveryDate: this.formatDateAndTimeFromAPI(cateringOrder.deliveryDate),
      })
      this.$store.commit('cateringSales/SET_IS_EDIT', true)
      this.$router.push('/home/catering-sales')
    },
    confirmDelete(id) {
      this.mutationAction(
        DeleteCateringOrder,
        { id },
        CateringOrders,
        'Delete catering order success',
        'Delete catering order error',
        {
          activePeriod: true,
        }
      )
    },
  },
}
</script>

<style lang="scss" scoped>
.table {
  margin-top: 30px;
}

.table-row {
  display: grid;
  align-items: center;
  padding: 12px 0;
  @media screen and (min-width: $md) {
    grid-template-columns: 170px 320px 150px auto;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 120px 120px 120px auto;
  }
  column-gap: 20px;
}

.row {
  padding: 5px 10px;
}
.table-content-row {
  height: 53px;
}

.icon {
  margin-right: 15px;
  cursor: pointer;

  &:last-child {
    margin-right: 0;
  }
}
</style>
