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
            <tab-content title="Rol del Usuario"  icon="ti-shield" :before-change="validateTab1">
                <div class="card card-default card-default">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-shield">&nbsp;</i> Datos del Rol</h3>
                    </div>
                    <!-- /.card-header -->                  
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Nombre</label>
                            <div class="input-group col-md-9">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                </div>
                                <input type="text" maxlength="8" class="form-control text-capitalize" :class="{'is-invalid' : errors.name}" placeholder="Ingrese Nombre del Rol" v-model="role.name">
                                <span v-if="errors.name" class="invalid-feedback text-danger" role="alert" v-html="errors.name[0]"></span>
                                <div class="col-md-12">
                                    <span class="text-muted" role="alert"><small>Ej. Administrador - admin </small></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Rol</label>
                                <div class="input-group col-md-9">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors.display_name}" placeholder="Ingrese Nombre Administrativo del Rol" v-model="role.display_name">
                                <span v-if="errors.display_name" class="invalid-feedback text-danger" role="alert" v-html="errors.display_name[0]"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Descripción</label>
                            <div class="col-md-9">
                            <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors.description}" cols="60" rows="3" v-model="role.description" placeholder="Ingrese Descripción del Rol"></textarea>
                            <span v-if="errors.description" class="invalid-feedback text-danger" role="alert" v-html="errors.description[0]"></span>
                            </div>
                        </div>  
                    </div>
                </div>
            </tab-content> 
            <!-- Permisos del Rol -->
            <tab-content title="Permisos del Usuario" icon="ti-panel" :before-change="validateTab2">
                <div class="card card-default card-default">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-user-cog">&nbsp;</i> Permisos del Usuario</h3>
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
        <!-- <div class="modal-footer clearfix pb-0"> -->
            <!-- <router-link title="regresar" class="btn btn-default btn-sm" to="/roles"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link> -->
            <!-- <button type="button" title="actualizar" class="btn btn-info btn-block" @click.prevent="storeRole()" data-dismiss="modal" data-backdrop="false">Guardar</button> -->
        <!-- </div> -->
    </section>
</template>
<script>

export default {
    name: 'role-create-app',
    data(){
        return {
            titlePage:'Roles',
            routePage:'Rol',
            title:'Nuevo Rol',
            url:'/api/auth/roles',
            role:{
                name:'',
                display_name:'',
                description:'',
                guard_name: 'api'

            },
            menus: null,
            menus_all: null,
            sub_menus: null,
            permissions: [],
            errors:'',
            error_flash:'Debe Seleccionar los permisos correspondiente para poder crear el Rol.'
        }
    },
    created(){
        this.$emit('title', this.title);
        this.$emit('path', this.$route.path);
        this.getMenu();
        // this.getRoles();
    },
    methods:{
        onComplete(){
            toastr["info"]("Formulario completado con exito..!!", "Nuevo Rol");
            setTimeout(() => {
                this.storeRole();
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
                    'name' : this.role.name,
                    'display_name' : this.role.display_name,
                    'description' : this.role.description,
                    'guard_name' : this.role.guard_name,
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
                if(this.permissions.length > 0){
                    resolve(true);
                }else{
                    toastr.error("ERROR - En la validaciones.");
                    this.$emit('errorFlash', this.error_flash);
                       $("html, body").animate({ scrollTop: 0 }, "slow");
                    // $(window).scrollTop(0);
                    reject(this.errorPass);
                }
          })
        },
        storeRole(){
            let url = `${this.url}`;
            setTimeout(() => {
                axios.post(url,{
                    'name' : this.role.name,
                    'display_name' : this.role.display_name,
                    'description' : this.role.description,
                    'guard_name' : this.role.guard_name,
                    'permissions' : this.permissions
                }).then(response =>{
                    console.log(response.data)
                    this.$router.push({ path: "/roles" });
                    toastr.success("El Rol ha sido registrado.");
                }).catch(error => {
                    var error = error.response.data.errors;
                    this.errors = error;
                    toastr.error("ERROR - En la validaciones.");
                    console.log(this.errors)
                });
            }, 1000)
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
    }
}
</script>