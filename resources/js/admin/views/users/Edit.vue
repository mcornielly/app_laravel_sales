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
                                <h3 class="profile-username text-center text-capitalize" v-text="user.name"></h3>
                                <p class="text-muted text-center text-capitalize" v-text="rol.display_name"></p>

                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-link float-right text-primary" id="edit-photo-profile" href="#" aria-selected="true" title="editar foto">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 col-sm-6">
                                        <div class="card card-primary card-outline card-tabs">
                                        <div class="card-header p-0 pt-1 border-bottom-0">
                                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Perfil del Usuario</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Rol del Usuario</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Permisos</a>
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
                                                                    <input type="password" v-on:blur="validate" class="form-control" :class="{'is-invalid' : errorPass, 'is-valid' : validPass }" name="password_confirmation" v-model="password_confirmation" placeholder="Confirmar Password">
                                                                    <span v-if="errorPass" class="invalid-feedback text-danger" role="alert" v-html="messagePass"></span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <button type="button" class="btn btn-primary btn-sm btn-block" @click.prevent="updateUser(user.id)"><b>Actualizar Perfil</b></button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                <div>
                                                    <ul> 
                                                        <li class="list-group-item">
                                                            <!-- <b>Rol</b> <a href="#" class="float-right text-primary" v-text="rol.display_name" @click.prevent="showPermissionRol()"></a> -->
                                                            <div class="form-group row">
                                                                <label class="col-md-3 form-control-label">Rol de Usuario</label>
                                                                <div class="col-md-9">
                                                                    <select class="form-control" v-model="rol.name">
                                                                        <option value="">Seleccione un Tipo de Rol</option>
                                                                        <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.display_name }}</option>
                                                                    </select>
                                                                    <!-- <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.rol[0]"></span> -->
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <button type="button" class="btn btn-primary btn-sm btn-block" @click.prevent="updateRol()"><b>Actualizar Rol</b></button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
                                            </div>

                                            </div>
                                        </div>
                                        <!-- /.card -->
                                        </div>
                                    </div>
                                </div>
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
            rol:'',
            role: [],
            roles: [],
            all_permissions: [],
            permissions: [],
            user:{
                name:'',
                email:'',
                password:'',
            },
            type_document: '',
            num_document: '',
            num_phone:'',
            email:'',
            address:'',
            password_confirmation: '',
            messagePass: '',
            errors: '',
            errorPass: false,
            validPass: false
        }
    },
    created(){
        this.getUser();
        this.getRoles();
    },
    methods:{
        getUser(){
            let url = `${this.url}${this.user_id}/edit`
            let me = this;
            this.$Progress.start()
            setTimeout(() => {
                // console.log(url)
                axios.get(url).then((response) => {
                    // console.log(response)
                    me.user = response.data;
                    me.rol = response.data.roles[0];

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
        updateUser(id){
            let me = this;
            var url = `/api/auth/usuarios/${this.user_id}`;
            axios.put(url,{
                'id': this.user_id,
                'name':this.user.name,
                'email': this.user.email,
                'password': this.user.password,
            }).then(response => {
                console.log(response)
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

            this.role.push(this.rol.name);
            this.$Progress.start()
            setTimeout(() => {
            axios.put(url,{
                'id': this.user_id,
                'role': this.role,
            }).then(response => {
                console.log(response)
                // me.$router.push({ path: "/usuarios" });
                toastr.info('El Rol del Usuario fue actualizado.');
            }).catch(error => {
                let errors = error.response.data.errors;
                if (error.response.status == 422) {
                    console.log(me.errors)
                    me.errors = errors;
                    me.validPass = false;
                    me.$Progress.fail();
                    toastr.error("ERROR - En la validaciones.");
                }
            })
            this.$Progress.finish();
            }, 1000);
            // this.getUser;
            // location.reload();
        },
        validate(){
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
        }
    }
}
</script>