function requireAuth (to, from, next) {
    let AuthCheck = window.AuthCheck;
    console.log(AuthCheck)
    if (AuthCheck === "0") {
        next({
            path: '/login',
        })
    } else {
        next()
    }
}