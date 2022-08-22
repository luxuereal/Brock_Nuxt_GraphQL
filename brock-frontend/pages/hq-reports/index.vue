<template>
  <div></div>
</template>

<script>
export default {
  name: 'HQReportsIndexPage',
  layout: 'hqlayout',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/hq-reports',
    redirectTo: '/hq-reports/labor-schedule-report',
  },
}
</script>

<style lang="scss" scoped></style>
