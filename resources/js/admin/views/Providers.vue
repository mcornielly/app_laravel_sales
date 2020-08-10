<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Proveedores</h3>
                    <a href="#" @click="createProvider()" data-toggle="modal" data-target="#modal-provider" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Proveedor</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <data-table ref="tb"
                                :data="data"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                @onTablePropsChanged="reloadTable"
                                @loading="isLoading = true"
                                @finishedLoading="isLoading = false">
                            </data-table>
                            <!-- Animation -->
                            <loading
                                :is-full-page="true"
                                :active.sync="isLoading">
                            </loading>
                        </template>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    
        <!-- Modal- Provider -->
        <modal-provider
            :data="selectedRow"
            :provider="provider"
            :title="title"
            :create="create"
            :action="action"
            :storeup="storeup"
        ></modal-provider>
        <!-- /.modal -->
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnProvidersComponentVue from '../../components/BtnProvidersComponent.vue';
Vue.use(DataTable);
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        BtnProvidersComponentVue,
        Loading
    },
    data(){
        return{
            data: {},
            url:"api/proveedores",
            titlePage:'Proveedores',
            routePage:'Proveedores',
            title: '',
            name: '',
            type_document: "",
            num_document: '',
            num_phone: '',
            email: '',
            address: '',
            name_contact: '',
            contact_phone: '',
            divisa: '',
            create: false,
            errors: '',
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
                    orderable: false,
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
                    component: BtnProvidersComponentVue,
                    event: "click",
                    handler: this.selectAction
                },

            ],
            selectedRow: {},
            provider: {},
            action: false,
            storeup: true,
            isLoading: false
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
            this.isLoading = true;
            setTimeout(() => {
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
            this.isLoading = false;
            },1000)
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
        createProvider(){
            this.title = 'Nuevo Proveedor';
            this.selectedRow = {};
            this.provider = {};
            this.create = true;
            this.action = true;
            this.storeup = false;
        },
        selectAction(data, action){
            this.type_document = data.type_document;
            switch(action){
    			    case 'edit':
                        {
                            this.title = 'Editar Proveedor';
                            this.selectedRow = data;
                            this.provider = data;
                            this.create = false;
                            this.action = true;
                            this.storeup = false;
                            break; 
                        }
                    case 'show':
                        {
                            this.title = "Detalle de Proveedor";
                            this.selectedRow = data;
                            this.provider = data;
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
            var url = `/api/proveedor/${this.id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                this.destroy = false;
                toastr.error('Lo Proveedor fue eliminada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");

            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        restoreProvider(data){
            this.id = data.id;
            var url = `/api/proveedor/restore/${this.id}`;
            axios.get(url).then(response => {
                this.reloadTable();
                toastr.success('Lo Proveedor fue restaurada.');
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
 