export default function ({store, redirect}) {
  if (!store.state.auth.loggedIn) {
    return redirect('/auth/login')
  } else {
    return redirect('/home')
  }
}
