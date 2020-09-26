import { setAuthorization } from "./general";

export function login(credentials) {
    console.log(credentials)
    return new Promise((res, rej) => {
        axios.post('/api/auth/login', credentials)
            .then((response) => {
                console.log(response.data)
                res(response.data);
                setAuthorization(response.data.access_token);
            })
            .catch((err) =>{
                rej("Wrong email or password");
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