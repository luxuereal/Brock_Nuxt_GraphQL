import Auth from '../graphql/queries/auth.gql'

export default async function ({ app, redirect }) {
  const {
    data: {
      me: { isAdmin },
    },
  } = await app.apolloProvider.defaultClient.query({
    query: Auth,
  })

  if (!isAdmin) {
    redirect('/login')
  }
}
