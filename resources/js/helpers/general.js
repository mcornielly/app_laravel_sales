export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser = store.state.currentUser;
        // alert('general 1')
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
        const errorRequest = error.request.status;
        const currentUser = store.state.currentUser;

        if(errorRequest == 403 && currentUser){
            router.push("/403"); 
        }else if(errorRequest == 401){
            store.commit("logout");
            router.push("/login");
        }else{
            return Promise.reject(error);
            // router.push("*"); 
        }
        
        // if((error.response.status = 401)){
        //         store.commit("logout");
        //         router.push("/login");
        // }

        return Promise.reject(error);
    });

    if (store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token);
    }

}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}
