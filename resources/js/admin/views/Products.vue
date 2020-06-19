<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 
        <template v-if="!vproducts">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Productos - {{ vproducts }}</h3>
                        <a href="#" @click="createProduct()" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Producto</a>
                        <!-- <a v-if="!vproducts"  href="#" @click="createProduct()" data-toggle="modal" data-target="#modal-product" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Producto</a> -->
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                                <data-table ref="tb"
                                    :data="data"
                                    :theme="theme"
                                    :columns="columns"
                                    :translate="translate"
                                    @onTablePropsChanged="reloadTable">
                                </data-table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </template>

        <template v-else>
            <product-create @returned="vproducts = $event"
                :divisa="divisa"
                :categories="categories"
            ></product-create>   
        </template>
    
        <!-- Modal-Divisa -->
        <modal-product
            :data="selectedRow"
            :divisa="divisa"
            :categoryName="category"
            :categories="categories"
            :title="title"
            :create="create"
            :action="action"
            :storeup="storeup"
        ></modal-product>
        <!-- /.modal -->
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnProductsComponentVue from '../../components/BtnProductsComponent.vue';
import StatusComponentVue from '../../components/StatusComponent.vue';
Vue.use(DataTable);

export default {
    components:{
        BtnProductsComponentVue,
        StatusComponentVue,
    },
    data(){
        return{
            data: {},
            divisa: 0,
            categories:[],
            vproducts:false,
            titlePage:'Productos',
            routePage:'Productos',
            url:"api/productos",
            name:'',
            category:{},
            create: false,
            title: '',
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
                    label: 'Precio',
                    name: 'cost_price',
                    orderable: true,
                },
                {
                    label: 'Categoría',
                    name: 'category.name',
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
                    component: BtnProductsComponentVue,
                    event: "click",
                    handler: this.modalProduct
                },

            ],
            selectedRow: {},
            action: false,
            storeup: true,
        }
    },
    created(){
        this.getData(this.url);
        this.getDivisa();
        this.getCategories();
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        }
    },
    methods: {
        getDivisa(){
            var url = "api/divisa/precio";
            axios.get(url).then(response => {
                this.divisa = response.data;
                console.log(this.divisa);
            }).catch(error =>{
                console.log(error.response.data);
            });
        },
        getCategories(){
            var url = "api/categorias/lista";
            axios.get(url).then(response => {
                this.categories = response.data;
                console.log(this.categories)
            }).catch(error =>{
                console.log(error.response.data)
            });
        },
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
        createProduct(){
            this.title = 'Nueva Producto'
            this.selectedRow = {};
            this.create = true;
            this.action = true;
            this.storeup = false;
            this.vproducts = true;
        },
        modalProduct(data, action){
            switch(action){
    			    case 'edit':
                        {
                            this.title = 'Editar Producto';
                            this.selectedRow = data;
                            this.create = false;
                            this.action = true;
                            this.storeup = false;
                            break; 
                        }
                    case 'show':
                        {
                            this.title = "Detalle de Producto";
                            this.selectedRow = data;
                            this.category = data.category;
                            this.create = false;
                            this.action = false; 
                            this.storeup = true; 
                            break;
                        }
                    case 'delete':
                        {                           
                            this.deleteProduct(data);
                            break;
                        }
                    case 'restore':
                        {                           
                            this.restoreProduct(data);
                            break;
                        }
            }
        },
        deleteProduct(data){
            this.id = data.id;
            console.log(this.id)
            var url = `/api/producto/${this.id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                this.destroy = false;
                toastr.error('El producto fue eliminada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");

            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        restoreProduct(data){
            this.id = data.id;
            var url = `/api/producto/restore/${this.id}`;
            axios.get(url).then(response => {
                this.reloadTable();
                toastr.success('El producto fue restaurada.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        back_pag(){
            alert('hola');
            this.vproducts = false;
        }
        

    }
}
</script>
 