<template>
  <div
    class="message fade-in-out"
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

.fade-in-out {
  animation: fadeInOut ease-in-out 4.1s;
  -webkit-animation: fadeInOut ease-in-out 4.1s;
  -moz-animation: fadeInOut ease-in-out 4.1s;
  -o-animation: fadeInOut ease-in-out 4.1s;
  -ms-animation: fadeInOut ease-in-out 4.1s;
}

@keyframes fadeInOut {
  0%, 100% {
    opacity:0;
  }
  20%, 80% {
    opacity:1;
  }
}

@-moz-keyframes fadeInOut {
  0%, 100% {
    opacity:0;
  }
  20%, 80% {
    opacity:1;
  }
}

@-webkit-keyframes fadeInOut {
  0%, 100% {
    opacity:0;
  }
  20%, 80% {
    opacity:1;
  }
}

@-o-keyframes fadeInOut {
  0%, 100% {
    opacity:0;
  }
  20%, 80% {
    opacity:1;
  }
}

@-ms-keyframes fadeInOut {
  0%, 100% {
    opacity:0;
  }
  20%, 80% {
    opacity:1;
  }
}
</style>
