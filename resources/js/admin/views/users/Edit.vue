<template>
    <section>
        <div class="col-md-12">
                <!-- <img class="profile-user-img img-fluid img-circle" src="/adminlte/dist/img/user4-128x128.jpg" alt="User profile picture">C:\laragon\www\app_laravel_sales\public\images\avatars\default.jpg -->
            <div v-show="user.avatar">
                <img-profile
                    :user="user"
                    :role="role"
                    :editImg="editImg"
                >
                </img-profile>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-6">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true" @click="tabChange('dataUser')">Perfil del Usuario</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false" @click="tabChange('roleUser')">Rol del Usuario</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false" @click="tabChange('permissionsUser')">Permisos</a>
                            </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                    <div>
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
                                                        <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors.name}" placeholder="Ingrese Nombre del Usuario" v-model="user.name">
                                                        <span v-if="errors.name" class="invalid-feedback text-danger" role="alert" v-html="errors.name[0]"></span>
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
                                                        <input type="email" class="form-control text-lowercase" :class="{'is-invalid' : errors.email}" placeholder="Ingrese Email" v-model="user.email" autocomplete="off">
                                                        <span v-if="errors.email" class="invalid-feedback text-danger" role="alert" v-html="errors.email[0]"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Contraseña</label>
                                                    <div class="input-group col-md-9">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-key"></i>
                                                                </span>
                                                            </div>
                                                        <input type="password" class="form-control" :class="{'is-invalid' : errors.password, 'is-valid' : validPass }" name="password" v-model="user.password" placeholder="Ingrese Password" autocomplete="off">
                                                        <span v-if="errors.password" class="invalid-feedback text-danger" role="alert" v-html="errors.password[0]"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" >Confirmar Contraseña</label>
                                                    <div class="input-group col-md-9">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-key"></i>
                                                                </span>
                                                            </div>
                                                        <input type="password" v-on:blur="validatePass" class="form-control" :class="{'is-invalid' : errorPass, 'is-valid' : validPass }" name="password_confirmation" v-model="password_confirmation" placeholder="Confirmar Password">
                                                        <span v-if="errorPass" class="invalid-feedback text-danger" role="alert" v-html="messagePass"></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                    <div>
                                        <ul> 
                                            <li class="list-group-item">
                                                <!-- <b>Rol</b> <a href="#" class="float-right text-primary" v-text="rol.display_name" @click.prevent="showPermissionRol()"></a> -->
                                                <div class="row form-group">
                                                    <label class="col-md-3 form-control-label">Rol de Usuario</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" v-model="role.name" @change="roleFind(role.name)">
                                                            <option value="">Seleccione un Tipo de Rol</option>
                                                            <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.display_name }}</option>
                                                        </select>
                                                        <span v-if="errors.name" class="text-danger" role="alert">
                                                            <small>
                                                                {{ errors.name[0] }}
                                                            </small>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label class="col-md-3 form-control-label">Descripción</label>
                                                    <div class="col-md-9">
                                                        <div class="callout callout-info">
                                                            <h6><dt>{{ role.display_name }} | <span class="text-muted">{{ role.name }}</span></dt></h6>

                                                            <p><dd>{{ role.description }}</dd></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                    <permissions-component
                                        :permissions="permissions"
                                        :menus="menus"
                                        :menus_all="menus_all"
                                        :sub_menus="sub_menus"
                                        @update-permissions="permissions = $event"
                                    ></permissions-component>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button v-if="item_tab=='dataUser'" type="button" class="btn btn-primary btn-sm btn-block" @click="updateUser(user.id)"><b>Actualizar Perfil</b></button>
                            <button v-if="item_tab=='roleUser'" type="button" class="btn btn-primary btn-sm btn-block" @click="updateRol()"><b>Actualizar Rol</b></button>
                            <button v-if="item_tab=='permissionsUser'" class="btn btn-primary btn-sm btn-block" @click="updatePermissions(permissions)">Actualizar Permisos</button>
                        </div>    
                    <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

export default {
    name: 'user-edit-app',
    data(){
        return {
            url:'/api/auth/usuarios/',
            title:'Editar Perfil de Usuario',
            pre_img:'',
            user_id: this.$route.params.usuario,
            item_tab:'dataUser',
            rol:'',
            role: {},
            roles: [],
            menus: null,
            menus_all: null,
            sub_menus: null,
            all_permissions: [],
            permissions: [],
            permissions_user: [],
            user:{
                name:'',
                avatar: '',
                email:'',
                password:'',
            },
            editImg:true,
            avatar:'',
            password_confirmation: '',
            messagePass: '',
            errors: [],
            errorsImg: [],
            errorPass: false,
            loaded: false,
            validPass: false,
            img_profile:'/images/avatars/default.jpg', 
            nameImg: 'Seleccionar Imagen',
            size: 100000
        }
    },
    created(){
        this.getUser();
        this.getRoles();
        this.getMenu();
        this.$emit('title', this.title);
        this.$emit('path', this.$route.path);
        // this.avatar = this.user.avatar;
    },
    // computed:{
    //     img_profile(){
    //         if(this.img_profile == ''){
    //             return "/images/avatars/default.jpg";
    //         }else{
    //             return this.pre_img;
    //         }
    //     }
    // },
    methods:{
        roleFind(roleName){
            if(roleName){
                this.role = {};
                this.role = this.roles.find(role => role.name === roleName);
                this.getRoles();
            }
        },
        getUser(){
            let url = `${this.url}${this.user_id}/edit`
            let me = this;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url).then((response) => {
                    console.log(response.data)
                    me.user = response.data;
                    me.rol = response.data.roles[0].id;
                    me.role = response.data.roles[0];
                    me.all_permissions = response.data.all_permissions;
                    // me.permissions_user = response.data.permissions_user;
                    this.getPermissionsUser(me.all_permissions);
                    this.getPermissions(me.rol);

                    // console.log(me.permissions_user)
                    // if(me.permissions_user != ''){
                    //     console.log(me.permissions_user)
                    //     this.getPermissionsUser(me.permissions_user);
                    // }else{
                    //     alert(2)
                    //     this.getPermissionsUser(me.all_permissions);
                    // }
                    // console.log(this.permissions)
                }).catch((error) => {
                    me.errors = error.response.data.errros;
                    me.$Progress.fail();
                })
            this.$Progress.finish();
            }, 1000);
        },
        getRoles(){
            let url = '/api/auth/roles';
            let me = this;
            // console.log(url)
            axios.get(url).then((response) => {
                // console.log(response)
                me.roles = response.data.data;
                console.log(me.roles)
            }).catch((error) => {
                me.errors = error.response.data.errros;
                console.log(me.errors)
            })

        },
        getMenu(){
            let url = `/api/auth/menus`
            console.log(url)
            axios.get(url).then((response) => {
                this.menus = response.data.menus;
                this.menus_all = response.data.menus_all;
                this.sub_menus = response.data.submenus;
            }) 
        },
        getPermissions(rol){
            let url = `/api/auth/permisos/${rol}`
            console.log(url)
            axios.get(url).then((response) => {
                let permissions = [];
                permissions = response.data;
                permissions.forEach(element => {
                    // console.log(element.name)
                    this.permissions.push(element.name);
                });
            }) 
        },
        getPermissionsUser(permissionsUser){
            let permissions = permissionsUser;
            // permissions = response.data;
            permissions.forEach(element => {
                // console.log(element.name);
                this.permissions.push(element.name);
            });
        },
        updatePermissions(){
            console.log(this.rol)
            let url = `/api/auth/usuarios/${this.user_id}/permisos`
            console.log(url)
            setTimeout(() => {
                this.$Progress.start()    
                axios.put(url,{
                    id: this.rol,
                    permissions: this.permissions,
                }).then((response) => {
                    // console.log(response)
                    this.rol = response.data;
                    toastr.info('Los Permisos del Rol fueron actualizados.');
                    this.$router.push({ path: "/usuarios" });
                }).catch(error => {
                    let errors = error.response.data.errors;
                    // console.log(errors)
                    if (error.response.status == 422) {
                        this.errors = errors;
                        toastr.error("ERROR - En la validaciones.");
                    }
                    this.$Progress.fail()
                })
            this.$Progress.finish()
            },1000) 
        },
        updateUser(id){
            let me = this;
            var url = `/api/auth/usuarios/${this.user_id}`;
            axios.put(url,{
                'id': this.user_id,
                'name':this.user.name,
                'email': this.user.email,
                'password': this.user.password,
            }).then(response => {
                // console.log(response)
                me.$router.push({ path: "/usuarios" });
                toastr.info('El Usuario fue actualizado.');
            }).catch((error) => {
                let errors = error.response.data.errors;
                if (error.response.status == 422) {
                    console.log(me.errors)
                    me.errors = errors;
                    me.validPass = false;
                    toastr.error("ERROR - En la validaciones.");
                }
            });
        },
        updateRol(){
            let me = this;
            var url = `/api/auth/usuarios/${this.user_id}/roles`;

            // this.role.push(this.role.name);
            this.$Progress.start()
            setTimeout(() => {
                axios.put(url,{
                    'id': this.user_id,
                    'name': this.role.name,
                }).then(response => {
                    // console.log(response)
                    me.errors = [];
                    me.$router.push({ path: "/usuarios" });
                    toastr.info('El Rol del Usuario fue actualizado.');
                }).catch(error => {
                    this.$Progress.fail();
                    let errors = error.response.data.errors;
                    if (error.response.status == 422) {
                        console.log(errors)
                        me.errors = errors;
                        me.validPass = false;
                        toastr.error("ERROR - En la validaciones.");
                    }
                })
            this.$Progress.finish();
            }, 1000);
            // this.getUser;
            // location.reload();
        },
        validatePass(){
            // console.log(this.password === this.password2)
            
            if(this.user.password === this.password_confirmation && this.password_confirmation != ''){
                this.errorPass = false;
                this.validPass = true;
                this.messagePass = "";
            }else if(this.password_confirmation != ''){
                this.errorPass = true;
                this.validPass = false;
                this.messagePass = "Password no concuerda";
            }
        },
        tabChange(data){
            this.item_tab = data;
        }

    }
}
</script>

<style>
    .center {
        max-width: 500px;
        margin: auto;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .9s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0
    }

    /* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>