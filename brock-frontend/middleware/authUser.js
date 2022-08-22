export default function ({ redirect, store }) {
  const role = store.getters['auth/getRole']

  if (role !== 'user') {
    redirect('/login')
  }
}
