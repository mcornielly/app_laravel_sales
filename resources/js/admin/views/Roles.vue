<template>
    <section>
        <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Lista Roles</h3>
                    <a href="#" @click="createUser()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <data-table
                                :data="data"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                @onTablePropsChanged="reloadTable"
                                @loading="isLoading = true"
                                @finishedLoading="isLoading = false">
                            </data-table>
                            <!-- Animation -->
                            <!-- <loading
                                :is-full-page="true"
                                :active.sync="isLoading">
                            </loading> -->
                        </template>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </section>
</template>

<script>

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);
// Import component
export default {
    name: 'app-roles',
    components:{
        // Loading
    },
    data() {
        return {
            url:"api/auth/roles",
            titlePage:'Roles',
            routePage:'Roles',
            create:false,
            title: '',
            display_name: '',
            errors: '',
            data: {},
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'desc',
            },
            translate:{
                nextButton: 'Siguiente', 
                previousButton: 'Anterior', 
                placeholderSearch: 'Buscar..'
            },
            theme: "dark",
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Nombre',
                    name: 'display_name',
                    orderable: true,
                },
                {
                    label: 'Fecha',
                    name: 'created_at',
                    orderable: true,
                },
            ],
            selectedRow: {},
            action: false,
            storeup: true,
            // isLoading: false

        }
    },
    created(){
        this.getData(this.url);
    },
    computed:{
        // user(){
        //     let user = document.head.querySelector('meta[name="user"]');
        //     return JSON.parse(user.content);
        // }
        currentUser() {
            console.log(this.$store.getters.currentUser)
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
            // this.isLoading = true;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url, {
                    params: options,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }
                })
                .then(response => {
                    this.data = response.data;
                    console.log(this.data)
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                    this.$Progress.fail()
                })
            // this.isLoading = false;
            this.$Progress.finish()
            }, 1000);
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
        createUser(){
            this.title = 'Nuevo Usuario'
            this.create = true
        },
        actionDivisa(action){
            if(action == "store"){
                this.storeDivisa();
            }else{
                this.updateDivisa();
            }
        },
        storeDivisa(){
            var url = "/api/divisas";
            axios.post(url,{
                'price': this.price, 
                'user_id': this.user.id 
            }).then(response => {
                console.log(response.data)
                this.getData();
                toastr.success('El Precio de la Divisa fue registrado.');
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
                $('#modal-divisas').modal('show');
            });
        },
        updateDivisa(){
            var url = `/api/divisa/${this.id}`;
            axios.put(url,{
                'id': this.id,
                'price':this.price,
                'user_id': this.user_id,
            }).then(response => {
                this.getDivisas();
                this.closeModal();
                toastr.info('El Precio de la Divisa fue actualizado.');
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
                $('#modal-divisas').modal('show');
            });
        }
    }
}
</script>