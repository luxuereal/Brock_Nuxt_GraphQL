<template>
  <div class="subheader">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'PageSubheader',
}
</script>

<style lang="scss" scoped>
.subheader {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid $white-smoke;
  @media screen and (min-width: $lg) {
    padding: 16px 20px;
  }
  @media screen and (max-width: $lg) {
    padding: 15px 10px;
  }
}
</style>
