<template>
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ titleCard }} </h3>
                        <router-link :to="{path: '/usuarios'}" class="btn btn-sm btn-primary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link>
                    </div>
                    <!-- /.card-header -->
                    <!-- <div class="card-body"> -->
                    <!-- </div> -->
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-12 pt-2">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="/adminlte/dist/img/user4-128x128.jpg" alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center text-capitalize" v-text="user.name"></h3>
                                <p class="text-muted text-center text-capitalize" v-text="roles.display_name"></p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right text-primary" v-text="user.email"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Rol</b> <a href="#" class="float-right text-primary" v-text="roles.display_name" @click.prevent="showPermissionRol()"></a>
                                    </li>
                                    <transition name="fade">
                                        <li v-show="permission_rol" class="list-group-item">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                   <h3 class="card-title"><i class="fas fa-user-shield">&nbsp;</i>Permisos Rol - {{ roles.display_name }}</h3> 
                                                </div>
                                                <div class="card-body">
                                                    <template v-if="all_permissions.length">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Permisos</th>
                                                                    <th>Nombre</th>
                                                                    <th>Opción</th>
                                                                    <th>Fecha Registro</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(permission, index) in all_permissions" :key="permission.id">
                                                                    <td>{{ index + 1 }}</td>
                                                                    <td><b>{{ permission.display_name }}</b></td>
                                                                    <td>{{ permission.name }}</td>
                                                                    <td>{{ permission.option }}</td>
                                                                    <td>{{ permission.created_at | moment('DD/MM/YYYY') }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </template>
                                                    <template v-else>
                                                        <div>
                                                            <p class="text-muted">Sin Permisos asociados al Rol</p>    
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="card-footer clearfix">
                                                    <button class="btn btn-default btn-block btn-sm" @click.prevent="showPermissionRol()"><b>Cerrar</b></button>
                                                </div>
                                            </div>
                                        </li>
                                    </transition>
                                    <li class="list-group-item">
                                        <b>Permisos Extras</b>
                                        <template v-if="permissions.length">
                                            <a href="#" class="float-right text-primary" v-text="permissions.length" @click.prevent="showPermissionUser"></a>
                                        </template> 
                                        <template v-else>
                                            <a class="text-muted float-right">Sin Permisos</a>
                                        </template>
                                    </li>
                                     <transition name="fade">
                                        <li v-show="permission_user" class="list-group-item">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                   <h3 class="card-title"><i class="fas fa-user-shield">&nbsp;</i>Permisos Extras Rol - {{ roles.display_name }}</h3> 
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Permisos</th>
                                                                <th>Nombre</th>
                                                                <th>Opción</th>
                                                                <th>Fecha Registro</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(permission, index) in permissions" :key="permission.id">
                                                                <td>{{ index + 1 }}</td>
                                                                <td><b>{{ permission.display_name }}</b></td>
                                                                <td>{{ permission.name }}</td>
                                                                <td>{{ permission.option }}</td>
                                                                <td>{{ permission.created_at | moment('DD/MM/YYYY') }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer clearfix">
                                                    <button class="btn btn-default btn-block btn-sm" @click.prevent="showPermissionUser()"><b>Cerrar</b></button>
                                                </div>
                                            </div>
                                        </li>
                                    </transition>
                                    <li class="list-group-item">
                                        <b>Fecha de Registro</b> <a class="float-right text-primary">{{user.created_at | moment('DD/MM/YYYY')}}</a>
                                    </li>
                                </ul>
                                <router-link :to="{name: 'user-edit'}" class="btn btn-primary btn-block"><b>Editar Usuario</b></router-link>
                                <!-- <a href="#" class="btn btn-primary btn-block"><b>Editar Perfil</b></a> -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </section>
</template>
<script>
export default {
    name: 'user-view-app',
    data(){
        return {
            titlePage:'Usuarios',
            routePage:'Usuarios',
            titleCard:'Detalle de Usuario',
            user_id: this.$route.params.usuario,
            user: [],
            roles: [],
            all_permissions: [],
            permissions: [],
            permission_rol: false,
            permission_user: false
        }
    },
    created(){
        this.getUser();
    },
    computed: {
        currentUser() {
            // console.log(this.$store.getters.currentUser)
            return this.$store.getters.currentUser;
        }
    },
    methods:{
        getUser(){
            let url = `/api/auth/usuarios/${this.user_id}`
            let me = this;
            console.log(url)
            axios.get(url).then((response) => {
                // console.log(response)
                me.user = response.data;
                me.roles = response.data.roles[0];
                me.all_permissions = response.data.all_permissions;
                me.permissions = response.data.permissions;
            }) 
        },
        showPermissionRol(){
            if(this.permission_rol){
                this.permission_rol = false;
            }else{
                this.permission_rol = true;
            }

        },
        showPermissionUser(){
            if(this.permission_user){
                this.permission_user = false;
            }else{
                this.permission_user = true;
            }

        }
    }
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0
}
</style>