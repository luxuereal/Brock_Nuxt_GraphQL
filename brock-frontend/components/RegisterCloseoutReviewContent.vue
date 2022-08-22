<template>
  <PageContentWrapper>
    <LoadingBar v-if="$apollo.loading" />
    <div v-else class="table table-full">
      <CustomTable :w-table="750">
        <template #header>
          <div class="table-row">
            <span> id </span>

            <span>Close Date</span>

            <span> Unit Number </span>

            <span> Register id </span>
          </div>
        </template>

        <template v-if="registerCloseouts" #content>
          <CustomTableRow
            v-for="registerCloseout in registerCloseouts"
            :key="registerCloseout.id"
            class="table-row table-content-row"
          >
            <span>{{ registerCloseout.id }}</span>

            <span>{{ formatDateFromAPI(registerCloseout.closeDate) }}</span>

            <span v-if="registerCloseout.unit">{{
              registerCloseout.unit.id
            }}</span>

            <span v-if="registerCloseout.register">{{
              registerCloseout.register.id
            }}</span>

            <CustomTableIconsColumn
              :is-edit-active="canCreate && isEdit === registerCloseout.id"
              :is-delete-active="isDelete === registerCloseout.id"
              :show-edit="canCreate"
              :show-delete="canManage"
              @edit="editRegisterCloseoutOrder(registerCloseout)"
              @delete="deleteItem(registerCloseout.id)"
              @cancel-delete="cancelDelete"
              @confirm-delete="confirmDelete(registerCloseout.id)"
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
import RegisterCloseouts from '~/graphql/queries/registerCloseouts'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import { formatDateFromAPI } from '~/helpers/helpers'
import { meMixin } from '~/mixins/meMixin'
import DeleteRegisterCloseout from '~/graphql/mutations/registerCloseout/deleteRegisterCloseout'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";
export default {
  name: 'RegisterCloseoutReviewContent',
  components: {
    CustomTable,
    CustomTableRow,
    CustomTableIconsColumn,
  },
  apollo: {
    registerCloseouts: {
      query: RegisterCloseouts,
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
      return (privilege.slugName === 'close-register') && (privilege.permissionType === 'CREATE')
    }).length
    this.canManage = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'close-register') && (privilege.permissionType === 'MODIFY')
    }).length
  },
  methods: {
    formatDateFromAPI,
    editRegisterCloseoutOrder(closeRegister) {
      this.$store.dispatch('closeRegister/setCloseRegister', {
        ...closeRegister,
      })
      this.$store.commit('closeRegister/SET_IS_EDIT', true)
      this.$router.push('/home/close-register')
    },
    confirmDelete(id) {
      this.mutationAction(
        DeleteRegisterCloseout,
        { id },
        RegisterCloseouts,
        'Delete Register Closeout success',
        'Delete Register Closeout error',
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
  column-gap: 20px;
  padding: 12px 0;
  @media screen and (min-width: $lg) {
    grid-template-columns: 8% 32% 20% 10% 1fr;
  }
  @media screen and (max-width: $lg) {
    grid-template-columns: 80px 220px 120px 120px 90px 1fr;
  }
}

.row {
  padding: 5px 10px;
}

.table-full {
  @media screen and (min-width: $lg) and (max-width: $xxl) {
    width: calc(100vw - 280px);
  }
}

.table-content-row {
  min-height: 53px;
}

.icon {
  margin-right: 15px;
  cursor: pointer;

  &:last-child {
    margin-right: 0;
  }
}
</style>
