<template>
  <div class="icons-area">
    <img
      v-if="isEditActive || isDeleteActive"
      class="icon"
      src="~assets/images/icons/line-md_confirm-circle.svg"
      @click="isEditActive ? $emit('confirm-edit') : $emit('confirm-delete')"
    />
    <img
      v-else-if="showEdit"
      class="icon"
      src="~assets/images/icons/review/edit.svg"
      @click="$emit('edit')"
    />

    <img
      v-if="isEditActive || isDeleteActive"
      class="icon icon--cancel"
      src="~assets/images/icons/close-circle-outline.svg"
      @click="isEditActive ? $emit('cancel') : $emit('cancel-delete')"
    />
    <img
      v-else-if="showDelete"
      class="icon"
      src="~assets/images/icons/review/trash-can.svg"
      @click="$emit('delete')"
    />
  </div>
</template>

<script>
export default {
  name: 'CustomTableIconsColumn',
  props: {
    isEditActive: {
      type: Boolean,
      default: false,
    },
    isDeleteActive: {
      type: Boolean,
      default: false,
    },
    showEdit: {
      type: Boolean,
      default: true,
    },
    showDelete: {
      type: Boolean,
      default: true,
    },
  },
}
</script>

<style lang="scss" scoped>
.icons-area {
  display: flex;
  align-items: center;
  justify-self: end;
}

.icon {
  height: 19px;
  width: 19px;
  cursor: pointer;

  &:first-child {
    margin-right: 15px;
  }

  &--cancel {
    filter: brightness(0) saturate(100%) invert(12%) sepia(42%) saturate(6846%)
      hue-rotate(348deg) brightness(110%) contrast(91%);
  }
}
</style>
