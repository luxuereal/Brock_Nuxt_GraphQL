<template>
  <h3 class="subtitle">
    <slot></slot>
  </h3>
</template>

<script>
export default {
  name: 'PageSubTitle',
}
</script>

<style lang="scss" scoped>
.subtitle {
  font-size: $font-s;
  font-weight: 400;
  line-height: 20px;
  color: $grey;
}
</style>
