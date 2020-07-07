<template>
    <section>
        <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Cotización de la Divisa</h3>
                    <a href="#" @click="createDivisa()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a>
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
    
        <!-- Modal-Divisa -->
        <modal-divisa
            :amount="amount"
            :data="selectedRow"
            :title="title"
            :create="create"
        ></modal-divisa>
        <!-- /.modal -->
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnDivisaComponentVue from '../../components/BtnDivisaComponent.vue';
import ModalDivisaComponentVue from '../../components/ModalDivisaComponent.vue';
import DataTableCurrencyCell from '../../components/DataTableCurrencyCell.vue';
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(DataTable);

export default {
    components:{
        BtnDivisaComponentVue,
        DataTableCurrencyCell,
        ModalDivisaComponentVue
    },
    data() {
        return {
            amount: '',
            isLoading: false,
            url:"api/divisas",
            titlePage:'Divisa',
            routePage:'Divisa',
            create:false,
            title: '',
            price:'',
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
                    label: 'Precio Bs.',
                    name: 'price',
                    orderable: true,
                    component: DataTableCurrencyCell
                },
                {
                    label: 'Usuario',
                    name: 'user.name',
                    orderable: true,
                },
                {
                    label: 'Fecha',
                    name: 'created_at',
                    orderable: true,
                },
                {
                    label: 'Acciones',
                    name: '',
                    orderable: false,
                    event: "click",
                    component: BtnDivisaComponentVue,     
                    handler: this.editDivisa,
                },
            ],
            selectedRow: {},

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
        createDivisa(){
            this.title = 'Nuevo Precio de la Divisa'
            this.create = true
            $('#modal-divisas').on('shown.bs.modal', function() {
                $('#input_focus').focus();
            })
        },
        editDivisa(data) {
            console.log(data)
            this.title = 'Nuevo Precio de la Divisa'
            this.create = false
            this.selectedRow = data;
            this.amount = data.price;

        }
      
    }
}
</script>