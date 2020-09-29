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
                        <h3 class="card-title" v-text="titlePage"><i class="fas fa-bars">&nbsp;</i></h3>
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
                                @onTablePropsChanged="reloadTable"
                                @loading="isLoading = true"
                                @finishedLoading="isLoading = false">
                            </data-table>
                            <!-- Animation -->
                            <!-- <loading
                                :is-full-page="true"
                                :active.sync="isLoading">
                            </loading> -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </template>

        <!-- Crear Producto -->
        <template v-else>
            <product-create @returned="vproducts = $event"
                :divisa="divisa"
                :categories="categories"
            ></product-create>   
        </template>
    

        <!-- Modal-Producto -->
        <modal-product
            :data="selectedRow"
            :divisa="divisa"
            :images="images"
            :categoryName="category"
            :categories="categories"
            :title="title"
            :action="action"
            :storeup="storeup"
        ></modal-product>
        <!-- /.modal -->
    </section>
</template>

<script>
import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnProductsComponentVue from '../../components/products/BtnProductsComponent.vue';
import StatusComponentVue from '../../components/layouts/StatusComponent.vue';
import DataTableCurrencyCell from '../../components/datatable/DataTableCurrencyCell.vue';
Vue.use(DataTable);
// // Import component
// import Loading from 'vue-loading-overlay';
// // Import stylesheet
// import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        BtnProductsComponentVue,
        StatusComponentVue,
        DataTableCurrencyCell,
        // Loading
    },
    data(){
        return{
            data: {},
            url:"api/productos",
            titlePage:'Productos',
            routePage:'Productos',
            name:'',
            category:{},
            divisa: 0,
            categories:[],
            vproducts:false,
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
                    label: 'Categoría',
                    name: 'category.name',
                    orderable: true,
                },
                {
                    label: 'Precio',
                    name: 'price',
                    orderable: true,
                    component: DataTableCurrencyCell
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
            product_id: 0,
            images:[],
            isLoading: false, 
        }
    },
    created(){
        this.getData(this.url);
        this.getDivisa();
        this.getCategories();
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
            },1000)
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
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
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
        createProduct(){
            if(this.divisa > 0){
                this.title = 'Nueva Producto'
                this.selectedRow = {};
                this.action = true;
                this.storeup = false;
                this.vproducts = true;
            }else{
                toastr["info"]("Debe establecer el monto de la Divisa..!!", "Cotización de la Divisa");   
            }
        },
        modalProduct(data, action){
            if(this.divisa > 0){
                switch(action){
                        case 'edit':
                            {
                                this.title = 'Editar Producto';
                                this.selectedRow = data;
                                this.product_id = data.id;
                                this.getImages(this.product_id); 
                                this.action = true;
                                this.storeup = false;
                                break;
                            }
                        case 'show':
                            {
                                this.title = "Detalle de Producto";
                                this.selectedRow = data;
                                this.product_id = data.id;
                                this.getImages(this.product_id); 
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
            }else{
                toastr["info"]("Debe establecer el monto de la Divisa..!!", "Cotización de la Divisa");
                $('#modal-product').modal('hide'); 
            }
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
 