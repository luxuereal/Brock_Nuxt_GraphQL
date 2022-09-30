<template>
  <div>
    <ValidationObserver ref="form" v-slot="{ invalid }">
      <InputRow>
        <InputWithTitle>
          <template #title> Unit Number </template>

          <template #input>
            <CustomInput v-model="code" rules="required|max:255" name="unit-code" />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Name </template>

          <template #input>
            <CustomInput v-model="name" rules="required|max:255" name="unit-name" />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Street Address </template>

          <template #input>
            <CustomInput v-model="address" rules="required|max:255" name="unit-address" />
          </template>
        </InputWithTitle>

        <InputWithTitle has-select>
          <template #title> State </template>

          <template #input>
            <CustomSelect
              v-if="states"
              :options="states"
              :selected-item="unitID && unit.city && unit.city.state"
              select-by="code"
              @input="selectState"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle has-select>
          <template #title> City </template>

          <template #input>
            <CustomSelect
              v-if="state"
              :options="state.cities"
              :selected-item="unitID && unit.city"
              select-by="name"
              @input="selectCity"
            />
          </template>
        </InputWithTitle>
        <InputWithTitle has-select>
          <template #title> County </template>

          <template #input>
            <CustomSelect
              v-if="state"
              :options="state.counties"
              :selected-item="unitID && unit.county"
              select-by="name"
              @input="selectCounty"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Zip Code </template>

          <template #input>
            <CustomInput v-model="zip" rules="required|max:255" name="unit-zip" />
          </template>
        </InputWithTitle>
        <InputWithTitle has-select>
          <template #title> District </template>

          <template #input>
            <CustomSelect
              v-if="districts"
              :options="districts"
              :selected-item="unitID && unit.district"
              select-by="name"
              @input="selectDistrict"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Population </template>

          <template #input>
            <CustomInput
              v-model.number="population"
              rules="required"
              type="number"
              name="unit-population"
            />
          </template>
        </InputWithTitle>
        <InputWithTitle>
          <template #title>Preferred Vendor #</template>

          <template #input>
            <CustomInput v-model="sysco" rules="max:255" name="unit-sysco" />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Mgr First Name </template>

          <template #input>
            <CustomInput v-model="managerFirstName" rules="max:255" name="unit-first-name" />
          </template>
        </InputWithTitle>
        <InputWithTitle>
          <template #title> Mgr Last Name </template>

          <template #input>
            <CustomInput v-model="managerLastName" rules="max:255" name="unit-last-name" />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title> Password </template>

          <template #input>
            <CustomInput
              v-model="payrollPassword"
              type="password"
              name="unit-password"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title> Email </template>

          <template #input>
            <CustomInput
              v-model="emailAccount"
              rules="email|required|max:255"
              type="email"
              name="unit-email"
            />
          </template>
        </InputWithTitle>
      </InputRow>
      <InputRow>
        <InputWithTitle has-select>
          <template #title>Location Manager</template>

          <template #input>
            <CustomSelect
              v-if="users"
              :options="usersIsNotAdmin"
              select-by="email"
              @input="selectUser"
            />
          </template>
        </InputWithTitle>
        <InputWithTitle v-if="!unitID" has-select>
          <template #title> Start Period </template>

          <template #input>
            <CustomSelect
              v-if="PeriodsActive"
              :options="PeriodsActive"
              :selected-item="unitID && unit.startPeriod.periodEnd"
              select-by="periodEnd"
              @input="selectPeriod"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <div class="buttons-area">
        <DefaultButton
          button-color-gamma="red"
          :disabled="invalid"
          @event="nextTab"
        >
          Continue
        </DefaultButton>

        <DefaultButton button-color-gamma="white" @event="cancel">
          Cancel
        </DefaultButton>
      </div>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { formMixin } from '../mixins/formMixin'
import { unitMaintenanceMixin } from '../mixins/unitMaintenanceMixin'
import Districts from '../graphql/queries/districts.gql'
import States from '../graphql/queries/states.gql'
import Users from '../graphql/queries/users.gql'
import PeriodsActive from '../graphql/queries/periodsActive.gql'
import InputRow from './InputRow.vue'
import CustomInput from './CustomInput.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomSelect from './CustomSelect.vue'
import { tabsViewMixin } from '~/mixins/tabsViewMixin'
export default {
  name: 'HQUnitMaintenanceDetails',
  components: {
    ValidationObserver,
    InputRow,
    InputWithTitle,
    CustomInput,
    CustomSelect,
  },
  mixins: [formMixin, unitMaintenanceMixin, tabsViewMixin],
  apollo: {
    districts: {
      query: Districts,
    },
    states: {
      query: States,
    },
    users: {
      query: Users,
    },
    PeriodsActive: {
      query: PeriodsActive,
    },
  },
  computed: {
    usersIsNotAdmin() {
      return this.users.filter((user) => !user.isAdmin)
    },
    code: {
      get() {
        return this.unit.code
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_NUM', value)
      },
    },
    address: {
      get() {
        return this.unit.address
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_STREET_ADDRESS', value)
      },
    },
    name: {
      get() {
        return this.unit.name
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_NAME', value)
      },
    },
    city: {
      get() {
        return this.unit.city
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_CITY', value)
      },
    },
    district: {
      get() {
        return this.unit.district
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_DISTRICT', value)
      },
    },
    county: {
      get() {
        return this.unit.county
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_COUNTY', value)
      },
    },
    startPeriod: {
      get() {
        return this.unit.startPeriod
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_START_PERIOD', value)
      },
    },
    population: {
      get() {
        return this.unit.population
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_POPULATION', value)
      },
    },
    state: {
      get() {
        return this.unit.state
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_STATE', value)
      },
    },
    managerFirstName: {
      get() {
        return this.unit.managerFirstName
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_MGR_FIRST_NAME', value)
      },
    },
    zip: {
      get() {
        return this.unit.zip
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_MGR_ZIP_CODE', value)
      },
    },
    managerLastName: {
      get() {
        return this.unit.managerLastName
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_MGR_LAST_NAME', value)
      },
    },
    payrollPassword: {
      get() {
        return this.unit.payrollPassword
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_PASSWORD', value)
      },
    },
    emailAccount: {
      get() {
        return this.unit.emailAccount
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_EMAIL', value)
      },
    },
    sysco: {
      get() {
        return this.unit.sysco
      },
      set(value) {
        this.$store.commit('unitMaintenance/SET_UNIT_SYSCO', value)
      },
    },
  },
  watch: {
    activeValidate() {
      if(this.activeValidate === 'Details') this.$refs.form.validate()
    }
  },
  mounted() {
    // this.$store.commit('tabsView/SET_ALLOW_SWITCH', false)
  },
  methods: {
    selectDistrict(district) {
      this.district = district
    },
    selectCounty(county) {
      this.county = county
    },
    selectPeriod(period) {
      this.startPeriod = period
    },
    selectState(state) {
      this.state = state
    },
    selectCity(city) {
      this.city = city
    },
    selectUser(user) {
      this.$store.commit('unitMaintenance/SET_UNIT_USERS', user)
    },
  },
}
</script>

<style lang="scss" scoped>
.buttons-area {
  display: flex;
  margin-top: 50px;

  button:first-child {
    margin-right: 11px;
  }
}
</style>
