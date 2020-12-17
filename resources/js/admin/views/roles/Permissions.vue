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
        <permissions-component
            :permissions="permissions"
            :menus="menus"
            :menus_all="menus_all"
            :sub_menus="sub_menus"
            @update-permissions="permissions = $event"
        ></permissions-component>
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