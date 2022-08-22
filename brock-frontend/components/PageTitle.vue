<template>
  <h2 class="title">
    <slot></slot>
  </h2>
</template>

<script>
export default {
  name: 'PageTitle',
}
</script>

<style lang="scss" scoped>
.title {
  font-size: $font-xl;
  line-height: 28px;
  font-weight: 700;
  color: $nero;
  text-transform: capitalize;
}
</style>
