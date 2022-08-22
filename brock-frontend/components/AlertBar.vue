<template>
  <div class="alert">
    <slot name="icon"></slot>
    <div>
      <h3 class="title">
        <slot name="title"></slot>
      </h3>

      <span class="content">
        <slot name="content"></slot>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AlertBar',
}
</script>

<style lang="scss" scoped>
.alert {
  display: flex;
  align-items: flex-start;
  padding: 20px 40px 20px 16px;
  background: #fff;
  border: 1px solid $white-smoke;
  border-radius: 3px;

  img {
    height: 24px;
    width: 24px;
    margin-right: 16px;
  }
}

.title {
  font-size: $font-s;
  line-height: 20px;
  font-weight: 600;
  color: $astronaut;
}

.content {
  font-size: $font-s;
  line-height: 20px;
  color: $astronaut;
}
</style>
