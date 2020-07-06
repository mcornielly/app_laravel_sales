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
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Lista de Precios</h3>
                        <!-- <a href="#" @click="createProduct()" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Producto</a> -->
                        <a href="#" @click="createProduct()" data-toggle="modal" data-target="#modal-info" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Producto</a>
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

   
        <!-- Modal-Divisa -->
        <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">Info Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                        <label for="">Código del Producto</label>
                        <input type="text" class="form-control" id="input_focus" v-modal="code">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-light">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
        </div>
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

Vue.use(DataTable);

// Registra una directiva personalizada global llamada `v-focus`
 Vue.directive('focus', { inserted: function (el) { el.focus() } }) 

export default {
    components:{
        BtnProductsComponentVue,
        StatusComponentVue,
        DataTableCurrencyCell
    },
    data(){
        return{
            onFocus:false,
            data: {},
            divisa: 0,
            categories:[],
            vproducts:false,
            titlePage:'Lista de Precios',
            routePage:'Lista de Precios',
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
                    label: 'Cantidad',
                    name: 'stock',
                    orderable: true,
                },
                {
                    label: 'PV. Bs.',
                    name: 'price',
                    orderable: true,
                    component: DataTableCurrencyCell
                },
                {
                    label: 'PV. $',
                    name: 'divisa_unit',
                    orderable: true,
                    // component: DataTableCurrencyCell
                },
                {
                    label: 'PV. Mayor Bs.',
                    name: 'price_wholesale',
                    orderable: true,
                    // component: DataTableCurrencyCell
                },
                {
                    label: 'PV. Mayor $',
                    name: 'wholesale_divisa',
                    orderable: true,
                    // component: DataTableCurrencyCell
                },
                {
                    label: 'Estatus',
                    component: StatusComponentVue,
                    orderable: true,
                },
                // {
                //     label: 'Acciones',
                //     name: '',
                //     orderable: false,
                //     component: BtnProductsComponentVue,
                //     event: "click",
                //     handler: this.modalProduct
                // },

            ],
            selectedRow: {},
            action: false,
            storeup: true,
            product_id: 0,
            images:[]
        }
    },
    created(){
        this.getData(this.url);
        this.getDivisa();
        this.getCategories();
    },
    directives: {
        focus: {
            // Definición de directiva
            inserted: function (el) {
            el.focus()
            }
        }
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
            $('#modal-info').on('shown.bs.modal', function() {
                $('#input_focus').focus();
            })
            // this.onFocus=true;
            // this.$refs.input_focus.focus();
        },
        modalProduct(data, action){
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
 