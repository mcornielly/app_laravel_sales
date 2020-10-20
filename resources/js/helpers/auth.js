import { setAuthorization } from "./general";

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/auth/login', credentials)
            .then((response) => {
                console.log(response.data)
                res(response.data);
                setAuthorization(response.data.access_token);
                console.log(store.state.currentUser);
            })
            .catch((err) =>{
                // const error = err.response.data.errors;
                rej(err);
                // rej("Wrong email or password");
            })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user");
    
    if(!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}