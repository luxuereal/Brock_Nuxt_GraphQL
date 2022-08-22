<template>
  <div class="wrapper">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'PageContentWrapper',
}
</script>

<style lang="scss" scoped>
.wrapper {

  @media screen and (min-width: $lg) {
    padding: 20px 24px 76px 20px;
  }
  @media screen and (max-width: $lg) {
    padding: 15px 10px;
  }
}
</style>
