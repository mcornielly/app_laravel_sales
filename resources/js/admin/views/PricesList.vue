<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 
        <template>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Lista de Precios</h3>
                        <!-- <a href="#" @click="createProduct()" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Producto</a> -->
                        <a href="#" @click="createProduct()" data-toggle="modal" data-target="#modal-ex" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Consultar Producto</a>
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

   
        <!-- Modal-Searh-Product -->
        <modal-searh-product></modal-searh-product>
        <!-- /.modal -->

        <!-- Modal-Show PricesList -->
        <modal-show-priceslist
            :data="selectedRow"
            :title="title"
            :images="images"
            :imgshow="imgshow"
        ></modal-show-priceslist>
        <!-- /.modal -->
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnProductsComponentVue from '../../components/BtnProductsComponent.vue';
import StatusComponentVue from '../../components/StatusComponent.vue';
import DataTableCurrencyCell from '../../components/DataTableCurrencyCell.vue';
import DataTableCurrencyWholesale from '../../components/DataTableCurrencyWholesale.vue';
import DataTableCurrencyUnit from '../../components/DataTableCurrencyUnit.vue';
import BtnPricesListComponent from '../../components/BtnPricesListComponent.vue';

Vue.use(DataTable);

// Registra una directiva personalizada global llamada `v-focus`
//  Vue.directive('focus', { inserted: function (el) { el.focus() } }) 

export default {
    components:{
        BtnProductsComponentVue,
        StatusComponentVue,
        DataTableCurrencyCell,
        DataTableCurrencyWholesale,
        DataTableCurrencyUnit,
        BtnPricesListComponent
    },
    data(){
        return{
            data: {},
            divisa: 0,
            code:'',
            titlePage:'Lista de Precios',
            routePage:'Lista de Precios',
            url:"api/productos",
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
                    label: 'Código',
                    name: 'code',
                    orderable: false,
                },
                {
                    label: 'Nombre',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Cant',
                    name: 'stock',
                    orderable: true,
                },
                {
                    label: 'P. Bs.',
                    name: 'price',
                    orderable: true,
                    component: DataTableCurrencyUnit
                },
                {
                    label: 'P. $',
                    name: 'divisa_unit',
                    orderable: true,
                },
                {
                    label: 'P. Mayor Bs.',
                    name: 'price_wholesale',
                    orderable: true,
                    component: DataTableCurrencyWholesale
                },
                {
                    label: 'P. Mayor $',
                    name: 'wholesale_divisa',
                    orderable: true,
                },
                {
                    label: 'Estatus',
                    component: StatusComponentVue,
                    orderable: true,
                },
                {
                    label: '',
                    name: '',
                    orderable: false,
                    component: BtnPricesListComponent,
                    event: "click",
                    handler: this.modalProduct
                },

            ],
            selectedRow: {},
            product_id: 0,
            images:[],
            imgshow:false
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
        searchCode(){
            alert(this.code)
            console.log(this.code)
        },
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

        },
        modalProduct(data){
            this.title = "Detalle de Producto";
            this.selectedRow = data;
            this.product_id = data.id;
            this.getImages(this.product_id); 
        },
        deleteProduct(data){
            this.id = data.id;
            console.log(this.id)
            var url = `/api/producto/eliminar/${this.id}`;
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
            this.vproducts = false;
        },
        getImages(product_id){
            var id = product_id;
            var url = `/api/producto/imagenes/${id}`;
            axios.get(url).then(response => {
                this.images = response.data;
                console.log( this.images)
            }).catch(error =>{
                console.log(error.response.data);
            });
        }
        

    }
}
</script>
 