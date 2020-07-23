<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 
        <template v-if="!vincome">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        <h3 class="card-title" v-text="titlePage"><i class="fas fa-bars">&nbsp;</i></h3>
                        <a href="#" @click="createIncome()" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Ingreso</a>
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
                            <loading
                                :is-full-page="true"
                                :active.sync="isLoading">
                            </loading>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </template>

        <!-- Crear Ingreso -->
        <template v-else>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ title }}</h3>
                        <a href="#" @click="back_page()" class="btn btn-sm btn-primary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i>Regresar</a>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form-wizard
                                @on-complete="onComplete"
                                @on-loading="setLoading"
                                @on-validate="handleValidation"
                                @on-error="handleErrorMessage" 
                                next-button-text="Siguiente"
                                back-button-text="Regresar"
                                finish-button-text="Finalizar"
                                title="" subtitle=""
                                step-size="md"
                                color="#007bff" shape="square">

                                <tab-content title="Proveedor"  icon="ti-briefcase" :before-change="validateAsync">
                                    <income-provider></income-provider>
                                     <div @selected_provider="selectedProvider(data)"></div>   
                                </tab-content>
                                <tab-content title="Producto"  icon="ti-bag" :before-change="validateAsync">
                                    <div class="card card-default card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-industry">&nbsp;</i>Producto</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" @keyup="getDataProduct()" class="form-control text-center" id="input_focus" v-model="code" maxlength="13" placeholder="Ingrese Código del Producto" autocomplete="off">
                                                </div>     
                                            </div>            
                                        </div>
                                    </div>                
                                </tab-content>
                            </form-wizard>    
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>


            <!-- <product-create @returned="vincome = $event"
                :divisa="divisa"
                :categories="categories"
            ></product-create>    -->
        </template>
    
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import DataTableCurrencyCell from '../../components/DataTableCurrencyCell.vue';
import BtnProductsComponentVue from '../../components/BtnProductsComponent.vue';
import StatusComponentVue from '../../components/StatusComponent.vue';
Vue.use(DataTable);
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

// Vue-select
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

//wizard component
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

export default {
    components:{
        BtnProductsComponentVue,
        StatusComponentVue,
        FormWizard,
        TabContent,
        Loading
    },
    data(){
        return{
            data: {},
            url:"api/ingresos",
            titlePage:'Ingresos',
            routePage:'Ingresos',
            divisa: 0,
            vincome:false,
            create: false,
            title: 'Nuevo Ingreso',
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
                    label: 'Proveedor',
                    name: 'customer_name',
                    orderable: true,
                },
                {
                    label: 'Tipo Doc',
                    name: 'type_voucher',
                    orderable: true,
                },
                {
                    label: 'N° Factura',
                    name: 'num_voucher',
                    orderable: true,
                },
                {
                    label: 'N° Comprobante',
                    name: 'num_bill',
                    orderable: true,
                },
                {
                    label: 'Monto',
                    name: 'total',
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
            product_id: 0,
            images:[],
            isLoading: false,
            loadingWizard: false,
            errorMsg: null,
            provider_id:0
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
        selectedProvider(data){
            console.log(data)
            this.product_id = data;
        },
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
        createIncome(){
            this.vincome = true;
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
        onComplete(){
            toastr["info"]("Formulario completado con exito..!!", "Nuevo Producto");
            setTimeout(() => {
            
            }, 1000)
            
        },
        setLoading: function(value) {
            this.loadingWizard = value
            console.log(this.loadingWizard)
        },
        handleValidation: function(isValid, tabIndex){
           console.log('Tab: '+tabIndex+ ' valid: '+isValid)
        },
        handleErrorMessage: function(errorMsg){
          this.errorMsg = errorMsg
        },
        validateAsync:function(product_id) {
          alert(product_id)       
          return new Promise((resolve, reject) => {
            setTimeout(() => {
                if(this.provider_id){
                    resolve(true)
                }else{
                    var errors = "validate";
                    toastr.error("ERROR - Debe seleccionar un Proveedor.");
                    reject(errors);
                }
            }, 1000)
          })
        },
        back_page(){
            this.vincome = false;
            this.$parent.reloadTable();
        }
    }
}
</script>
 <style>
 .vs__spinner {
    border-left-color: rgba(88,151,251,0.71);  
 }
 /* transition */
 .fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
 </style>