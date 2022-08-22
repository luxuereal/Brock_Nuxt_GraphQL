<template>
  <NuxtLink class="tab" :to="to">
    <img class="icon" :src="iconSrc" />

    <span class="caption">
      {{ name }}
    </span>
  </NuxtLink>
</template>

<script>
export default {
  name: 'HeaderTab',
  props: {
    to: {
      type: String,
      required: true,
    },
    iconSrc: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
  },
}
</script>

<style lang="scss" scoped>
.tab {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  margin-right: 5px;
  padding: 20px 0;
  width: 105px;
  border-radius: 5px;
  transition: $transition;

  &:hover {
    background: $firebrick;
  }
}

.caption {
  margin-top: 10px;
  font-size: $font-s;
  font-weight: 600;
  color: #fff;
}

.nuxt-link-active {
  background: $firebrick;
}

.icon {
  height: 22px;
  width: 22px;
}
</style>
