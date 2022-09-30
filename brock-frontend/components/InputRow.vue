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

  div:not(:first-child) {
    margin-left: 16px;
  }

  @media screen and (max-width: $sm) {
    flex-direction: column;

    div:not(:first-child) {
      margin-left: 0px !important;
      margin-top: 16px;
    }
  }
}
</style>
