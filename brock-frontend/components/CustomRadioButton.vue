<template>
  <div
    class="container"
    :class="{
      ' container--disabled': disabled,
    }"
    @click="disabled ? null : setIsActive()"
  >
    <div class="radio-container" :style="{ width, height, borderRadius }">
      <div
        class="radio"
        :class="{ 'radio-active': isActive, 'radio--disabled': disabled }"
        :style="{
          width: radioWidth,
          height: radioHeight,
          borderRadius: radioBorderRadius,
        }"
      ></div>
    </div>

    <span v-if="withTitle" class="caption">
      <slot></slot>
    </span>
  </div>
</template>

<script>
export default {
  name: 'CustomRadioButton',
  props: {
    isActive: {
      type: Boolean,
      default: false,
    },
    withTitle: {
      type: Boolean,
      default: false,
    },
    width: {
      type: String,
      default: '20px',
    },
    radioWidth: {
      type: String,
      default: '12px',
    },
    height: {
      type: String,
      default: '20px',
    },
    radioHeight: {
      type: String,
      default: '12px',
    },
    borderRadius: {
      type: String,
      default: '3px',
    },
    radioBorderRadius: {
      type: String,
      default: '0px',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    value: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  methods: {
    setIsActive() {
      this.$emit('set-is-active', this.value)
    },
  },
}
</script>

<style lang="scss" scoped>
.container {
  display: flex;
  align-items: center;
  cursor: pointer;

  &--disabled {
    cursor: not-allowed;
  }
}

.radio {
  cursor: pointer;

  &--disabled {
    cursor: not-allowed;
  }

  &-container {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 2.5px;
    border: 1.5px solid $dark-grey;
  }

  &-active {
    background: $firebrick;
  }
}

.caption {
  margin-left: 8px;
  font-size: $font-s;
  line-height: 20px;
}
</style>
