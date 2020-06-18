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
import BtnCategoryComponentVue from '../../components/BtnCategoryComponent.vue';
import StatusComponentVue from '../../components/StatusComponent.vue';
Vue.use(DataTable);

export default {
    components:{
        BtnCategoryComponentVue,
        StatusComponentVue
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
                    handler: this.modalCategory
                },

            ],
            selectedRow: {},
            action: false,
            storeup: true,
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
        createCategory(){
            this.title = 'Nueva Categoría'
            this.selectedRow = {},
            this.create = true;
            this.action = true;
            this.storeup = false;
        },
        modalCategory(data, action){
            switch(action){
    			    case 'edit':
                        {
                            this.title = 'Editar Categoría';
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
            var url = `/api/categoria/${this.id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                this.destroy = false;
                toastr.error('La categoría fue eliminada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");

            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        restoreCategory(data){
            this.id = data.id;
            var url = `/api/categoria/restore/${this.id}`;
            axios.get(url).then(response => {
                this.reloadTable();
                toastr.success('La categoría fue restaurada.');
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
 