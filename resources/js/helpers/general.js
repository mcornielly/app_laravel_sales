export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser = store.state.currentUser;

        if (requiresAuth && !currentUser) {
            // alert('gene-1')
            $("body").removeClass("sidebar-mini");
            $("body").addClass("login-page");
            next("/login");
        } else if (to.path == "/login" && currentUser) {
            // alert('gene-2')
            $("body").removeClass("login-page");
            $("body").addClass("sidebar-mini");
            next("/");
        } else {
            // alert('gene-3')
            next();
        }
    });

    axios.interceptors.response.use(null, error => {
        if ((error.response.status = 401)) {
           alert('error-404') 
            router.push("*");
            // store.commit("logout");
            // router.push("/login");
        }

        return Promise.reject(error);
    });

    if (store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token);
    }

}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}
