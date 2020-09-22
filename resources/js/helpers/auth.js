export function login(credentials) {
    return new Promise((res, rej) => {
        axios
            .post("/api/auth/login", credentials)
            .then(response => {
                console.log(response.data);
                res(response.data);
                setAuthorization(response.data.access_token);
            })
            .catch(err => {
                rej("Email / Clave Invalida");
            });
    });
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user");

    if (!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}
