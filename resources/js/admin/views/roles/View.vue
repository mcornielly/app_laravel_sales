<template>
    <div v-if="rol">
      <table class="table table-striped">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th colspan="3" class="">Detalle Rol</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1.</td>
                <td><dt>ID.</dt></td>
                <td colspan="2">{{ rol.id }}</td>
              </tr>
              <tr>
                <td>2.</td>
                <td><dt>Nombre</dt></td>
                <td colspan="2">{{ rol.name }}</td>
              </tr>
              <tr>
                <td>3.</td>
                <td><dt>Rol</dt></td>
                <td colspan="2">{{ rol.display_name }}</td>
              </tr>
              <tr>
                <td>4.</td>
                <td><dt>Fecha Creación</dt></td>
                <td colspan="2">{{ rol.created_at }}</td>
              </tr>
            </tbody>
      </table>
      <router-link class="btn btn-default btn-sm float-right" to="/roles"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link>
    </div>
</template>

<script>
    export default {
        name: 'role-view-app',
        data() {
            return {
                url:'/api/auth/roles',
                titleCard:'Detalle Rol',
                rol: null
            }
        },
        created() {
            this.showRol();
        },
        computed: {
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            showRol(){
                let url = `/api/auth/roles/${this.$route.params.role}`
                console.log(url)
                axios.get(url).then((response) => {
                    console.log(response)
                    this.rol = response.data;
                }) 
            }
        }
    }
</script>