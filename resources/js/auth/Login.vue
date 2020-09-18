<template>
    <div>
        <form method="POST">
        <div class="input-group mb-3">
            <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="Email" v-model="user.email">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
                <span class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
        </div>
        <div class="input-group mb-3">
            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Contraseña" v-model="user.password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
                <span class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label for="remember">
                Recuérdame
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="button" class="btn btn-primary btn-block" @click.prevent="authenticate">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
</template>
<script>
import {login} from '../helpers/auth';

export default {
    name: 'login-app',
    data() {
      return{
        user:{
          email:'',
          password: ''
        },
        error: null
      }
    },
    // computed:{
    //     welcome(){
    //       return this.$store.getters.welcome.welcomeMessage
    //     }
    // },
    methods:{
      authenticate() {
        this.$store.dispatch('login');
        // get the redirect object
        // var redirect = this.$auth.redirect();
        // console.log(redirect)
        login(this.$data.user)
          .then((res) => {
            console.log(res)
            this.$store.commit("loginSuccess", res);

            console.log(redirect.from.name)
            // handle redirection
            // const redirectTo = redirect ? redirect.from.name : res ? 'spa' : 'dashboard'
            // this.$router.push({name: redirectTo})  


            window.location.href("/");
            // this.$router.push('/');
          })
          .catch((error) => {
            this.$store.commit("loginFailed", {error});
          })
      }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>