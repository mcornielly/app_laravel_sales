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
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnCustomersComponentVue from '../../components/BtnCustomersComponent.vue';
Vue.use(DataTable);

export default {
    components:{
        BtnCustomersComponentVue,
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
            contact_phone: ''
        }
    },
    created(){
        this.getData(this.url);
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        }
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
            axios.get(url, {
                params: options
            })
            .then(response => {
                this.data = response.data;
                console.log(this.data)
            })
            // eslint-disable-next-line
            .catch(errors => {
                //Handle Errors
            })
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
    			    case 'edit':
                        {
                            this.title = 'Editar Cliente';
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
            console.log(this.id)
            var url = `/api/cliente/${this.id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                this.destroy = false;
                toastr.error('Lo Cliente fue eliminada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        restoreProvider(data){
            this.id = data.id;
            var url = `/api/cliente/restore/${this.id}`;
            axios.get(url).then(response => {
                this.reloadTable();
                toastr.success('Lo Cliente fue restaurada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        }

    }
}
</script>
 