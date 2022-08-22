<template>
  <div class="container" @click="updateCheckbox(value)">
    <div
      class="checkbox"
      :class="{
        'checkbox--active': value.checked,
      }"
    >
      <img
        v-if="value.checked"
        src="~assets/images/icons/mark.svg"
        class="icon"
      />
    </div>

    <span class="caption">
      <slot></slot>
    </span>
  </div>
</template>

<script>
export default {
  name: 'CustomCheckbox',
  props: {
    value: {
      type: Object,
      required: true,
    },
  },
  methods: {
    updateCheckbox(value) {
      this.$emit('update-checkbox', value)
    },
  },
}
</script>

<style lang="scss" scoped>
.container {
  display: flex;
  align-items: center;
  width: fit-content;
  cursor: pointer;
}

.checkbox {
  position: relative;
  width: 14px;
  height: 14px;
  border: 2px solid $thistle;
  border-radius: 3px;
  background: $hint-of-red;

  &--active {
    background: $brown;
    border: none;
  }
}

.icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.caption {
  margin-left: 10px;
  font-size: $font-s;
  line-height: 20px;
  color: $nero;
}
</style>
