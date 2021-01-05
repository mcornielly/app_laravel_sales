<template>
    <section>
        <form-wizard
            @on-complete="onComplete"
            @on-loading="setLoading"
            @on-validate="handleValidation"
            @on-error="handleErrorMessage" 
            next-button-text="Siguiente"
            back-button-text="Regresar"
            finish-button-text="Finalizar"
            title="" subtitle=""
            step-size="md"
            color="#007bff" shape="square">
            <tab-content title="Datos del Usuario"  icon="ti-user" :before-change="validateTab1">
                <div class="card card-default card-default">
                    <div class="card-header">
                        <h3 class="card-title text-primary"><i class="fas fa-id-card">&nbsp;</i> Datos del Usuario</h3>
                    </div>
                    <!-- /.card-header -->                  
                    <div class="card-body">
                        <!-- <img-profile
                            :user="user"
                            :role="role"
                        >
                        </img-profile> -->
                        <template>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Nombre de Usuario</label>
                                <div class="input-group col-md-9">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors.name}" placeholder="Ingrese Nombre del Usuario" v-model="user.name">
                                    <span v-if="errors.name" class="invalid-feedback text-danger" role="alert" v-html="errors.name[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Tipo de Documento</label>
                                <div class="col-md-9">
                                    <select class="form-control" :class="{'is-invalid' : errors.type_document}" v-model="user.type_document">
                                        <option value="">Seleccione un Tipo de Documento</option>
                                        <option>V</option>
                                        <option>E</option>
                                    </select>
                                    <span v-if="errors.type_document" class="invalid-feedback text-danger" role="alert" v-html="errors.type_document[0]"></span>
                                </div>                                                        
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">N° Documento</label>
                                <div class="input-group col-md-9">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" :class="{'is-invalid' : errors.num_document}" placeholder="Ingrese N° Docuemnto" v-model="user.num_document" maxlength="10">
                                    <span v-if="errors.num_document" class="invalid-feedback text-danger" role="alert" v-html="errors.num_document[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">N° de Teléfono</label>
                                <div class="input-group col-md-9">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" :class="{'is-invalid' : errors.num_phone}" v-mask="'(###) ###-##-##'" placeholder="(###) ###-##-##" v-model="user.num_phone">
                                    <span v-if="errors.num_phone" class="invalid-feedback text-danger" role="alert" v-html="errors.num_phone[0]"></span>
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
                                    <input type="email" class="form-control" :class="{'is-invalid' : errors.email}" placeholder="Ingrese Email" v-model="user.email" autocomplete="nope">
                                    <span v-if="errors.email" class="invalid-feedback text-danger" role="alert" v-html="errors.email[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Dirección</label>
                                <div class="col-md-9">
                                <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors.address}" cols="60" rows="3" v-model="user.address" placeholder="Ingrese dirección"></textarea>
                                <span v-if="errors.address" class="invalid-feedback text-danger" role="alert" v-html="errors.address[0]"></span>
                                </div>
                            </div>                                                        
                        </template>
                    </div>
                </div>
            </tab-content> 
            <tab-content title="Clave del Usuario" icon="ti-key" :before-change="validateTab2">
                <!-- Generar Coódigo -->
                <div class="card card-default card-default">
                    <div class="card-header">
                        <h3 class="card-title text-primary"><i class="fas fa-key">&nbsp;</i> Clave del Usuario</h3>
                    </div>
                    <div class="card-body"> 
                        <!-- /.card-header -->
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Contraseña</label>
                            <div class="input-group col-md-9">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                <input type="password" class="form-control" :class="{'is-invalid' : errors.password, 'is-valid' : validPass }" name="password" v-model="user.password" placeholder="Ingrese Password" autocomplete="new-password">
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
                                <span v-if="errorPass" class="invalid-feedback text-danger" role="alert" v-html="errorPass"></span>
                            </div>
                        </div>                  
                    </div> 
                    <!-- /.card-body -->
                </div>
            </tab-content>
            <tab-content title="Rol del Usuario" icon="ti-shield" :before-change="validateTab3">
                <!-- Generar Coódigo -->
                <div class="card card-default card-default">
                    <div class="card-header">
                        <h3 class="card-title text-primary"><i class="fas fa-user-shield">&nbsp;</i> Rol del Usuario</h3>
                    </div>
                    <div class="card-body">
                        <!-- /.card-header -->                  
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Rol de Usuario</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="role.name" @change="roleFind(role.name)">
                                    <option value="">Seleccione un Tipo de Rol</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.display_name }}</option>
                                </select>
                                <!-- <span v-if="errors.name" class="text-danger" role="alert">
                                    <small>
                                        {{ errors.name[0] }}
                                    </small>
                                </span> -->
                            </div>
                        </div>
                        <div v-if="role.id > 0" class="row form-group">
                            <label class="col-md-3 form-control-label">Descripción</label>
                            <div class="col-md-9">
                                <div class="callout callout-info">
                                    <div v-if="role.description">
                                        <h6><dt>{{ role.display_name }} | <span class="text-muted">{{ role.name }}</span></dt></h6>

                                        <p><dd>{{ role.description }}</dd></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </tab-content>
            <tab-content title="Permisos del Usuario" icon="ti-panel">
                <!-- Imagnes del Producto -->
                <div class="card card-default card-default">
                    <div class="card-header">
                        <h3 class="card-title text-primary"><i class="fa fa-user-cog">&nbsp;</i> Permisos del Usuario</h3>
                    </div>
                    <div class="card-body">
                        <permissions-component
                            :permissions="permissions"
                            :role_name="role.name"
                            :menus="menus"
                            :menus_all="menus_all"
                            :sub_menus="sub_menus"
                            @update-permissions="permissions = $event"
                        ></permissions-component>
                    <!-- /.card-header -->                  
                    </div>    
                    <!-- /.card-body -->
                </div>              
                <!-- /.card -->
            </tab-content>
        </form-wizard>
    </section>
</template>
<script>
import {mask} from 'vue-the-mask'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import Vue from "vue";

export default {
    name: 'user-create-app',
    data(){
        return {
            url:'/api/auth/usuarios',
            titlePage:'Usuarios',
            routePage:'Usuarios',
            title:'Nuevo Usuario',
            icon_user:'fas fa-user-plus',
            role: {
                id:0,
                name:'',
                display_name:'',
            },
            roles: [],
            user:{
                avatar: '',
                name:'',
                type_document: '',
                num_document: '',
                email:'',
                num_phone:'',
                address: '',
                password:'',
            },
            menus: null,
            menus_all: null,
            sub_menus: null,
            all_permissions: [],
            permissions: [],
            password_confirmation: '',
            validPass: false,
            errors:'',
            errorPass: ''
        }
    },
    created(){
        this.getRoles();
        this.getMenu();
        this.$emit('title', this.title);
        this.$emit('path', this.$route.path);
        this.$emit('iconUser', this.icon_user);
    },
    computed:{
        currentUser() {
            return this.$store.getters.currentUser;
        }
    },
    methods:{
        onComplete(){
            toastr["info"]("Formulario completado con exito..!!", "Nuevo Usuario");
            setTimeout(() => {
                this.storeUser();
            }, 1000)
            
        },
        setLoading: function(value) {
            this.loadingWizard = value
            console.log(this.loadingWizard)
        },
        handleValidation: function(isValid, tabIndex){
           console.log('Tab: '+tabIndex+ ' valid: '+isValid)
        },
        handleErrorMessage: function(errorMsg){
          this.errorMsg = errorMsg
        },
        validateTab1:function() {
          return new Promise((resolve, reject) => {
            setTimeout(() => {
                var url = `${this.url}/validar_data`;
                axios.post(url,{
                   'name': this.user.name,
                   'type_document': this.user.type_document, 
                   'num_document': this.user.num_document, 
                   'email': this.user.email, 
                   'num_phone': this.user.num_phone, 
                   'address': this.user.address,
                   'user_id': this.currentUser.id
                }).then(response =>{
                    console.log(response.data)
                    // this.setFocus();
                    resolve(true)
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        console.log(this.errors)
                        toastr.error("ERROR - En la validaciones.");
                        reject(this.errors);
                    }
                });   
            }, 1000)
          })
        },
        validateTab2:function() {
            return new Promise((resolve, reject) => {
                if(this.validPass == true || this.user.password == ''){  
                        setTimeout(() => {
                            var url = `${this.url}/validar_pass`;
                            axios.post(url,{
                            'password': this.user.password,
                            }).then(response =>{
                                console.log(response.data)
                                // this.setFocus();
                                resolve(true)
                            }).catch(error => {
                                if (error.response.status == 422) {
                                    this.errors = error.response.data.errors;
                                    console.log(this.errors)
                                    toastr.error("ERROR - En la validaciones.");
                                    reject(this.errors);
                                }
                            });   
                        }, 1000)
                }else{
                    toastr.error("ERROR - En la validaciones.");
                    reject(this.errorPass);
                }
            });
        },
        validateTab3:function() {
            return new Promise((resolve, reject) => {
                if(this.role.name){
                    console.log(this.role)
                    resolve(true);
                }else{
                    toastr.error("ERROR - En la validaciones.");
                    reject(this.errorPass);
                }
            });
        },
        validatePass(){
            return new Promise((resolve, reject) => {
                if(this.user.password === this.password_confirmation && this.password_confirmation != ''){
                    this.errorPass = '';
                    this.errors = '';
                    this.validPass = true;
                    resolve(true);
                }else if(this.password_confirmation != ''){
                    this.errorPass = "Password no concuerda";
                    this.validPass = false;
                    reject(this.errorPass);
                }
            })    
        },
        storeUser(){
            let url = `${this.url}`;
            console.log(url)
            setTimeout(() => {
                axios.post(url,{
                    'name' : this.user.name,
                    'type_document' : this.user.type_document,
                    'num_document' : this.user.num_document,
                    'email' : this.user.email,
                    'num_phone': this.user.num_phone,
                    'address':this.user.address,
                    'password': this.user.password,
                    'user_id': this.currentUser.id,
                    'role': this.role.name,
                    'permissions' : this.permissions
                }).then(response =>{
                    console.log(response.data)
                    this.$router.push({ path: "/usuarios" });
                    toastr.success("El Usuario ha sido registrado.");
                }).catch(error => {
                    var error = error.response.data.errors;
                    this.errors = error;
                    toastr.error("ERROR - En la validaciones.");
                    console.log(this.errors)
                });
            }, 1000)
        },
        roleFind(roleName){
            if(roleName){
                this.role = {};
                this.role = this.roles.find(role => role.name == roleName);
                this.getPermissions(this.role.id)
                console.log(this.role.id)
            }else{
                this.role.description = '';
            }
            this.getRoles();
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
            this.permission = [];
            let url = `/api/auth/permisos/${rol}`
            // console.log(url)
            axios.get(url).then((response) => {
                let permissions = [];
                permissions = response.data;
                // console.log(permissions)
                permissions.forEach(element => {
                    // console.log(element.name)
                    this.permissions.push(element.name);
                });
            }) 
        },
    }
}
</script>