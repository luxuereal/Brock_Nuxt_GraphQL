export default function ({redirect, route, store}) {
  const redirects = store.state.tabsView.redirects;

  let redirectFrom = '';
  let redirectTo = '';

  route.meta.forEach((meta) => {
    if (meta.redirectTo) {
      redirectFrom = meta.redirectFrom;
      redirectTo = meta.redirectTo;
    }
  });

  if (redirects && redirects[redirectFrom] && redirects[redirectFrom].length) {
    const navRedirect = redirects[redirectFrom];

    redirectTo = navRedirect.includes(redirectTo) ? redirectTo : navRedirect[0];
  }

  redirect(redirectTo);
}
