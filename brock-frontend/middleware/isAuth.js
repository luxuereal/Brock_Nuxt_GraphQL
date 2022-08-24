import Auth from '../graphql/queries/auth.gql'

export default async function ({ app, redirect }) {
  const hasToken = !!app.$apolloHelpers.getToken()

  try {
    await app.apolloProvider.defaultClient.query({
      query: Auth,
      fetchPolicy: 'no-cache',
    })
  } catch (error) {
    const errorObj = error.graphQLErrors[0]

    if (errorObj !== undefined && errorObj.message === 'Unauthenticated.') {
      const defaultClient = app.apolloProvider.defaultClient
      app.$apolloHelpers.onLogout(defaultClient, true)
      defaultClient.stop()
      defaultClient.cache.reset()
      defaultClient.resetStore()
      return redirect('/login')
    }
  }

  if (!hasToken) {
    return redirect('/login')
  }
}
