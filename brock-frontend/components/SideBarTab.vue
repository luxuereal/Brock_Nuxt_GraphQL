<template>
  <NuxtLink :to="pageUrl" class="tab">
    <!-- <img :src="iconSrc" class="icon" /> -->
    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
    <span class="caption">{{ caption }}</span>
  </NuxtLink>
</template>

<script>
export default {
  name: 'SideBarTab',
  props: {
    pageUrl: {
      type: String,
      required: true,
    },
    iconSrc: {
      type: String,
      required: true,
    },
    caption: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      width: process.client && window.innerWidth,
    }
  },
  mounted() {
    this.$nextTick(() => {
      window.addEventListener('resize', this.onResize)
    })
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.onResize)
  },
  methods: {
    onResize() {
      if (process.client) {
        this.width = window.innerWidth
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.tab {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 208px;
  padding: 10px 12px;
  border-radius: 3px;
  transition: $transition;

  @media screen and (max-width: $md) {
    width: fit-content;
  }

  &--active {
    width: 100%;
  }

  i {
    color: $firebrick;
    transition: all .1s linear;
  }

  img.icon {
    filter: brightness(0) saturate(100%) invert(47%) sepia(0%) saturate(991%)
      hue-rotate(185deg) brightness(84%) contrast(94%);
  }

  &:hover {
    background: $firebrick;
  
    i {
      color: #fff;
    }

    span.caption {
      color: #fff;
    }

    img.icon {
      filter: brightness(0) saturate(100%) invert(100%) sepia(2%) saturate(0%)
        hue-rotate(172deg) brightness(103%) contrast(105%);
    }
  }
}

.icon {
  width: 24px;
  height: 24px;
}

.caption {
  margin-left: 15px;
  color: $night-rider;
  font-size: $font-s;
  font-weight: 500;
}

.nuxt-link-exact-active {
  background: $firebrick;

  img.icon {
    filter: brightness(0) saturate(100%) invert(100%) sepia(2%) saturate(0%)
      hue-rotate(172deg) brightness(103%) contrast(105%);
  }

  i {
    color: #fff;
  }
  span.caption {
    color: #fff;
  }
}
</style>
