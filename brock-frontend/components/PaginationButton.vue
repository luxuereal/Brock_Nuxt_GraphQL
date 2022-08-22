<template>
  <button
    :class="'pagination-button' + (!disabled && loading ? ' loading' : '')"
    :disabled="disabled"
    @click="clickEvent"
  >
    <div v-if="!disabled && loading" class="loadingIcon">
        <i class="fa-solid fa-spinner"></i>
    </div>
    <slot v-if="disabled || !loading"></slot>
  </button>
</template>

<script>
export default {
  name: 'PaginationButton',
  props: {
    disabled: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false
    }
  },
  methods: {
    clickEvent() {
        // not clickable when loading the page data at the table
        !this.loading && this.$emit('event')
    },
  },
}
</script>

<style lang="scss" scoped>
.pagination-button {
    transition: $transition;

    display: flex;
    justify-content: center;
    align-items: center;

    cursor: pointer;

    width: 30px;
    height: 30px;

    margin: 0px 5px;

    border-radius: 5px;
    font-size: $font-xs;

    color: #000;
    background: #fff;
    border: 1px solid $gainsboro;

    &:disabled {
        background: $thistle;
        cursor: not-allowed;
    }
    &:hover:not(:disabled) {
        border: 1px solid $firebrick;
    }
    &.loading {
        background: rgb(240, 240, 240);
    }
    .loadingIcon {
        width: 100%;
        height: 100%;
        position: relative;
        animation: rotation 1s infinite linear;
        i {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 13px;
        }
    }
    @-webkit-keyframes rotation {
        from {-webkit-transform: rotate(0deg);}
        to   {-webkit-transform: rotate(359deg);}
    }
}
</style>
