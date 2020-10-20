<template>
    <div class="login-box">
        <!-- <div v-if="error_login" class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>!Error!</strong> {{ error_login }}.
        </div> -->
        <div class="login-logo">
            <a href="/">SaleSystems</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    Ingresa tus datos para Iniciar Sesión
                </p>
                <form method="POST" action="">
                    <div class="input-group mb-3">
                        <input
                            id="email"
                            type="email"
                            class="form-control"
                            :class="{'is-invalid' : errors.email }"
                            name="email"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="Email"
                            v-model="user.email"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <span v-if="errors.email" class="invalid-feedback" role="alert">
                            <strong>{{ errors.email[0]}}</strong>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            id="password"
                            type="password"
                            class="form-control"
                            :class="{'is-invalid' : errors.password }"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Contraseña"
                            v-model="user.password"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span v-if="errors.password" class="invalid-feedback" role="alert">
                            <strong>{{ errors.password[0] }}</strong>
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
            </div>
            <p class="mb-1">
                <!-- <a href="{{ route('password.request') }}">Reestablecer contraseña</a> -->
            </p>
            <p class="mb-0">
                <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</template>
<script>
import { login } from "../helpers/auth";

export default {
    name: "login-app",
    data() {
        return {
            user: {
                email: "",
                password: ""
            },
            currentUser: {},
            error: null,
            errors: '',
            error_login:''
        };
    },
    methods: {
        authenticate() {
            this.$store.dispatch("login");

            login(this.$data.user)
                .then(response => {
                    console.log(response);
                    this.$store.commit("loginSuccess", response);
                    this.$store.dispatch('getPermissions');
                    // location.reload();     
                    toastr["success"]("Validación exitosa..!!", "Inicio de Sesión",
                    {
                        "progressBar": true,
                        "showDuration": "1000",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    },
                    
                        setTimeout(() => {
                            $("body").removeClass("login-page");
                            $("body").addClass("sidebar-mini");
                            this.$router.push({ path: "/" });
                        }, 1000)

                    );

                })
                .catch(error => {
                    const err = error.response.data.errors;
                    this.error = err;
                    console.log(this.err)
                    if(err == undefined){
                        this.error_login = "Correo Electrónico / Clave";
                        toastr.error("ERROR - Correo Electrónico / Clave.");
                    }else{
                        this.errors = err;
                    }
                });
        }
    }
};
</script>
