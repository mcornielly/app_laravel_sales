<template>
    <div>
        <form method="POST">
        <p>{{ welcome }}</p>
        <div class="input-group mb-3">
            <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="Email">
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
            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Contraseña">
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
            <button type="button" class="btn btn-primary btn-block" @click.prevent="authenticate">Entrar</button>
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
        message:'',
      }
    },
    computed:{
        welcome(){
          return this.$store.getters.welcome.welcomeMessage
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods:{
      authenticate(){
        // window.location.href = window.location.origin +'/home'
        // console.log('aqui')
        this.$router.push('/');
      }
    }
}
</script>