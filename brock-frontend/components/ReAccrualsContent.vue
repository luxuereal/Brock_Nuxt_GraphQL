<template>
  <PageContentWrapper>
    <LoadingBar v-if="$apollo.loading" />
    <div class="table">
      <CustomTable class="" :w-table="750">
        <template #header>
          <div class="table-row">
            <span> GL </span>

            <span> GL Name </span>

            <span> Amount </span>

            <span> Vendor </span>

            <span>Original Expense Date</span>

            <span> Comment </span>
          </div>
        </template>

        <template v-if="reAccruals" #content>
          <CustomTableRow
            v-for="reAccrual in unitsReAccruals"
            :key="reAccrual.id"
            class="table-row table-content-row"
          >
            <span> {{ reAccrual.glAccount.id }} </span>

            <span v-if="reAccrual.glAccount">
              {{ reAccrual.glAccount.name }}
            </span>
            <span v-else></span>

            <span> {{ Number(reAccrual.amount).toFixed(2) }} </span>

            <span v-if="reAccrual.vendor"> {{ reAccrual.vendor.name }} </span>
            <span v-else></span>

            <span> {{ formatDateFromAPI(reAccrual.expenseDate) }}</span>

            <span> {{ reAccrual.comments }} </span>

            <DefaultButton v-if="canManage" @event="ReAccrual(reAccrual.id)">
              Re-Accrue
            </DefaultButton>
          </CustomTableRow>
        </template>
      </CustomTable>
    </div>
  </PageContentWrapper>
</template>

<script>
import CustomTable from './CustomTable.vue'
import CustomTableRow from './CustomTableRow.vue'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'
import { formatDateFromAPI } from '~/helpers/helpers'
import DeleteExpense from '~/graphql/mutations/expense/deleteExpense.gql'
import { meMixin } from '~/mixins/meMixin'
import ExpenseTypes from '~/graphql/queries/expenseTypes.gql'
import ReAccruals from '~/graphql/queries/reAccruals.gql'
import reAccrual from '~/graphql/mutations/expense/reAccrual.gql'
import RolePrivileges from "~/graphql/queries/RolePrivileges.gql";
export default {
  name: 'ReAccrualsContent',
  components: { CustomTable, CustomTableRow },
  apollo: {
    reAccruals: {
      query: ReAccruals,
      fetchPolicy: 'network-only',
    },
    expenseTypes: {
      query: ExpenseTypes,
    },
    RolePrivileges: {
      query: RolePrivileges,
    },
  },
  mixins: [tableActionsMixin, mutationMixin, meMixin],
  data () {
    return {
      canManage: false
    }
  },
  computed: {
    unitsReAccruals() {
      return this.reAccruals.filter(
        (reAccrual) => reAccrual.unit.id === this.selectedUnit.id
      )
    },
  },
  mounted () {
    this.canManage = !!this.RolePrivileges.filter(privilege => {
      return (privilege.slugName === 'reaccruals') && (privilege.permissionType === 'CREATE')
    }).length
  },
  methods: {
    formatDateFromAPI,
    setExpensesType(expenseType) {
      this.expenseType = expenseType
    },
    selectPeriodEndDate(item) {
      this.periodEndDate = item
    },
    confirmDelete(id) {
      this.mutationAction(
        DeleteExpense,
        { id },
        ReAccruals,
        'Delete reAccrual success',
        'Delete reAccrual error',
        {
          activePeriod: true,
        }
      )
    },
    async ReAccrual(id) {
      const res = await this.mutationAction(
        reAccrual,
        {
          id,
        },
        ReAccruals,
        'ReAccrual success',
        'ReAccrual error',
        {
          activePeriod: true,
        }
      )
      if (res) {
        this.$router.push('/home/reaccruals')
      }
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
  @media screen and (min-width: $xl) {
    grid-template-columns: 5% 10% 12% 12% 15% 18% 1fr;
  }
  @media screen and (min-width: $lg) and (max-width: $xl) {
    grid-template-columns: 5% 10% 8% 12% 15% 18% 1fr;
  }
  @media screen and (min-width: $md) and (max-width: $lg) {
    grid-template-columns: 5% 10% 8% 12% 15% 18% 1fr;
  }
  @media screen and (max-width: $md) {
    grid-template-columns: 80px 120px 120px 120px 90px 68px 1fr;
    column-gap: 10px;
  }
  column-gap: 20px;
}

.row {
  padding: 16.5px 10px;
}

.table-content-row {
  height: 60px;
}

.icon {
  margin-right: 15px;
  cursor: pointer;

  &:last-child {
    margin-right: 0;
  }
}
</style>
