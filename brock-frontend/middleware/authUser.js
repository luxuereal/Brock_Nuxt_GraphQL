import AuthMe from '../graphql/queries/authMe.gql'

export default async function ({ app, redirect }) {
  const {
    data: {
      me: { isAdmin },
    },
  } = await app.apolloProvider.defaultClient.query({
    query: AuthMe,
  })

  if (isAdmin) {
    redirect('/login')
  }
}
