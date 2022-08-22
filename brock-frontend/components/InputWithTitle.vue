<template>
  <div class="container" :class="{'select' : hasSelect}" :style="{ maxWidth }">
    <h5 class="title" :style="{ marginBottom }">
      <slot name="title"></slot>
    </h5>

    <slot name="input"></slot>
  </div>
</template>

<script>
export default {
  name: 'InputWithTitle',
  props: {
    marginBottom: {
      type: String,
      default: '4px',
    },
    maxWidth: {
      type: String,
      default: '240px',
    },
    hasSelect: {
      type: Boolean,
      default: false
    }
  },
}
</script>

<style lang="scss" scoped>
.container {
  width: 100%;
  max-width: 240px;
}

.select {
  min-width: 240px;
  max-width: fit-content !important;
}

.title {
  margin-bottom: 4px;
  font-size: $font-xs;
  line-height: 16px;
  font-weight: 600;
  color: $grey;
}
</style>
