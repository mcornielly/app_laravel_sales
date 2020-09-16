<template>
    <div>
        <form method="POST">
        <p>{{ welcome }}</p>
        <div class="input-group mb-3">
            <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="Email" v-model="user.email">
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
            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Contraseña" v-model="user.password">
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
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label for="remember">
                Recuérdame
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
</template>
<script>
export default {
    name: 'login-app',
    data() {
      return{
        user:{
          email:'',
          password: ''
        }
      }
    },
    computed:{
        welcome(){
          return this.$store.getters.welcome.welcomeMessage
        }
    },
    methods:{
      authenticate() {
        this.$store.dispatch('login');

        login(this.$data.form)
          .then((res) => {
            this.$store.commit("loginSuccess", res);
            // this.$router.push({path: '/'});
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