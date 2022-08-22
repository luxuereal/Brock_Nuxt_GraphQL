<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <div class="tables-wrapper">
        <table class="tables">
          <thead class="tables__thead">
            <tr>
              <th width="50">ID</th>
              <th>Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody v-if="queryData.data" class="tables__body">
            <tr v-for="(role, i) in queryData.data" :key="i">
              <td width="50">{{ role.id }}</td>
              <td class="nowrap">{{ role.name }}</td>
              <td>
                <CustomTableIconsColumn
                  :is-delete-active="isDelete === role.id"
                  @edit="isAdd ? null : editUnit(role)"
                  @delete="isAdd ? null : deleteItem(role.id)"
                  @cancel-delete="cancelDelete"
                  @confirm-delete="confirmDelete(role.id)"
                />
              </td>
            </tr>
          </tbody>
        </table>

        <!-- pagination -->
        <PaginationRow v-if="queryData.data && queryData.data.length">
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

      </div>
    </ValidationObserver>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { mapActions } from 'vuex'
import PageContentWrapper from '../PageContentWrapper.vue'
import RoleList from '../../graphql/queries/roleList.gql'
import CustomTableIconsColumn from '../CustomTableIconsColumn'

// pagination
import PaginationRow from '../PaginationRow.vue'
import PaginationButton from '../PaginationButton.vue'
import PaginationInput from '../PaginationInput.vue'
// pagination

import DeleteRole from '~/graphql/mutations/roles/deleteRole.gql'
import { tableActionsMixin } from '~/mixins/tableActionsMixin'
import { mutationMixin } from '~/mixins/mutationMixin'

// pagination
import { paginatorMixin } from '~/mixins/paginatorMixin'
// pagination

export default {
  name: 'HQRoles',
  components: {
    ValidationObserver,
    CustomTableIconsColumn,
    PageContentWrapper,

    // pagination
    PaginationRow,
    PaginationButton,
    PaginationInput,
    // pagination
  },
  mixins: [tableActionsMixin, mutationMixin, paginatorMixin],
  apollo: {
  },
  data() {
    return {
      // pagination
        query: RoleList,
        queryName: "roleList",
        currentPage: 1,
        queryData: {},
        // pagination
    }
  },
  beforeMount(){
    this.fetchData();
  },
  methods: {
    ...mapActions({
      setUpdateRole: 'roles/setUpdateRole',
      setShowAddRole: 'roles/setShowAddRole',
    }),
    editUnit(role) {
      this.setUpdateRole(role)
      this.setShowAddRole('HQRolesEdit')
    },
    async confirmDelete(id) {
      const res = await this.mutationAction(
        DeleteRole,
        { id },
        null,
        'Delete role success',
        'Delete role error',
        null,
        true
      )

      // pagination
      this.clearTableActionState();
      res !== false && this.goToPage((this.currentPage > 1 && this.queryData.paginatorInfo.count === 1) ? this.currentPage - 1 : null);
      // pagination
    },
  },
}
</script>

<style lang="scss" scoped>
.pagination-row {
  border-top: 1px solid #efefef;
  background: #fff;
}
.tables {
  border-collapse: separate;
  border-spacing: 0;
  &-wrapper {
    border-radius: 8px;
    border: 1px solid #e4e1e1;
    overflow: auto;
  }

  tr {
    vertical-align: top;
  }

  &__thead {
    th {
      background: #f7f7f7;
      color: #303030;
      font-size: 14px;
      font-weight: 600;
      line-height: 13px;
      padding: 19.5px 10px;
      border-bottom: 1px solid #efefef;
      white-space: nowrap;
      text-align: left;
    }
  }

  &__body {
    tr {
      &:not(:last-child) {
        td {
          border-bottom: 1px solid #efefef;
        }
      }
    }

    td {
      padding: 16.5px 10px;
      background: #fff;
      font-size: 14px;
    }
  }

  &__col-5 {
    min-width: 200px;
  }
}

.nowrap {
  white-space: nowrap;
}

.text-center {
  text-align: center;
}

table {
  width: 100%;
}

table td:last-child {
  width: 100px;
}

@media screen and (min-width: $lg) and (max-width: $xxl) {
  .tables {
    &-wrapper {
      width: calc(100vw - 280px);
    }
  }
}
</style>
