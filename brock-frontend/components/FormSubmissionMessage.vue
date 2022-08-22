<template>
  <div
    class="message"
    :class="{
      'message--success': type === 'success',
      'message--error': type === 'error',
    }"
  >
    <span v-if="!message" class="text">
      {{
        type === 'success'
          ? 'Form data has been updated'
          : 'Something went wrong with the submission'
      }}
    </span>
    <span v-else>
      {{ message }}
    </span>
  </div>
</template>

<script>
export default {
  name: 'FormSubmissionMessage',
  props: {
    type: {
      type: String,
      required: true,
    },
    message: {
      type: String,
      required: true,
    },
  },
}
</script>

<style lang="scss" scoped>
.message {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 100;
  padding: 10px 15px;
  animation: message 0.5s ease-in-out;

  &--success {
    background: $eucalyptus;
    color: #fff;
  }

  &--error {
    color: #fff;
    background: $firebrick;
  }
}

.text {
  color: #fff;
  font-size: $font-s;
  line-height: 20px;
}

@keyframes message {
  0% {
    right: -500px;
  }

  100% {
    right: 0;
  }
}
</style>
