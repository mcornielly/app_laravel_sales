<template>
    <div v-if="menus">
        <div class="row">
            <div class="col-12 pb-3">
                <router-link            
                    title="permisos"
                    :to="{path: '/roles'}"
                    class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i>Regresar
                </router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> MENÚ</h3>
                        <!-- <a href="#" @click="createUser()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <div v-for="menu in menus" :key="menu.id">
                                    <ul class="list-group">
                                        <div v-for="permission in menu.menupermissions" :key="permission.id">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <h6 class="col-sm-3 text-bold">{{ menu.name }}</h6>
                                                    <h6 class="col-sm-7 text-secundary text-muted text-left">{{ permission.display_name }}</h6>
                                                    <div class="col-sm-2 custom-control custom-switch text-right">
                                                        <input type="checkbox" class="custom-control-input" :id="menu.name" :value="permission.name" v-model="permissions">
                                                        <label class="custom-control-label" :for="menu.name"></label>
                                                    </div>    
                                                </div>
                                            </li>
                                        </div>
                                    </ul>
                                <div class="clearfix"></div>
                            </div>
                        </template>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <div v-for="menus_per in menus_all" :key="menus_per.id">
            <div v-if="menus_per.hierarchy == 0" class="row">
                <div class="col-12">
                    <div  class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title text-muted"><i v-html="menus_per.icon"></i>{{ menus_per.name }} </h3>
                            <!-- <a href="#" @click="createUser()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a> -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div v-for="menu_permissions in menus_per.permissions" :key="menu_permissions.id">
                                <template>
                                    <div v-for="submenu in sub_menus" :key="submenu.id">
                                        <div v-if="menus_per.id == submenu.hierarchy">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card card-primary card-outline">
                                                        <div class="card-header">
                                                            
                                                            <h3 class="card-title text-muted"><i v-html="submenu.icon"></i>{{ submenu.name }}</h3>
                                                        </div>
                                                        <div class="card-body">
                                                                <ul class="list-group">
                                                                    <div v-if="submenu.hierarchy > 0">
                                                                        <div v-for="submenu_per in submenu.permissions" :key="submenu_per.id">
                                                                            <li class="list-group-item">
                                                                                <div class="row">
                                                                                    <h6 class="col-sm-3 text-bold" v-if="submenu_per.name != 'sub-menu'">{{ submenu_per.display_name}}</h6>
                                                                                    <h6 class="col-sm-7 text-secundary text-muted text-left">{{ submenu_per.name }}</h6>
                                                                                    <div class="col-sm-2 custom-control custom-switch text-right">
                                                                                        <input type="checkbox" class="custom-control-input" :id="submenu_per.id" :value="submenu_per.name" v-model="permissions">
                                                                                        <label class="custom-control-label" :for="submenu_per.id"></label>
                                                                                    </div>    
                                                                                </div>
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                </ul>
                                                                <!-- </div> -->
                                                            <div class="clearfix"></div> 
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <ul class="list-group">
                                            <div v-if="menu_permissions.option != 'menu'">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <h6 class="col-sm-3 text-bold">{{  menu_permissions.display_name }}</h6>
                                                        <h6 class="col-sm-7 text-secundary text-muted text-left">{{ menu_permissions.name }}</h6>
                                                        <div class="col-sm-2 custom-control custom-switch text-right">
                                                            <input type="checkbox" class="custom-control-input" :id="menu_permissions.id" :value="menu_permissions.name" v-model="permissions">
                                                            <label class="custom-control-label" :for="menu_permissions.id"></label>
                                                        </div>    
                                                    </div>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>    
                                    <div class="clearfix"></div>
                                </template>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div class="row">
            <button class="btn btn-primary btn-sm btn-block" @click="updatePermissions(permissions)">Actualizar Permisos</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'role-permissions-app',
        data() {
            return {
                urlCurrrent: this.$route.path,
                data:{},
                permissions:[],
                menus: null,
                menus_all: null,
                sub_menus: null,
                errors: null,
                checked: true,
                urlCurrrent:''
            }
        },
        created() {
            this.getMenu();
            this.getPermissions();
            this.urlCurrrent = this.$route.path;
        },
        computed: {
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            getMenu(){
                let url = `/api/auth/menus`
                console.log(url)
                axios.get(url).then((response) => {
                    this.menus = response.data.menus;
                    this.menus_all = response.data.menus_all;
                    this.sub_menus = response.data.submenus;
                    // console.log(this.menus_all)
                }) 
            },
            getPermissions(){
                let url = `/api/auth/permisos/${this.$route.params.role}`
                console.log(url)
                axios.get(url).then((response) => {
                    // this.permissions = response.data;
                    // console.log(response.data)
                    let permissions = [];
                    permissions = response.data;
                    permissions.forEach(element => {
                        // console.log(element.name)
                        this.permissions.push(element.name);
                    });
                    // console.log(this.permission)
                }) 
            },
            updatePermissions(){
                console.log(this.permissions)
                let url = `/api/auth/roles/${this.$route.params.role}/permisos`
                console.log(url)
                setTimeout(() => {
                    this.$Progress.start()    
                    axios.put(url,{
                        id: this.$route.params.role,
                        permissions: this.permissions,
                    }).then((response) => {
                        console.log(response)
                        this.rol = response.data;
                        toastr.info('Los Permisos del Rol fueron actualizados.');
                        this.$router.push({ path: "/roles" });
                    }).catch(error => {
                        let errors = error.response.data.errors;
                        console.log(errors)
                        if (error.response.status == 422) {
                            this.errors = errors;
                            toastr.error("ERROR - En la validaciones.");
                        }
                        this.$Progress.fail()
                    })
                this.$Progress.finish()
                },1000)    
            }
            // permisos(id){
            //     let id = id;
            //     console.log(id)

            // }
        }
    }
</script>