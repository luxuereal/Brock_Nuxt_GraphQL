<template>
  <div class="content">
    <PageSubHeaderContent />

    <PageContentWrapper>
      <ValidationObserver ref="form">
        <InputRow>
          <InputWithTitle>
            <template #title> Amount </template>

            <template #input>
              <CustomInput
                v-model="amount"
                type="number"
                placeholder="0.00"
                rules="required|currency"
                name="Amount"
                symbol="$"
                @change="onChangeFloatValue"
              />
            </template>
          </InputWithTitle>

          <InputWithTitle>
            <template #title> Name/Comment </template>

            <template #input>
              <CustomInput v-model="nameComment" rules="required|max:255" name="Name/Comment" />
            </template>
          </InputWithTitle>
        </InputRow>
      </ValidationObserver>

      <div class="buttons-area">
        <DefaultButton button-color-gamma="red" @event="addCallLabor">
          Save
        </DefaultButton>
<!--         <DefaultButton button-color-gamma="white" @event="cancelEvent">
          Cancel
        </DefaultButton> -->
      </div>
    </PageContentWrapper>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import PageContentWrapper from './PageContentWrapper.vue'
import InputRow from './InputRow.vue'
import InputWithTitle from './InputWithTitle.vue'
import CustomInput from './CustomInput.vue'
import PageSubHeaderContent from './PageSubHeaderContent.vue'
import CreateCallLabor from '~/graphql/mutations/callLabor/createCallLabor.gql'

import { formMixin } from '~/mixins/formMixin'
import { mutationMixin } from '~/mixins/mutationMixin'

export default {
  name: 'OnCallLaborContent',
  components: {
    ValidationObserver,
    PageContentWrapper,
    InputRow,
    InputWithTitle,
    CustomInput,
    PageSubHeaderContent,
  },
  mixins: [formMixin, mutationMixin],
  data() {
    return {
      amount: '',
      nameComment: ''
    }
  },
  methods: {
    onChangeFloatValue() {
      this.amount = parseFloat(this.amount !== '' ? this.amount : 0).toFixed(2);
    },
    async addCallLabor() {
      await this.mutationAction(
        CreateCallLabor,
        {
          amount: this.amount,
          comments: this.nameComment
        },
        null,
        'Add on-call labor success',
        'Add on-call labor error',
        null,
        null,
        true
      )
    }
  }
}
</script>

<style lang="scss" scoped>
.content {
  div.subheader {
    justify-content: flex-start;
    overflow: auto;
    div {
      @media screen and (min-width: $lg) {
        margin-right: 120px;
      }
      @media screen and (max-width: $lg) {
        margin-right: 30px;
      }
    }
  }
}

.buttons-area {
  display: flex;
  margin-top: 50px;

  button:first-child {
    margin-right: 11px;
  }
}
</style>
