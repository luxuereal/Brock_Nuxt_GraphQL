import Me from '../graphql/queries/me.query.gql'

export default async function ({ app, redirect, route }) {
  const {
    data: { me },
  } = await app.apolloProvider.defaultClient.query({
    query: Me,
  })

  if (route.name !== 'home-select-unit' && !me.selectedUnit && !me.isAdmin) {
    redirect('/home/select-unit')
  } else if (me.isAdmin) {
    redirect('/hq-maintenance/export-data')
  }
}
