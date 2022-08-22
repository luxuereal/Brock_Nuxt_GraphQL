<template>
  <div></div>
</template>

<script>
export default {
  name: 'HQAccountingPage',
  layout: 'hqlayout',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/hq-accounting',
    redirectTo: '/hq-accounting/state',
  },
}
</script>

<style lang="scss" scoped></style>
