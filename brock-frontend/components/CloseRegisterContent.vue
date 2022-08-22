<template>
  <div>
    <PageSubheader>
      <PageSubheaderItem>
        <template v-if="me" #title>{{
          me.selectedUnit && me.selectedUnit.id
        }}</template>

        <template #subtitle>Unit Number</template>
      </PageSubheaderItem>

      <PageSubheaderItem>
        <template #title>{{
          me.selectedUnit.activePeriod &&
          formatDateFromAPI(me.selectedUnit.activePeriod.periodEnd)
        }}</template>

        <template #subtitle>Period End</template>
      </PageSubheaderItem>

      <PageSubheaderItem>
        <template #title>{{
          getIsEdit ? getRegister.id : register.id
        }}</template>

        <template #subtitle>Register id</template>
      </PageSubheaderItem>

      <PageSubheaderItem>
        <template #title>{{
          getIsEdit ? getRegister.name : register.name
        }}</template>

        <template #subtitle>Register Name</template>
      </PageSubheaderItem>

      <PageSubheaderItem>
        <template #title>${{ parseFloat(getTotalDailyDeposit).toFixed(2) }}</template>

        <template #subtitle>Total Daily Deposit</template>
      </PageSubheaderItem>

      <PageSubheaderItem>
        <template #title>{{
          getIsEdit
            ? formatDateFromAPI(getCloseDate)
            : formatDateForCloseRegister(new Date())
        }}</template>

        <template #subtitle>Close Date</template>
      </PageSubheaderItem>
    </PageSubheader>

    <PageContentWrapper>
      <h2 v-if="unitRegisters && !unitRegisters.length">
        Please, add register to the unit
      </h2>
      <div v-else class="content">
        <div class="inputs-block">
          <h2 class="title">Select Register To Close</h2>

          <InputRow>
            <InputWithTitle has-select>
              <template #title>Register ID</template>

              <template v-if="registers" #input>
                <CustomSelect
                  :options="unitRegisters"
                  select-by="id"
                  :disabled="getIsEdit"
                  :selected-item="register"
                  @input="selectRegister"
                />
              </template>
            </InputWithTitle>

            <InputWithTitle has-select>
              <template #title>Register Name</template>

              <template v-if="registers" #input>
                <CustomSelect
                  :options="unitRegisters"
                  :disabled="getIsEdit"
                  :selected-item="register"
                  @input="selectRegister"
                />
              </template>
            </InputWithTitle>
          </InputRow>

          <TabsView
            :tabs-headers="tabsHeaders"
            :tabs="tabs"
            ></TabsView>
        </div>
        <div class="total">
          <div class="total-section">
            <div class="total-row">
              <h5 class="total-caption">Total Net Sales</h5>

              <span class="total-amount">${{ getTotalNetSale ? parseFloat(getTotalNetSale).toFixed(2) : '0.00' }}</span>
            </div>

            <div class="total-row">
              <h5 class="total-caption">- Charge</h5>

              <span class="total-amount">${{ getCharge ? parseFloat(getCharge).toFixed(2) : '0.00' }}</span>
            </div>
          </div>

          <div class="divider"></div>

          <div class="total-section">
            <div class="total-row">
              <h5 class="total-caption">Cash Total</h5>

              <span class="total-amount">${{ getCashTotal ? parseFloat(getCashTotal).toFixed(2) : '0.00' }}</span>
            </div>

            <div class="total-row">
              <h5 class="total-caption">+ Cash Tax</h5>

              <span class="total-amount">${{ getCashTax ? parseFloat(getCashTax).toFixed(2) : '0.00' }}</span>
            </div>

            <div class="total-row">
              <h5 class="total-caption">- Petty Cash</h5>

              <span class="total-amount">${{ getPettyCash ? parseFloat(getPettyCash).toFixed(2) : '0.00' }}</span>
            </div>
          </div>

          <div class="divider"></div>

          <div class="total-section">
            <div class="total-row">
              <h5 class="total-caption">Calced Deposit</h5>

              <span class="total-amount">${{ getCalcedDeposit ? parseFloat(getCalcedDeposit).toFixed(2) : '0.00' }}</span>
            </div>

            <div class="total-row">
              <h5 class="total-caption">Actual Deposit</h5>

              <span class="total-amount">${{ getActualDeposit ? parseFloat(getActualDeposit).toFixed(2) : '0.00' }}</span>
            </div>
          </div>

          <div class="divider"></div>

          <div class="total-section">
            <div class="total-row">
              <h5 class="total-caption">Over/Short</h5>

              <span class="total-amount">${{ getOverShort ? parseFloat(getOverShort).toFixed(2) : '0.00' }}</span>
            </div>
          </div>
        </div>
      </div>
    </PageContentWrapper>
  </div>
</template>

<script>
/* eslint-disable vue/no-unused-components */
import PageSubheader from './PageSubheader.vue'
import PageSubheaderItem from './PageSubheaderItem.vue'
import InputWithTitle from './InputWithTitle.vue'
import InputRow from './InputRow.vue'
import CustomSelect from './CustomSelect.vue'
import TabsView from './TabsView.vue'
import SalesInfo from './SalesInfo.vue'
import ClosRegisterPettyCash from './CloseRegisterPettyCash.vue'
import FinishCloseout from './FinishCloseout.vue'
import PageContentWrapper from './PageContentWrapper.vue'
import CloseRegisterFinishCloseout from './CloseRegisterFinishCloseout'
import {
  formatDateForCloseRegister,
  formatDateFromAPI,
} from '~/helpers/helpers'
import { CLOSE_REGISTER } from '~/constants/closeRegister'
import Registers from '~/graphql/queries/registers.gql'
import Me from '~/graphql/queries/me.query.gql'
import { closeRegisterMixin } from '~/mixins/closeRegisterMixin'
import { meMixin } from '~/mixins/meMixin'
export default {
  name: 'CloseRegisterContent',
  components: {
    PageSubheader,
    PageSubheaderItem,
    InputWithTitle,
    InputRow,
    CustomSelect,
    TabsView,
    SalesInfo,
    ClosRegisterPettyCash,
    FinishCloseout,
    PageContentWrapper,
  },
  mixins: [closeRegisterMixin, meMixin],
  apollo: {
    registers: {
      query: Registers,
    },
    me: {
      query: Me,
    },
  },
  data() {
    return {
      tabsHeaders: ['Sales Info', 'Petty Cash', 'Finish Closeout'],
      tabs: [SalesInfo, ClosRegisterPettyCash, CloseRegisterFinishCloseout],
      register: '',
    }
  },
  computed: {
    unitRegisters() {
      return (
        this.registers &&
        this.registers.filter(
          (register) => register.unit?.id === this.me.selectedUnit.id
        )
      )
    },
  },
  mounted() {
    this.$store.dispatch('closeRegister/calculate', {
      unitId: +this.selectedUnit.id,
      periodId: +this.selectedUnit.activePeriod.id,
    })
  },
  destroyed() {
    this.$store.commit('closeRegister/SET_IS_EDIT', false)
    this.$store.commit('closeRegister/SET_CLOSE_REGISTER', CLOSE_REGISTER)
  },
  methods: {
    formatDateForCloseRegister,
    formatDateFromAPI,
    selectRegister(register) {
      if (!this.getIsEdit && register) {
        this.register = register
        this.$store.commit('closeRegister/SET_REGISTER', register)
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.content {
  width: 100%;
  @media screen and (min-width: $lg) {
    display: flex;
    justify-content: space-between;
  }
  @media screen and (max-width: $lg) {
    display: block;
  }
}

.subheader {
  overflow: auto;
  div {
    @media screen and (max-width: $lg) {
      margin-right: 15px;
    }
  }
}

.inputs-block {
  width: 100%;
}

.title {
  margin-bottom: 18px;
  font-size: $font-xl;
  font-weight: 500;
}

.total {
  width: 100%;
  max-width: 330px;
  padding-top: 18px;
  @media screen and (min-width: $lg) {
    margin-left: 50px;
  }
  &-section {
    @media screen and (min-width: $lg) {
      padding-left: 34px;
      padding-right: 54px;
    }
    div:first-child {
      margin-top: 0;
    }
  }

  &-row {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-top: 20px;
  }

  &-caption {
    font-size: $font-md;
    line-height: 24px;
  }
}

.divider {
  width: 100%;
  margin: 10px 0;
  border-bottom: 2px solid $white-smoke;
}
</style>
