<template>
  <div></div>
</template>

<script>
import Me from '~/graphql/queries/me.query.gql'
export default {
  name: 'IndexPage',
  async created() {
    try {
      const {
        data: { me },
      } = await this.$apollo.query({ query: Me })

      if (me.isAdmin) {
        this.$router.push('/hq-maintenance')
      } else {
        this.$router.push('/home')
      }
    } catch (error) {
      if (error) {
        this.$router.push('/login')
      }
    }
  },
}
</script>
