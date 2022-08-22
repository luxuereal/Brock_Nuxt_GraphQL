<template>
  <img
    v-if="!isHide"
    src="~assets/images/icons/home/add.svg"
    class="icon icon--add"
    @click="$emit('add-row')"
  />
</template>

<script>
export default {
  name: 'CustomTableAddIcon',
  props: {
    isHide: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style lang="scss" scoped></style>
