<template>
  <PageContentWrapper>
    <h2 class="title">Verify you have completed the following steps</h2>

    <AlertBar>
      <template #icon>
        <img src="~assets/images/icons/info.svg" alt="" />
      </template>

      <template #title> Please note</template>

      <template #content>
        Verify that you have completed the following steps by placing a check
        mark before each completed item.
      </template>
    </AlertBar>

    <div class="checkbox-area">
      <CustomCheckbox :value="emailChecked" @update-checkbox="updateCheckbox">
        Checked email for updates
      </CustomCheckbox>

      <CustomCheckbox
        :value="payrollHoursChecked"
        @update-checkbox="updateCheckbox"
      >
        Payroll hours have been entered and verified
      </CustomCheckbox>

      <CustomCheckbox
        :value="inventoryChecked"
        @update-checkbox="updateCheckbox"
      >
        Inventory has been entered and verified
      </CustomCheckbox>

      <CustomCheckbox
        :value="reaccrualsChecked"
        @update-checkbox="updateCheckbox"
      >
        Reaccruals have been entered and verified
      </CustomCheckbox>
    </div>

    <div class="buttons-area">
      <DefaultButton
        button-color-gamma="red"
        :disabled="!isConditionMet"
        @event="closeEvent"
      >
        Close Week
      </DefaultButton>

      <DefaultButton button-color-gamma="white" @event="exitEvent">
        Cancel
      </DefaultButton>
    </div>
  </PageContentWrapper>
</template>

<script>
import AlertBar from './AlertBar.vue'
import CustomCheckbox from './CustomCheckbox.vue'
import DefaultButton from './DefaultButton.vue'
import CloseWeek from '~/graphql/mutations/closeWeek/closeWeek.gql'
import { mutationMixin } from '~/mixins/mutationMixin'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'

export default {
  name: 'CloseWeekContent',
  components: { AlertBar, CustomCheckbox, DefaultButton },
  mixins: [mutationMixin, submitMessagesMixin],
  data() {
    return {
      checkbox: [
        'emailChecked',
        'payrollHoursChecked',
        'inventoryChecked',
        'reaccrualsChecked',
      ],
      emailChecked: {
        id: 1,
        name: 'emailChecked',
        checked: false,
      },
      payrollHoursChecked: {
        id: 2,
        name: 'payrollHoursChecked',
        checked: false,
      },
      inventoryChecked: {
        id: 3,
        name: 'inventoryChecked',
        checked: false,
      },
      reaccrualsChecked: {
        id: 4,
        name: 'reaccrualsChecked',
        checked: false,
      },
    }
  },
  computed: {
    isConditionMet() {
      return (
        this.emailChecked.checked &&
        this.payrollHoursChecked.checked &&
        this.inventoryChecked.checked &&
        this.reaccrualsChecked.checked
      )
    },
  },
  methods: {
    updateCheckbox(checkboxValue) {
      this[checkboxValue.name] = {
        ...checkboxValue,
        checked: !checkboxValue.checked,
      }
    },
    exitEvent() {
      for (const name of this.checkbox) {
        this[name].checked = false
      }
    },
    async closeEvent() {
      const res = await this.$apollo.mutate({
        mutation: CloseWeek,
      });
      if (res) {
        this.exitEvent()
        this.showSubmitMessage('Close week success', 'success')
        this.$router.push('/home/select-unit')
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.title {
  margin-bottom: 40px;
  font-size: $font-xl;
  font-weight: 500;
  line-height: 32px;
  color: $nero;
}

.checkbox-area {
  margin-top: 40px;

  div.container {
    margin-bottom: 20px;

    &:last-child {
      margin-bottom: 0;
    }
  }
}

.buttons-area {
  display: flex;
  margin-top: 25px;

  button:first-child {
    margin-right: 11px;
  }
}
</style>
