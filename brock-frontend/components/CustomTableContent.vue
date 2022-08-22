<template>
  <div class="table-content">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'CustomTableContent',
}
</script>

<style lang="scss" scoped>
.table-content {
  max-height: 500px;
  overflow: auto;
}
</style>
