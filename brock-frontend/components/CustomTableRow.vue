<template>
  <div
    class="row"
    :class="{ 'row--active': isActive, 'row--selectable': selectable }"
    @click="$emit('event')"
  >
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'CustomTableRow',
  props: {
    isActive: {
      type: Boolean,
      default: false,
    },
    selectable: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style lang="scss" scoped>
.row {
  padding: 10px 20px;
  border-bottom: 1px solid $white-smoke;
  font-size: 14px;

  &--active {
    background: $firebrick;
    color: #fff;
  }

  &--selectable {
    cursor: pointer;
  }

  &:last-child {
    border-bottom: none;
    border-radius: 0 0 8px 8px;
  }
}
</style>
