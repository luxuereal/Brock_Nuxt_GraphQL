<template>
  <div class="section">
    <slot name="sideBar"></slot>

    <main class="container">
      <header class="header">
        <slot name="header"></slot>
      </header>

      <div class="content">
        <slot name="content"></slot>
      </div>
    </main>

    <FormSubmissionMessage
      v-if="showMessage"
      :type="messageType"
      :message="message"
    />
  </div>
</template>

<script>
import { submitMessagesMixin } from '~/mixins/submitMessagesMixin'
export default {
  name: 'BasePageLayout',
  mixins: [submitMessagesMixin],
}
</script>

<style lang="scss" scoped>
.section {
  position: relative;
  display: flex;
  width: 100%;
  max-width: $xxl;
  // overflow: hidden;
}

.container {
  width: 100%;
  background: $cultured;
}

.header {
  background: #fff;
  border-bottom: 1px solid $white-smoke;
  width: 100%;
  @media screen and (min-width: $lg) {
    padding: 24px 20px 22px;
  }
  @media screen and (max-width: $lg) {
    padding: 15px 10px;
  }
  h3 {
    margin-bottom: 2px;
  }
}

.content {
  width: 100%;
  height: 100%;
}
</style>
