<template>
  <div class="table">
    <div class="table-content" :style="{ minWidth: wTable + 'px' }">
      <div class="header">
        <slot name="header"></slot>
      </div>

      <div class="content">
        <slot name="content"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CustomTable',
  props: {
    wTable: {
      type: Number,
      default: 500
    },
  },
}
</script>

<style lang="scss" scoped>
.table {
  width: 100%;
  background: #fff;
  border: 1px solid $gainsboro;
  border-radius: 8px;
  overflow-x: auto;
  @media screen and (max-width: $lg) {

  }
}


.header {
  // padding: 22px 20px 25px;
  padding: 6px 10px;
  background: $cultured;
  border-top-right-radius: inherit;
  border-top-left-radius: inherit;
  border-bottom: 1px solid $white-smoke;

  span {
    color: $night-rider;
    font-size: $font-s;
    font-weight: 600;
    line-height: 16px;
    letter-spacing: 5%;
  }
}
</style>
