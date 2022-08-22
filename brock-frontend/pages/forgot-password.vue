<template>
  <div class="password">
    <ValidationObserver ref="form">
      <InputWithTitle>
        <template #title>Email</template>

        <template #input>
          <CustomInput v-model="email" type="email" rules="email|required" name="Email"/>
        </template>
      </InputWithTitle>

      <DefaultButton button-color-gamma="red" class="reset" @event="reset">
        Reset
      </DefaultButton>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import ForgotPassword from '~/graphql/mutations/forgotPassword.mutation.gql'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import { errorHandlerMixin } from '~/mixins/errorHandlerMixin'
import { resultHandlerMixin } from '~/mixins/resultHandlerMixin'
import CustomInput from '~/components/CustomInput.vue'
export default {
  name: 'PasswordForgot',
  components: { CustomInput, ValidationObserver },
  mixins: [submitMessagesMixin, errorHandlerMixin, resultHandlerMixin],
  layout: 'login',
  data() {
    return {
      email: '',
    }
  },
  methods: {
    async reset() {
      const forgotPasswordInput = {
        email: this.email,
        resetPasswordUrl:
          '/reset-password?email=__EMAIL__&token=__TOKEN__',
      }
      const formValidated = await this.$refs.form.validate()

      if (formValidated) {
        try {
          const forgotPasswordResult = await this.$apollo.mutate({
            mutation: ForgotPassword,
            variables: forgotPasswordInput,
          })
          this.handleResult(forgotPasswordResult, 'forgotPassword')
        } catch ({ graphQLErrors }) {
          this.handleError(graphQLErrors)
        }
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.password {
  width: 240px;
}

.reset {
  margin-top: 25px;
}
</style>
