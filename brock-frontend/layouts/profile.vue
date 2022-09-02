<template>
  <div class="container">
    <TheHeader />

    <div class="nuxt-container">
      <Nuxt />
      
      <FormSubmissionMessage
        v-if="showMessage"
        :type="messageType"
        :message="message"
      />
    </div>
  </div>
</template>

<script>
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
import TheHeader from '@/components/TheHeader'
export default {
  name: 'ProfileLayout',
  components: {
    TheHeader,
  },
  mixins: [submitMessagesMixin],
  middleware: ['isAuth']  
}
</script>

<style lang="scss" scoped>
.container {
  min-height: 100vh;
}

.nuxt-container {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 109px);
  background: $platinum;
}
</style>
