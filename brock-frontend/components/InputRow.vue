<template>
  <div class="input-row" :style="{ marginBottom: marginBottom }">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'InputsRow',
  props: {
    marginBottom: {
      type: String,
      default: '16px',
    },
  },
}
</script>

<style lang="scss" scoped>
.input-row {
  display: flex;

  div:first-child {
    margin-right: 20px;
  }
}
</style>
