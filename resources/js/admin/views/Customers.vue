<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Clientes</h3>
                    <a href="#" @click="createCustomer()" data-toggle="modal" data-target="#modal-customer" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Cliente</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <data-table ref="tb"
                                :data="data"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                @onTablePropsChanged="reloadTable">
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
    
        <!-- Modal-Divisa -->
        <modal-customer
            :data="selectedRow"
            :title="title"
            :create="create"
            :action="action"
            :storeup="storeup"
        ></modal-customer>
        <!-- /.modal -->
    </section>
</template>

<script>


import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnCustomersComponentVue from '../../components/customers/BtnCustomersComponent.vue';
Vue.use(DataTable);
// Import component
// import Loading from 'vue-loading-overlay';
// // Import stylesheet
// import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        BtnCustomersComponentVue,
        // Loading
    },
    data(){
        return{
            titlePage:'Clientes',
            routePage:'Clientes',
            url:"api/clientes",
            divisa: '',
            create: false,
            title: '',
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
                    name: 'name',
                    orderable: true,
                },
                {
                    label: '',
                    name: 'type_document',
                    orderable: false,
                },
                {
                    label: 'N° RIF/CI',
                    name: 'num_document',
                    orderable: false,
                },
                {
                    label: 'N° Teléfono',
                    name: 'num_phone',
                    orderable: false,
                },
                {
                    label: 'Email',
                    name: 'email',
                    orderable: false,
                },
                {
                    label: 'Acciones',
                    name: '',
                    orderable: false,
                    component: BtnCustomersComponentVue,
                    event: "click",
                    handler: this.modalCustomer
                },

            ],
            selectedRow: {},
            clients: {},
            action: false,
            storeup: true,
            name: '',
            type_document: "",
            num_document: '',
            num_phone: '',
            email: '',
            address: '',
            name_contact: '',
            contact_phone: '',
            isLoading: false

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
        },
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
            },1000)
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
        createCustomer(){
            this.title = 'Nuevo Cliente';
            this.selectedRow = {};
            this.create = true;
            this.action = true;
            this.storeup = false;
        },
        modalCustomer(data, action){
            switch(action){
                case 'update':
                    {
                        this.title = 'Actualizar Cliente';
                        this.selectedRow = data;
                        this.create = false;
                        this.action = true;
                        this.storeup = false;
                        break; 
                    }
                case 'show':
                    {
                        this.title = "Detalle de Cliente";
                        this.selectedRow = data;
                        this.create = false;
                        this.action = false; 
                        this.storeup = true; 
                        break;
                    }
                case 'delete':
                    {                           
                        this.deleteProvider(data);
                        break;
                    }
                case 'restore':
                    {                           
                        this.restoreProvider(data);
                        break;
                    }
            }
        },
        deleteProvider(data){
            this.id = data.id;
            // console.log(this.id)
            let url = `${this.url}/${this.id}`;
            this.$Progress.start()
            setTimeout(() => {
                axios.delete(url,{
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }
                }).then(response => {
                    this.reloadTable();
                    this.destroy = false;
                    toastr.error('Lo Cliente fue eliminado.');
                    // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
                }).catch(error => {
                    console.log(error);
                    let errors = error.response.data.errors;
                    this.errors = errors;
                    this.$Progress.fail()
                });
                this.$Progress.finish() 
            },1000)
        },
        restoreProvider(data){
            this.id = data.id;
            let url = `/api/cliente/restore/${this.id}`;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url,{
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }
                }).then(response => {
                    this.reloadTable();
                    toastr.success('Lo Cliente fue restaurado.');
                    // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
                }).catch(error => {
                    console.log(error);
                    let errors = error.response.data.errors;
                    this.errors = errors;
                    this.$Progress.fail()
                });
                this.$Progress.finish() 
            },1000)
        }

    }
}
</script>
 