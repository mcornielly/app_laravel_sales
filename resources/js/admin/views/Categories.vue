<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Categorías</h3>
                    <a href="#" @click="createCategory()" data-toggle="modal" data-target="#modal-category" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Categoría</a>
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
        <modal-category
            :data="selectedRow"
            :title="title"
            :create="create"
            :action="action"
            :storeup="storeup"
        ></modal-category>
        <!-- /.modal -->
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnCategoryComponentVue from '../../components/categories/BtnCategoryComponent.vue';
import StatusComponentVue from '../../components/layouts/StatusComponent.vue';
Vue.use(DataTable);
// // Import component
// import Loading from 'vue-loading-overlay';
// // Import stylesheet
// import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        BtnCategoryComponentVue,
        StatusComponentVue,
        // Loading
    },
    data(){
        return{
            titlePage:'Categorías',
            routePage:'Categorías',
            url:"api/categorias",
            divisa: '',
            name:'',
            description: '',
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
                    label: 'Descripción',
                    name: 'description',
                    orderable: true,
                },
                {
                    label: 'Estatus',
                    component: StatusComponentVue,
                    orderable: true,
                },
                {
                    label: 'Acciones',
                    name: '',
                    orderable: false,
                    component: BtnCategoryComponentVue,
                    event: "click",
                    handler: this.selectAction
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
        //     return JSON.parse(user.content);
        // },
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
            },1000)
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
        createCategory(){
            this.title = 'Nueva Categoría'
            this.selectedRow = {},
            this.create = true;
            this.action = true;
            this.storeup = false;
        },
        selectAction(data, action){
            switch(action){
                case 'update':
                    {
                        this.title = 'Actualizar Categoría';
                        this.selectedRow = data;
                        this.create = false;
                        this.action = true;
                        this.storeup = false;
                        break; 
                    }
                case 'show':
                    {
                        this.title = "Detalle de Categoría";
                        this.selectedRow = data;
                        this.create = false;
                        this.action = false; 
                        this.storeup = true; 
                        break;
                    }
                case 'delete':
                    {                           
                        this.deleteCategory(data);
                        break;
                    }
                case 'restore':
                    {                           
                        this.restoreCategory(data);
                        break;
                    }
            }
        },
        deleteCategory(data){
            this.id = data.id;
            console.log(this.id)
            var url = `${this.url}/${this.id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                this.destroy = false;
                toastr.error('La categoría no deshabilitada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");

            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        restoreCategory(data){
            this.id = data.id;
            var url = `${this.url}/restore/${this.id}`;
            axios.get(url).then(response => {
                this.reloadTable();
                toastr.success('La categoría fue habilitada.');
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
 