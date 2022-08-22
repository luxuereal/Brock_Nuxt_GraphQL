<template>
  <div>
    <ValidationObserver ref="form">
      <InputRow>
        <InputWithTitle>
          <template #title>Password</template>

          <template #input>
            <CustomInput
              v-model="resetPasswordInput.password"
              vid="password"
              type="password"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <InputRow>
        <InputWithTitle>
          <template #title>Confirm Password</template>

          <template #input>
            <CustomInput
              v-model="resetPasswordInput.passwordConfirmation"
              type="password"
              rules="required|password:@confirmPassword"
            />
          </template>
        </InputWithTitle>
      </InputRow>

      <DefaultButton button-color-gamma="red" class="reset" @event="reset">
        Reset Password
      </DefaultButton>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import { errorHandlerMixin } from '~/mixins/errorHandlerMixin'
import { resultHandlerMixin } from '~/mixins/resultHandlerMixin'
import ResetPassword from '~/graphql/mutations/resetPassword.mutation.gql'
import InputRow from '~/components/InputRow.vue'
import InputWithTitle from '~/components/InputWithTitle.vue'
import CustomInput from '~/components/CustomInput.vue'
import DefaultButton from '~/components/DefaultButton.vue'
export default {
  name: 'ResetPasswordPage',
  components: {
    InputRow,
    InputWithTitle,
    CustomInput,
    DefaultButton,
    ValidationObserver,
  },
  mixins: [submitMessagesMixin, errorHandlerMixin, resultHandlerMixin],
  layout: 'login',
  data() {
    return {
      resetPasswordInput: {
        password: '',
        passwordConfirmation: '',
        email: '',
        token: '',
      },
    }
  },
  mounted() {
    const email = this.$route.query.email
    const token = this.$route.query.token
    this.resetPasswordInput.email = email
    this.resetPasswordInput.token = token
  },
  methods: {
    async reset() {
      const formValidated = this.$refs.form.validate()

      if (formValidated) {
        try {
          const resetPasswordResult = await this.$apollo.mutate({
            mutation: ResetPassword,
            variables: this.resetPasswordInput,
          })
          this.handleResult(resetPasswordResult, 'resetPassword')
        } catch ({ graphQLErrors }) {
          this.handleError(graphQLErrors)
        }
      }
    },
  },
}
</script>

<style lang="scss" scoped></style>
