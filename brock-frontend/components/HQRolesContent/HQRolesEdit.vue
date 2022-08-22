<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <div class="input-row input-row--offset mb-20">
        <div class="input-col">
          <InputWithTitle>
            <template #title> Role Name</template>

            <template #input>
              <CustomInput 
                v-model="roleName"
                rules="required|max:255"
                name='"Role Name"' />
            </template>
          </InputWithTitle>
        </div>
      </div>
      <div class="input-row input-row--offset mb-20">
        <div class="input-col">
          <InputWithTitle>
            <template #title> Permissions</template>
          </InputWithTitle>

          <table class="permissions-table">
            <thead class="permissions-table__thead">
            <tr>
              <th width="50">Name</th>
              <th width="50">View</th>
              <th width="50">Create</th>
              <th width="50">Modify</th>
            </tr>
            </thead>
            <tbody class="permissions-table__body">
              <tr v-for="(permission, i) in permissions" :key="i">
                <td>{{ permissionNames[i] }}</td>
                <td>
                  <div class="checkbox-hld">
                    <CustomRadioButton
                      v-if="permissionCapabilities[i].isView"
                      :is-active="permission.isView"
                      :value="{menuNum: i, actionType: 'isView', checked: permission.isView}"
                      @set-is-active="updateCheckbox"
                    />
                    <span v-else>-</span>
                  </div>
                </td>
                <td>
                  <div class="checkbox-hld">
                    <CustomRadioButton
                      v-if="permissionCapabilities[i].isCreate"
                      :is-active="permission.isCreate"
                      :value="{menuNum: i, actionType: 'isCreate', checked: permission.isCreate}"
                      @set-is-active="updateCheckbox"
                    />
                    <span v-else>-</span>
                  </div>
                </td>
                <td>
                  <div class="checkbox-hld">
                    <CustomRadioButton
                      v-if="permissionCapabilities[i].isModify"
                      :is-active="permission.isModify"
                      :value="{menuNum: i, actionType: 'isModify', checked: permission.isModify}"
                      @set-is-active="updateCheckbox"
                    />
                    <span v-else>-</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </ValidationObserver>
    <div class="buttons-area">
      <DefaultButton @event="editRole">Edit Role</DefaultButton>

      <DefaultButton button-color-gamma="white" @event="cancelEdit">
        Cancel</DefaultButton
      >
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import {mapActions, mapGetters} from 'vuex'
import PageContentWrapper from '../PageContentWrapper.vue'
import Menus from '../../graphql/queries/menus.gql'
import UpdateRole from '../../graphql/mutations/roles/updateRoles.gql'
import CustomInput from '../CustomInput.vue'
import InputWithTitle from '../InputWithTitle.vue'
import DefaultButton from '../DefaultButton'
import { mutationMixin } from '~/mixins/mutationMixin'

export default {
  name: 'HQRolesEdit',
  components: {
    ValidationObserver,
    CustomInput,
    InputWithTitle,
    PageContentWrapper,
    DefaultButton,
  },
  mixins: [mutationMixin],
  apollo: {
    menus: {
      query: Menus,
    },
  },
  data() {
    return {
      permissions: {},
      permissionNames: {},
      permissionCapabilities: {},
    }
  },
  computed: {
    roleName: {
      get() {
        return this.getUpdateRole.roleName
      },
      set(value) {
        this.$store.commit('roles/SET_UPDATE_ROLE_NAME', value)
      },
    },
    rolePermissions: {
      get() {
        return this.getUpdateRole.permissions
      },
      set(value) {
        this.$store.commit('roles/SET_UPDATE_ROLE_PERMISSIONS', value)
      },
    },
    ...mapGetters({
      getUpdateRole: 'roles/getUpdateRole',
    }),
  },
  watch: {
    menus() {
      this.setupPermissions();
    }
  },
  methods: {
    ...mapActions({
      setShowAddRole: 'roles/setShowAddRole',
    }),
    updateCheckbox(checkboxValue) {
      const obj = this.permissions[checkboxValue.menuNum];

      obj[checkboxValue.actionType] = !checkboxValue.checked

      this.$set(this.permissions, checkboxValue.menuNum, obj);
    },
    async editRole() {
      const obj = {
        roleID: this.getUpdateRole.id,
        roleName: this.roleName,
        permissions: this.permissions,
      }

      const res = await this.mutationAction(
        UpdateRole,
        {
          roleInput: obj,
        },
        null,
        'Edit role success',
        'Edit role error',
        null,
        true
      )

      res !== false && this.setShowAddRole('HQRoles')
    },
    cancelEdit() {
      this.setShowAddRole('HQRoles')
    },
    setupPermissions() {
      this.permissions = [];

      if (!this.menus || !this.rolePermissions)
        return;

      this.menus.forEach((item, i) => {
        this.permissionCapabilities[i] = {
          isView: item.hasViewCapability,
          isCreate: item.hasCreateCapability,
          isModify: item.hasManageCapability,
        }

        const permissionFilter = this.rolePermissions.filter((rolePermission) => {
          return item.id === rolePermission.menu.id;
        });

        const currentPermission = permissionFilter ? permissionFilter[0] : null;

        this.permissions[i] = {
          menuID: item.id,
          isView: this.permissionCapabilities[i].isView ? (currentPermission ? currentPermission.isView : false) : true,
          isCreate: this.permissionCapabilities[i].isCreate ? (currentPermission ? currentPermission.isCreate : false) : true,
          isModify: this.permissionCapabilities[i].isModify ? (currentPermission ? currentPermission.isModify : false) : true,
        }

        this.permissionNames[i] = item.name;
      });
    },
  },
}
</script>
<style lang="scss">
.input {
  &-row--offset {
    display: flex;
    margin: 0 -15px;
  }

  &-col {
    max-width: 480px;
    min-width: 240px;
    padding: 0 15px;
  }
}

.mb-20 {
  margin-bottom: 20px;
}

.permissions-table {
  border-collapse: separate;
  border-spacing: 0;

  .permissions-table-wrapper {
    border-radius: 8px;
    border: 1px solid #efefef;
    overflow: auto;
  }

  tr {
    vertical-align: top;
  }

  .permissions-table__thead {
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

  .permissions-table__body {
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

    td:first-child {
      width: 400px;
    }
  }

  td:not(:first-child),
  th:not(:first-child) {
    text-align: center;
  }

  td:not(:first-child) .checkbox-hld {
    display: flex;
    align-items: center;
    justify-content: center;

    .caption {
      display: none;
    }
  }

  .permissions-table__col-5 {
    min-width: 200px;
  }
}
</style>
