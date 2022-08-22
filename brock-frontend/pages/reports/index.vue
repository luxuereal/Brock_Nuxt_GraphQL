<template>
  <div></div>
</template>

<script>
export default {
  name: 'ReportsIndexPage',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/reports',
    redirectTo: '/reports/open-report',
  },
}
</script>

<style lang="scss" scoped></style>
