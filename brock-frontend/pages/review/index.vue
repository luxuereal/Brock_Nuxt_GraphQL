<template>
  <div></div>
</template>

<script>
export default {
  name: 'ReviewIndexPage',
  middleware: 'redirectToSpecificPage',
  meta: {
    redirectFrom: '/review',
    redirectTo: '/review/register-closeout',
  },
}
</script>

<style lang="scss" scoped></style>
