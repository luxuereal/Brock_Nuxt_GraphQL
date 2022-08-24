<template>
  <PageContentWrapper>
    <LoadingBar v-if="$apollo.loading" />
    <div v-else class="table table-full">
      <CustomTable class="table-purchases" :w-table="740">
        <template #header>
          <div class="table-row">
            <span> PO </span>

            <span> Purchase Date </span>

            <span> Invoice Num </span>

            <span> Vendor Num </span>

            <span> Total </span>
            <span></span>
          </div>
        </template>

        <template v-if="purchases" #content>
          <CustomTableRow
            v-for="purchase in purchases"
            :key="purchase.id"
            class="table-row table-content-row"
          >
            <span>{{ purchase.id }}</span>

            <span>{{ formatDateFromAPI(purchase.date) }}</span>

            <span>{{ purchase.number }}</span>

            <span>{{ purchase.vendor.code }}</span>

            <span
              >${{
                purchase.items.reduce((prev, current) => {
                  return Number(prev) + Number(current.amount)
                }, 0)
              }}</span
            >

            <CustomTableIconsColumn
              :is-edit-active="isEdit === purchase.id"
              :is-delete-active="isDelete === purchase.id"
              :show-edit="canCreate"
              :show-delete="canManage"
              @edit="editPurchaseOrder(purchase)"
              @delete="deleteItem(purchase.id)"
              @cancel-delete="cancelDelete"
              @confirm-delete="confirmDelete(purchase.id)"
            />
          </CustomTableRow>
        </template>
      </CustomTable>
    </div>
  </PageContentWrapper>
</template>

<script>
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import CustomTableIconsColumn from './CustomTableIconsColumn.vue'
import Purchases from '~/graphql/queries/purchases.gql'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import { formatDateFromAPI } from '~/helpers/helpers'
import DeletePurchase from '~/graphql/mutations/purchaseOrder/deletePurchase'
import { meMixin } from '~/mixins/meMixin'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";

export default {
  name: 'WeeklyPurchasesContent',
  components: {
    CustomTable,
    CustomTableRow,
    CustomTableIconsColumn,
  },
  apollo: {
    purchases: {
      query: Purchases,
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
      return (privilege.slugName === 'purchase-orders') && (privilege.permissionType === 'CREATE')
    }).length
    this.canManage = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'purchase-orders') && (privilege.permissionType === 'MODIFY')
    }).length
  },
  methods: {
    formatDateFromAPI,
    editPurchaseOrder(purchase) {
      this.$store.commit('purchaseOrders/SET_PURCHASE_ORDER', {
        ...purchase,
        purchaseDate: this.formatDateFromAPI(purchase.date),
        invoiceNumber: purchase.number,
      })
      this.$store.commit('purchaseOrders/SET_IS_EDIT', true)
      this.$router.push('/home/purchase-orders')
    },
    confirmDelete(id) {
      this.mutationAction(
        DeletePurchase,
        { id },
        Purchases,
        'Delete purchase success',
        'Delete purchase error',
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
  @media screen and (min-width: $lg) {
    grid-template-columns: 8% 37% 15% 10% 10% 10%;
  }
  @media screen and (min-width: $md) and (max-width: $lg) {
    grid-template-columns: 8% 34% 15% 10% 10% 10%;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 80px 120px 120px 120px 90px 68px;
  }
  column-gap: 20px;
}

.table-full {
  @media screen and (min-width: $lg) and (max-width: $xxl) {
    width: calc(100vw - 280px);
  }
}

.table-content-row {
  height: 53px;
  padding: 5px 10px;
}

.icon {
  margin-right: 15px;
  cursor: pointer;

  &:last-child {
    margin-right: 0;
  }
}
</style>
