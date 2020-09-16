import {getLocalUser} from "/.helpers/auth"

const user = getLocalUser();

export default {
    state:{
        curremtUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null
    },
    getters:{
        isLoading(state) {
            return state.loading;
        },
        isLoaggedIn(state) {
            return state.isLoaggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        }

        
    },
    mutations:{
        login(state){
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoaggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access});

            localStorage.setItem("user", JSON.stringify(state.curremtUser));
        },
        loginFailed(state, payload){
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.remove("user");
            state.isLoaggedIn = false;
            state.currentUser = null;
        }
    },
    actions:{
        login(context) {
            context.commit("login");
        }
    },
}