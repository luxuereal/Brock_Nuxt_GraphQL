<template>
  <div class="tables">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'CustomTablesArea',
}
</script>

<style lang="scss" scoped>
.tables {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  margin-top: 20px;

  div.table:first-child {
    @media screen and (min-width: $md) {
      width: 75%;
      margin-right: 20px;
    }
    @media screen and (max-width: $md) {
      width: 100%;
    }
  }

  div.table:last-child {
    @media screen and (min-width: $md) {
      width: 25%;
    }
    @media screen and (max-width: $md) {
      width: 100%;
    }
  }

  @media screen and (max-width: $xl) {
    flex-direction: column-reverse;
    margin-right: 0;
  }
}
</style>
