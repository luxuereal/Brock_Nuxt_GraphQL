<template>
  <input
    class="pagination-input"
    type="number"
    :value="value"
    :disabled="disabled"
    @change="$emit('change')"
    @keyup.enter="$emit('event')"
    @input="setValue($event.target.value)"
  />
</template>

<script>
export default {
  name: 'PaginationInput',
  props: {
    disabled: {
      type: Boolean,
      default: false,
    },
    value: {
      type: [String, Number],
      default: '',
    },
  },
  methods: {
    setValue(inputValue) {
      this.$emit('input', inputValue)
    },
  },
}
</script>

<style lang="scss" scoped>
.pagination-input {
  transition: $transition;
  width: 50px;
  padding: 10px 8px;
  margin: 0px 5px;
  font-size: $font-s;
  color: #000;
  border: 1px solid gainsboro;
  border-radius: 3px;
  outline: none;
  text-align: center;

  &:focus {
    border: 1px solid $firebrick;
  }
  &:disabled {
    background: transparent;
    cursor: not-allowed;
  }
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