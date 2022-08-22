<template>
  <div>
    <h4 class="title">
      <slot name="title"></slot>
    </h4>

    <h5 class="subtitle">
      <slot name="subtitle"></slot>
    </h5>
  </div>
</template>

<script>
export default {
  name: 'PageSubheaderItem',
}
</script>

<style lang="scss" scoped>
.title {
  font-size: $font-lg;
  font-weight: 700;
  line-height: 26px;
  color: $nero;
  white-space: nowrap;
}

.subtitle {
  margin-top: 8px;
  font-size: $font-s;
  font-weight: 400;
  line-height: 16px;
  color: $suva-grey;
  white-space: nowrap;
}
</style>
