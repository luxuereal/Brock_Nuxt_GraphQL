<template>
  <div></div>
</template>

<script>
export default {
  name: 'HQUnitSetupIndexPage',
  layout: 'hqlayout',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/hq-unit-setup',
    redirectTo: '/hq-unit-setup/unit-info',
  },
}
</script>

<style lang="scss" scoped></style>
