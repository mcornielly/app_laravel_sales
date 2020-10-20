import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggeIn: !!user,
        loading: false,
        auth_error: null,
        permissions: []
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggeIn(state) {
            return state.isLoggeIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        permissions(state) {
            return state.permissions;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggeIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {
                token: payload.access_token
            });

            console.log(state.currentUser)
            console.log(state.currentUser.permissions)
            localStorage.setItem("user", JSON.stringify(state.currentUser));
            
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            // alert(2)
            // $("body").removeClass("sidebar-mini");
            // $("body").addClass("login-page");
            location.reload();
            localStorage.removeItem("user");
            state.isLoggeIn = false;
            state.currentUser = null;
        },
        updatePermissions(state, payload) {
            state.permissions = payload;
            console.log(state.permissions)
            localStorage.setItem("permissions", JSON.stringify(state.permissions));
        }
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        getPermissions(context) {
            axios.get('/api/auth/permisos')
                .then((response) => {
                    // console.log(response.data)
                    context.commit('updatePermissions', response.data);
                    
                });
        }

        //     loginUser({}, user){
        //     axios.post("/api/auth/login",{
        //         email: user.email,
        //         password: user.password
        //     }).then(response => {
        //         console.log(response.data)
        //         if(responser.data.access_token){
        //             localStorage.set(
        //                 "app_token",
        //                 response.data.access_token
        //             )

        //             window.location.replace("/home")
        //         }
        //     }).catch(error => {
        //         console.log(error.data)
        //     });
        // }
    }
};
