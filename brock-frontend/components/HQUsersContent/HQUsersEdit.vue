<template>
  <PageContentWrapper>
    <ValidationObserver ref="form">
      <LoadingBar v-if="$apollo.loading" />
      <div class="input-row input-row--offset mb-20">
        <div class="input-col">
          <InputWithTitle>
            <template #title> First Name</template>

            <template #input>
              <CustomInput
                v-model="firstName"
                rules="required|max:255"
                name='"User First Name"'
                />
            </template>
          </InputWithTitle>
        </div>
        <div class="input-col">
          <InputWithTitle>
            <template #title> Last Name</template>

            <template #input>
              <CustomInput v-model="lastName" />
            </template>
          </InputWithTitle>
        </div>
      </div>
      <div class="input-row input-row--offset mb-20">
        <div class="input-col">
          <InputWithTitle>
            <template #title> Email</template>

            <template #input>
              <CustomInput 
                v-model="email" 
                rules="required|email|max:255"
                name='"User Email"'
              />
            </template>
          </InputWithTitle>
        </div>
        <div class="input-col">
          <InputWithTitle>
            <template #title> Password</template>

            <template #input>
              <CustomInput 
                v-model="password"
                name='"User Password"'
              />
            </template>
          </InputWithTitle>
        </div>
      </div>
      <div class="input-row input-row--offset mb-20">
        <div class="input-col mb-20">
          <InputWithTitle class="mb-20">
            <template #title> Is Admin</template>
            <template #input>
              <CustomRadioButton
                :is-active="isAdmin"
                @set-is-active="setIsAdmin"
              />
            </template>
          </InputWithTitle>
          <InputWithTitle>
            <template #title> Is Active</template>
            <template #input>
              <CustomRadioButton
                :is-active="isActive"
                @set-is-active="setIsActive"
              />
            </template>
          </InputWithTitle>
        </div>
        <div v-if="!isAdmin" class="input-col mb-20">
          <InputWithTitle class="mb-20" has-select>
            <template #title> Role </template>

            <template #input>
              <CustomSelect
                v-if="roles"
                :options="roles"
                :selected-item="role"
                select-by="name"
                @input="selectRole"
              />
            </template>
          </InputWithTitle>
        </div>
      </div>
      <div v-if="!isAdmin" class="input-row input-row--offset mb-20">
        <div class="input-col">
          <h5 class="title">Units access</h5>

          <multiselect
            v-if="units && !isAdmin"
            v-model="unit"
            :options="units"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :custom-label="nameWithId"
            :preserve-search="true"
            placeholder="-- Select --"
            label="name"
            track-by="name"
            :preselect-first="false"
          >
          </multiselect>
        </div>
      </div>
    </ValidationObserver>
    <div class="buttons-area">
      <DefaultButton @event="editUser"> Edit User</DefaultButton>

      <DefaultButton button-color-gamma="white" @event="cancelEdit">
        Cancel</DefaultButton
      >
    </div>
  </PageContentWrapper>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { mapActions, mapGetters } from 'vuex'
import Multiselect from 'vue-multiselect'
import Units from '../../graphql/queries/units.gql'
import Roles from '../../graphql/queries/roles.gql'
import UpdateUser from '~/graphql/mutations/users/updateUsers.gql'
import { mutationMixin } from '~/mixins/mutationMixin'

export default {
  name: 'HQUsersContent',
  components: {
    ValidationObserver,
    Multiselect,
  },
  mixins: [mutationMixin],
  apollo: {
    units: {
      query: Units,
    },
    roles: {
      query: Roles,
    },
  },
  data() {
    return {
      password: '',
    }
  },
  computed: {
    firstName: {
      get() {
        return this.getUpdateUser.firstName
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_FIRSTNAME', value)
      },
    },
    lastName: {
      get() {
        return this.getUpdateUser.lastName
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_LASTNAME', value)
      },
    },
    email: {
      get() {
        return this.getUpdateUser.email
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_EMAIL', value)
      },
    },
    unit: {
      get() {
        return this.getUpdateUser.unit
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_UNIT', value)
      },
    },
    isAdmin: {
      get() {
        return this.getUpdateUser.isAdmin
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_IS_ADMIN', value)
      },
    },
    isActive: {
      get() {
        return this.getUpdateUser.isActive
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_IS_ACTIVE', value)
      },
    },
    role: {
      get() {
        return this.getUpdateUser.role
      },
      set(value) {
        this.$store.commit('users/SET_UPDATE_USER_ROLE', value)
      },
    },
    ...mapGetters({
      getUpdateUser: 'users/getUpdateUser',
    }),
  },
  methods: {
    ...mapActions({
      setShowAddUser: 'users/setShowAddUser',
    }),
    nameWithId({ name, code, id}) {
      if(code === undefined) {
        return `${id} — ${name}`
      }else {
        return `${code} — ${name}`
      }
    },
    setIsAdmin(isCheck) {
      if (isCheck) {
        isCheck.isAdmin = !isCheck.isAdmin
      } else {
        this.isAdmin = !this.isAdmin
      }
    },
    setIsActive(isCheck) {
      if (isCheck) {
        isCheck.isActive = !isCheck.isActive
      } else {
        this.isActive = !this.isActive
      }
    },
    selectRole(role) {
      this.role = role
    },
    async editUser() {
      const obj = {
        id: this.getUpdateUser.id,
        firstName: this.firstName,
        lastName: this.lastName,
        email: this.email,
        isAdmin: this.isAdmin,
        isActive: this.isActive,
        roleID: this.role ? this.role.id : null,
        ...(!this.isAdmin && this.unit && {
          units: {
            sync: this.unit.map((unit) => unit.id),
          },
        }),
      }

      const objPass = { password: this.password }
      const objEdit = this.password.length > 0 ? { ...obj, ...objPass } : obj

      const res = await this.mutationAction(
        UpdateUser,
        {
          userInput: objEdit,
        },
        null,
        'Edit user success',
        'Edit user error',
        null,
        true
      )
      
      res !== false && this.setShowAddUser('HQUsers')
    },
    cancelEdit() {
      this.setShowAddUser('HQUsers')
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
    max-width: 480px;
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

.input-col .title {
  margin-bottom: 4px;
  font-size: $font-xs;
  line-height: 16px;
  font-weight: 600;
  color: $grey;
}
</style>
