<template>
  <div></div>
</template>

<script>
export default {
  name: 'AdminIndexPage',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/admin',
    redirectTo: '/admin/close-week',
  },
}
</script>

<style lang="scss" scoped></style>
