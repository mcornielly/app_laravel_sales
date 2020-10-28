<template>
    <div v-if="menus">
        <div class="row">
            <div class="col-12">
                <div class="card card-defaul card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> MENÚ</h3>
                        <!-- <a href="#" @click="createUser()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <div v-for="menu in menus" :key="menu.id">
                                    <ul class="list-group">
                                        <div v-for="permission in menu.permissions" :key="permission.id">
                                        <li class="list-group-item">{{ menu.name }} {{permission.name}} {{ checkedPermissions }}
                                        <!-- <div v-for="rolepermission in permissions" :key="rolepermission.id"> -->
                                            <div class="custom-control custom-switch float-right">
                                                <input type="checkbox" class="custom-control-input" :id="menu.name" :value="permission.name" v-model="checkedPermissions">
                                                <label class="custom-control-label" :for="menu.name"></label>
                                            </div>    
                                        <!-- </div>  -->
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
    </div>
</template>

<script>
    export default {
        name: 'role-permissions-app',
        data() {
            return {
                data:{},
                checkedPermissions:['view provider'],
                permissions:null,
                menus: null,
                errors: null,
                checked: ''
            }
        },
        created() {
            this.getMenu();
            this.getPermissions();
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
                    // console.log(response)
                    this.menus = response.data;
                    console.log(this.menus)
            

                }) 
            },
            getPermissions(){
                let url = `/api/auth/permisos/${this.$route.params.role}`
                console.log(url)
                axios.get(url).then((response) => {
                    // console.log(response)
                    this.permissions = response.data;
                    // console.log(this.permissions)
                }) 
            },
            updateRol(){
                let url = `/api/auth/roles/${this.$route.params.role}`
                console.log(url)
                setTimeout(() => {
                    this.$Progress.start()    
                    axios.put(url,{
                        id: this.$route.params.role,
                        name: this.rol.name,
                        display_name: this.rol.display_name
                    }).then((response) => {
                        console.log(response)
                        this.rol = response.data;
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