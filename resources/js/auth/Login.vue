<template>
    <div>
        <div class="login-box">
            <div class="login-logo">
                <a href="/">Nombre de la App</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">
                        Ingresa tus datos para Iniciar Sesión
                    </p>

                    <form method="POST">
                        <p>{{ welcome }}</p>
                        <div class="input-group mb-3">
                            <input
                                id="email"
                                type="email"
                                class="form-control"
                                name="email"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="Email"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ message }}</strong>
                            </span>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                id="password"
                                type="password"
                                class="form-control"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Contraseña"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ message }}</strong>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                    />
                                    <label for="remember">
                                        Recuérdame
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-block"
                                    @click.prevent="authenticate"
                                >
                                    Entrar
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-1">
                        <a href="#">Reestablecer contraseña</a>
                    </p>
                    <p class="mb-0">
                        <a href="register.html" class="text-center">
                            Register a new membership
                        </a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</template>
<script>
import { login } from "../helpers/auth";

export default {
    name: "login-app",
    data() {
        return {
            message: "",
            user: {
                email: "",
                password: ""
            },
            error: null
        };
    },
    computed: {
        authError() {
            return this.$store.getter.authError;
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        authenticate() {
            this.$store.dispatch("login");

            login(this.$data.user)
                .then(res => {
                    // console.log('aqui')
                    console.log(res);
                    this.$store.commit("loginSuccess", res);
                    this.$router.push({ path: "/" });
                    // this.$router.push("/");
                    // window.location.href = window.location.origin +'/home'
                })
                .catch(error => {
                    this.$store.commit("loginFailed", { error });
                });
        }
    }
};
</script>
