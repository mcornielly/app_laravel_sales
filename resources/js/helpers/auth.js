export function login(credentials) {
    console.log(credentials)
    return new Promise((res, rej) => {
    
        axios.post('/api/auth/login', credentials)
            .then((response) => {
                console.log(response.data)
                res(response.data.access_token);
                // setAuthorization(response.data.access_token);
            })
            .catch((err) =>{
                console.log(err)
                const error = err.response.data.errors;
                rej(error);
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