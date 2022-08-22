<template>
  <div></div>
</template>

<script>
export default {
  name: 'HQMaintenanceIndexPage',
  layout: 'hqlayout',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/hq-maintenance',
    redirectTo: '/hq-maintenance/export-data',
  },
}
</script>

<style lang="scss" scoped></style>
