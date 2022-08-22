<template>
  <div
    class="pagination-row"
  >
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'PaginationRow',
}
</script>

<style lang="scss" scoped>
.pagination-row {
    padding: 5px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid $white-smoke;
    font-size: $font-s;

    &:last-child {
        border-bottom: none;
        border-radius: 0 0 8px 8px;
    }

    .button-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        &.show {
            visibility: visible;
        }
        &.hide {
            visibility: hidden;
        }
    }
    .description-bar {
    }
}
</style>
