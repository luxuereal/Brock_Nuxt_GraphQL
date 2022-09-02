<template>
  <ValidationProvider
    v-slot="{ errors, classes }"
    mode="eager"
    :rules="rules"
    :name="name"
  >
    <span :symbol="symbol">
      <input
        :symbol="symbol"
        class="input"
        :name="name"
        :value="displayCell(value)"
        :type="type"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :class="classes"
        @change="$emit('change')"
        @keyup.enter="$emit('event')"
        @input="setValue($event.target.value)"
      />
    </span>
    <span v-if="!doNotShowErrorMessage" class="error">{{ errors[0] }}</span>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate'
export default {
  name: 'CustomInput',
  components: { ValidationProvider },
  props: {
    name: {
      type: String,
      default: '',
    },
    changeFloat: {
      type: String,
      default: '',
    },
    isFloat: {
      type: String,
      default: '',
    },
    value: {
      type: [String, Number],
      default: '',
    },
    type: {
      type: String,
      default: 'text',
    },
    placeholder: {
      type: String,
      default: '',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    readonly: {
      type: Boolean,
      default: false,
    },
    rules: {
      type: [String, Object],
      default: '',
    },
    vid: {
      type: String,
      default: '',
    },
    doNotShowErrorMessage: {
      type: Boolean,
      default: false,
    },
    symbol: {
      type: String,
      default: '',
    },
  },
  methods: {
    setValue(inputValue) {
      this.$emit('input', inputValue)
    },
    displayCell(value) {
      return  this.name !== 'Phone Number'
                ? (typeof value === 'string')
                ? value : (this.isFloat === "true" ? parseFloat(value !== '' ? value : 0).toFixed(2) : value)
                : this.acceptPhoneNumber(value)
    },
    acceptPhoneNumber(value) {
      const x = value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      return !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    }
  },
}
</script>

<style lang="scss" scoped>
.input {
  width: 100%;
  padding: 10px 8px;
  font-size: $font-s;
  line-height: 20px;
  color: #000;
  border: 1px solid gainsboro;
  border-radius: 3px;
  outline: none;

  &:focus {
    border: 1px solid $firebrick;
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

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type='number'] {
  -moz-appearance: textfield;
}
</style>
