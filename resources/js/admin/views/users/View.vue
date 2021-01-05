<template>
    <section>
        <div class="col-md-12">
            <div v-show="user.avatar">
                <img-profile
                    :user="user"
                    :role="role"
                    :editImg="editImg"
                >
                </img-profile>
            </div>
            <div class="clearfix"></div>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Email</b> <a class="float-right text-primary" v-text="user.email"></a>
                </li>
                <li class="list-group-item">
                    <b>Rol</b> <a href="#" class="float-right text-primary" v-text="role.display_name" @click.prevent="showPermissionRol()"></a>
                </li>
                <transition name="fade">
                    <li v-show="permission_rol" class="list-group-item">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user-shield">&nbsp;</i>Permisos Rol - {{ role.display_name }}</h3> 
                            </div>
                            <div class="card-body">
                                <template v-if="rol_permissions.length">
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
                                            <tr v-for="(permission, index) in rol_permissions" :key="permission.id">
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
                                <button class="btn btn-info btn-block btn-sm" @click.prevent="showPermissionRol()"><b>Cerrar</b></button>
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
                                <h3 class="card-title"><i class="fas fa-user-shield">&nbsp;</i>Permisos Extras Rol - {{ role.display_name }}</h3> 
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
                                <button class="btn btn-info btn-block btn-sm" @click.prevent="showPermissionUser()"><b>Cerrar</b></button>
                            </div>
                        </div>
                    </li>
                </transition>
                <li class="list-group-item">
                    <b>Fecha de Registro</b> <a class="float-right text-primary">{{user.created_at | moment('DD/MM/YYYY')}}</a>
                </li>
            </ul>
        </div>
    </section>
</template>
<script>
export default {
    name: 'user-view-app',
    data(){
        return {
            url:'/api/auth/roles',
            title:'Detalle Perfil del Usuario',
            user_id: this.$route.params.usuario,
            name_page: this.$route.name, 
            icon_user:'fas fa-user-check',
            editImg: false,
            user: [],
            role: [],
            all_permissions: [],
            permissions: [],
            rol_permissions: [],
            permission_rol: false,
            permission_user: false
        }
    },
    created(){
        this.getUser();
        this.$emit('title', this.title);
        this.$emit('path', this.$route.path);
        this.$emit('namePage', this.name_page);
        this.$emit('iconUser', this.icon_user);
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
                console.log(response)
                me.user = response.data.user;
                me.role = response.data.user.roles[0];
                me.all_permissions = response.data.user.all_permissions;
                me.permissions = response.data.permissions_user;
                me.rol_permissions = response.data.user.roles[0].permissions;
            
                // me.permissions = response.data.user.permissions;
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