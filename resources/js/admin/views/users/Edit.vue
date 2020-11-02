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
                    <!-- <div class="card-body">
                    </div> -->
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
                                <h3 class="profile-username text-center">{{ user.name }}</h3>
                                <p class="text-muted text-center">{{ roles.display_name }}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Nombre y Apellido</label>
                                            <div class="input-group col-md-9">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-tag"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Usuario" v-model="user.name">
                                                <!-- <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span> -->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Email</label>
                                            <div class="input-group col-md-9">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-envelope"></i>
                                                        </span>
                                                    </div>
                                                <input type="text" class="form-control text-lowercase" :class="{'is-invalid' : errors}" placeholder="Ingrese Email" v-model="user.email">
                                                <!-- <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.email[0]"></span> -->
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <!-- <b>Rol</b> <a href="#" class="float-right text-primary" v-text="roles.display_name" @click.prevent="showPermissionRol()"></a> -->
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Rol de Usuario</label>
                                            <div class="col-md-9">
                                                <select class="form-control" :class="{'is-invalid' : errors}" v-model="roles.display_name">
                                                    <option value="">Seleccione un Tipo de Rol</option>
                                                    <option v-for="rol in role" :key="rol.id" :value="rol">{{ rol.display_name }}</option>
                                                    <!-- <option v-for="item in types_doc" :key="item.id" :value="item.id_doc" v-text="data.type_document"></option> -->
                                                </select>
                                                <!-- <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.rol[0]"></span> -->
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <router-link :to="{name: 'user-edit'}" class="btn btn-primary btn-block"><b>Actualizar Usuario</b></router-link>
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
    name: 'user-edit-app',
    data(){
        return {
            url:'/api/auth/usuarios/',
            titlePage:'Usuarios',
            routePage:'Usuarios',
            titleCard:'Editar Usuario',
            user_id: this.$route.params.usuario,
            user: [],
            roles: [],
            all_permissions: [],
            permissions: [],
            user:{
                name:'',
                email:'',
            },
            rol:'',
            type_document: '',
            num_document: '',
            num_phone:'',
            email:'',
            address:'',
            errors: null
        }
    },
    created(){
        this.getData();
    },
    methods:{
    getData(){
            let url = `${this.url}${this.user_id}/edit`
            let me = this;
            console.log(url)
            axios.get(url).then((response) => {
                console.log(response)
                me.user = response.data;
                me.roles = me.user.roles[0];
                // me.roles = response.data.role;
                // me.all_permissions = response.data.all_permissions;
                // me.permissions = response.data.permissions;
                console.log(me.roles)
                // console.log(me.rol)
                // console.log(me.roles)
                // console.log(me.permissions.length)
            }).catch((error) => {
                // me.errors = error.response.data.errros;
            })
        },
    }
}
</script>