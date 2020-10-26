<template>
    <div>
        <div class="row">
            <div class="col-12" v-for="menu in menus" :key="menu.id">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> 
                          Menú
                        </h3>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                     <ul class="list-group">
                       <li class="group-list-item">
                         {{ menu.name }} 
                       </li>
                     </ul>   
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
      <router-link class="btn btn-default btn-sm float-right" to="/roles"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link>
    </div>
</template>

<script>
    export default {
        name: 'role-view-app',
        data() {
            return {
                url:'/api/auth/menus',
                menus:null
            }
        },
        created() {
            this.getMenu();
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
                    console.log(response)
                    this.menus = response.data;
                }) 
            }
        }
    }
</script>