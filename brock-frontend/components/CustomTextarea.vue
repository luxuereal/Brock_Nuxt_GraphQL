<template>
  <ValidationProvider v-slot="{ errors, classes }" mode="eager" :rules="rules">
    <textarea
      :name="name"
      :value="value"
      class="textarea"
      :class="classes"
      :style="{ width, height }"
      :disabled="disabled"
      @input="setValue($event.target.value)"
    ></textarea>
    <span class="error">{{ errors[0] }}</span>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate'
export default {
  name: 'CustomTextarea',
  components: { ValidationProvider },
  props: {
    value: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      default: '500px',
    },
    height: {
      type: String,
      default: '80px',
    },
    rules: {
      type: String,
      default: '',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    setValue(textareaValue) {
      this.$emit('input', textareaValue)
    },
  },
}
</script>

<style lang="scss" scoped>
.textarea {
  background: #fff;
  border: 1px solid $gainsboro;
  padding: 10px 8px;
  border-radius: 3px;
  resize: none;
  @media screen and (max-width: $lg) {
    width: 100% !important;
  }

  &:disabled {
    background: transparent;
    cursor: not-allowed;
  }
}

.error {
  font-size: 12px;
  color: $firebrick;
}

.invalid {
  border: 1px solid $firebrick;
}
</style>
