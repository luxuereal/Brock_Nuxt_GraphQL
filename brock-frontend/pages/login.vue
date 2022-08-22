<template>
  <div class="content">
    <div class="login">
      <ValidationObserver ref="form">
        <InputWithTitle>
          <template #title>Email</template>

          <template #input>
            <CustomInput
              v-model="email"
              vid="email"
              type="email"
              name="Email"
              rules="email|required"
            />
          </template>
        </InputWithTitle>

        <InputWithTitle>
          <template #title>Password</template>

          <template #input>
            <CustomInput
              v-model="password"
              type="password"
              name="Password"
              rules="required"
              @event="login"
            />
          </template>
        </InputWithTitle>
      </ValidationObserver>

      <NuxtLink to="forgot-password">
        <span class="text"> FORGOT PASSWORD? </span>
      </NuxtLink>

      <DefaultButton button-color-gamma="red" @event="login">
        Sign in
      </DefaultButton>
    </div>
  </div>
</template>

<script>
import { ValidationObserver } from 'vee-validate'
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import { errorHandlerMixin } from '~/mixins/errorHandlerMixin'
import Login from '~/graphql/mutations/login.mutation.gql'
import InputWithTitle from '~/components/InputWithTitle.vue'
import CustomInput from '~/components/CustomInput.vue'
import DefaultButton from '~/components/DefaultButton.vue'

export default {
  name: 'LoginPage',
  components: {
    InputWithTitle,
    CustomInput,
    DefaultButton,
    ValidationObserver,
  },
  mixins: [submitMessagesMixin, errorHandlerMixin],
  layout: 'login',
  data() {
    return {
      email: '',
      password: '',
    }
  },
  methods: {
    async login() {
      const credentials = {
        email: this.email,
        password: this.password,
      }
      const formValidated = await this.$refs.form.validate()
      if (formValidated) {
        try {
          const loginResult = await this.$apollo.mutate({
            mutation: Login,
            variables: credentials,
          })
          await this.$apolloHelpers.onLogin(loginResult.data.login.token)
          this.$router.push('/')
        } catch ({ graphQLErrors }) {
          this.handleError(graphQLErrors)
        }
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

.login {
  width: 240px;
  div.container {
    margin-bottom: 16px;
  }
}

.text {
  display: block;
  margin-bottom: 25px;
  color: $brown;
  font-size: 14px;
  line-height: 20px;
  text-transform: uppercase;
  cursor: pointer;
}
</style>
