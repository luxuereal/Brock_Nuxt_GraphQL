<template>
  <div></div>
</template>

<script>
export default {
  name: 'HomeIndexPage',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/home',
    redirectTo: '/home/select-unit',
  },
}
</script>

<style lang="scss" scoped></style>
