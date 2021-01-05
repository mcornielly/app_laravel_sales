<template>
    <div>
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
                                <div v-if="role_name == 'admin'">
                                    <ul class="list-group">
                                        <div v-for="permission in menu.menupermissions" :key="permission.id">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <h6 class="col-sm-3 text-bold">{{ menu.name }}</h6>
                                                    <h6 class="col-sm-7 text-secundary text-muted text-left">{{ permission.display_name }}</h6>
                                                    <div class="col-sm-2 custom-control custom-switch text-right">
                                                        <input type="checkbox" class="custom-control-input" :id="menu.name" :value="permission.name" v-model="name_permission">
                                                        <!-- <input type="checkbox" class="custom-control-input" :id="menu.name" :value="permission.name" @click.prevent="addMain(permission.name)" v-model="name_permission"> -->
                                                        <label class="custom-control-label" :for="menu.name"></label>
                                                    </div>    
                                                </div>
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                                <div v-else-if="menu.name != 'Accesos'">
                                    <ul class="list-group">
                                        <div v-for="permission in menu.menupermissions" :key="permission.id">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <h6 class="col-sm-3 text-bold">{{ menu.name }}</h6>
                                                    <h6 class="col-sm-7 text-secundary text-muted text-left">{{ permission.display_name }}</h6>
                                                    <div class="col-sm-2 custom-control custom-switch text-right">
                                                        <input type="checkbox" class="custom-control-input" :id="menu.name" :value="permission.name" v-model="name_permission">
                                                        <!-- <input type="checkbox" class="custom-control-input" :id="menu.name" :value="permission.name" @click.prevent="addMain(permission.name)" v-model="name_permission"> -->
                                                        <label class="custom-control-label" :for="menu.name"></label>
                                                    </div>    
                                                </div>
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                                
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
            <div v-if="menus_per.name != 'Dashboard'">
            <div v-if="menus_per.hierarchy == 0" class="row">
                <div class="col-12">
                    <div v-if="role_name == 'admin'">
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
                                                                                            <input type="checkbox" class="custom-control-input" :id="submenu_per.id" :value="submenu_per.name" v-model="name_permission">
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
                                                                <input type="checkbox" class="custom-control-input" :id="menu_permissions.id" :value="menu_permissions.name" v-model="name_permission">
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
                        </div>    
                    </div>
                    <div v-else-if="menus_per.name != 'Accesos'">
                        <div  class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title text-muted"><i v-html="menus_per.icon"></i>{{ menus_per.name }} </h3>
                                <!-- <a href="#" @click="createUser()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a> -->
                            </div>
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
                                                                                            <input type="checkbox" class="custom-control-input" :id="submenu_per.id" :value="submenu_per.name" v-model="name_permission">
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
                                                                <input type="checkbox" class="custom-control-input" :id="menu_permissions.id" :value="menu_permissions.name" v-model="name_permission">
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
                        </div>
                        <!-- /.card-body -->
                    </div>    
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'permissions-component',
        props: [
            'permissions',
            'role_name',
            'menus',
            'menus_all',
            'sub_menus'
        ],
        created(){
            console.log(this.permissions)
        },
        computed:{
            name_permission:{
                get(){
                    return this.permissions;
                },
                set(newValue){
                    this.$emit("update-permissions", newValue);
                    return newValue;
                }
            }
        }

    }
</script>
