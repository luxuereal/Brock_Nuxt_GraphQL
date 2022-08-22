import Me from '../graphql/queries/me.query.gql'

export default async function ({ app, redirect }) {
  const {
    data: {
      me: { isAdmin },
    },
  } = await app.apolloProvider.defaultClient.query({
    query: Me,
  })

  if (!isAdmin) {
    redirect('/login')
  }
}
