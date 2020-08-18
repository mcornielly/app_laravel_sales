<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 
        <template v-if="vincome==1">
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
        <template v-else-if="vincome==2">
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

                                <tab-content title="Proveedor"  icon="ti-briefcase" :before-change="validateProvider">
                                    <income-provider @selectedProvider="provider = $event"></income-provider>
                                </tab-content>

                                <tab-content title="Producto" icon="ti-bag" :before-change="validateProduct">
                                    <income-product :divisa="divisa" :typeCurrency="typeCurrency" @addProduct="detail_incomes = $event"></income-product>
                                </tab-content>

                                <tab-content title="Ingreso" icon="ti-receipt" :before-change="validateInvoice">
                                    <income-invoice :detail_incomes="detail_incomes" 
                                    :iva="iva"
                                    :provider="provider"
                                    :typeCurrency="typeCurrency" 
                                    @selectType="type_voucher = $event" 
                                    @numVoucher="num_voucher = $event"
                                    @numBill="num_bill = $event"
                                    @invoiceTotal="total = $event"
                                    @tax="iva = $event"></income-invoice>
                                </tab-content>

                            </form-wizard>    
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </template>

        <!-- Detail Income -->
        <template v-else>
                <div id="canvas" class="invoice p-3 mb-3">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ title }} | {{ income.num_voucher }}</h3>
                        <a href="#" @click="back_page()" class="btn btn-sm btn-primary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i>Regresar</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    Proveedor:
                                    <address>
                                        <strong>{{ income.customer_name }}</strong><br>
                                        {{ income.address }}<br>
                                        <b>Phone: </b> <span> {{ income.num_phone }}</span> <br>
                                        <b>Email: </b> <span> {{ income.email }}</span>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                <b>N° <span>{{ income.type_voucher }}</span> <span>#{{ income.num_voucher }}</span> </b><br>
                                <br>
                                <b>N° Comprobante :</b> <span>{{ income.num_bill }}</span><br>
                                <b>Fecha de Pago :</b> <span>{{ income.created_at }}</span><br>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Cantidad </th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(detail_income, index) in detail_incomes" :key="detail_income.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ detail_income.code }}</td>
                                    <td>{{ detail_income.name }}</td>
                                    <td>{{ detail_income.quantity }}</td>
                                    <td>{{ detail_income.price | currency }}</td>
                                    <td>{{ detail_income.price * detail_income.quantity | currency }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">

                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                <p class="lead">Balance </p>

                                <div class="table-responsive">
                                    <table class="table">
                                    <tbody><tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ calculateTotal-totalTax | currency }}</td>
                                    </tr>
                                    <tr>
                                        <th>IVA <span>({{ income.tax*100/100 }}%)</span></th>
                                        <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ totalTax=total*income.tax/100 | currency }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ total=calculateTotal | currency}}</td>
                                    </tr>
                                    </tbody></table>
                                </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" @click="createPDF()">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
        </template>

    </section>
</template>

<script>



import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import DataTableCurrencyCell from '../../components/DataTableCurrencyCell.vue';
import BtnIncomesComponentVue from '../../components/BtnIncomesComponent.vue';
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

import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

export default {
    components:{
        BtnIncomesComponentVue,
        StatusComponentVue,
        DataTableCurrencyCell,
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
            vincome: 1,
            typeCurrency: 'Bs.',
            create: false,
            title: 'Nuevo Ingreso',
            id:0,
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
                    component: BtnIncomesComponentVue,
                    event: "click",
                    handler: this.selectAction
                },

            ],
            selectedRow: {},
            action: false,
            storeup: true,
            isLoading: false,
            loadingWizard: false,
            errorMsg: null,
            provider: {},
            income: {},
            products: [],
            detail_incomes: [],
            type_voucher: '',
            num_bill:'',
            num_voucher:'',
            total: 0.00,
            totalTax: 0.00,
            iva:16
        }
    },
    created(){
        this.getData(this.url);
        this.getDivisa();
    },
    computed:{
        user(){
            let user = document.head.querySelector('meta[name="user"]');
            return JSON.parse(user.content);
        },
        calculateTotal: function(){
            var result = 0.0;
            for(var i=0; i<this.detail_incomes.length; i++){
                result = result+(this.detail_incomes[i].price*this.detail_incomes[i].quantity)
            }
            return result;
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
        getDivisa(){
            var url = "api/divisa/precio";
            axios.get(url).then(response => {
                this.divisa = response.data;
                console.log(this.divisa);
            }).catch(error =>{
                console.log(error.response.data);
            });
        },
        createIncome(){
            if(this.divisa > 0){
                this.vincome = 2;
            }else{
                toastr["info"]("Debe establecer el monto de la Divisa..!!", "Cotización de la Divisa");    
            }
        },
        onComplete(){
            toastr["info"]("Ingreso de Productos completados con exito..!!", "Comprobante de Ingreso");
            setTimeout(() => {
                this.storeIncome();
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
        validateProvider:function() {
            console.log(this.provider)
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                if(Object.keys(this.provider).length > 0){
                    resolve(true)
                }else{
                    var errors = "validate";
                    toastr.error("ERROR - Debe seleccionar un Proveedor.");
                    reject(errors);
                }
            }, 1000)
          })
        },
        validateProduct(){
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                if(this.detail_incomes.length > 0){
                    resolve(true)
                }else{
                    var errors = "validate";
                    toastr.error("ERROR - Debe agregar los productos.");
                    reject(errors);
                }
            }, 1000)
          })
        },
        validateInvoice(){
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                if(this.num_bill != '' && this.type_voucher != ''){
                    resolve(true)
                }else{
                    var errors = "validate";
                    toastr.error("ERROR - Debe completar los campos.");
                    reject(errors);
                }
            }, 1000)
          }) 
        },
        selectAction(data, action){
            switch(action){
                case 'show':
                    {
                        this.title = "Ingreso";
                        this.id = data.id;    
                        this.vincome = 3;
                        this.income = data;
                        this.showIncome(this.id);
                        break;
                    }
                case 'delete':
                    {         
                        this.id = data.id;                   
                        this.deleteIncome(this.id);
                        break;
                    }
            }
        },
        storeIncome(){
                var url = `api/ingreso`;
                axios.post(url,{
                    'provider_id' : this.provider.id,
                    'user_id': this.user.id,
                    'type_voucher' : this.type_voucher,
                    'num_voucher' : this.num_voucher,
                    'num_bill' : this.num_bill,
                    'tax':this.iva,
                    'total':this.total,
                    'detail_incomes': this.detail_incomes
                }).then(response =>{
                    console.log(response.data)
                    this.back_page();
                    toastr.success("El Ingreso ha sido registrado.");
                }).catch(error => {
                    var error = error.response.data.errors;
                    this.errors = error;
                    toastr.error("ERROR - En la validaciones.");
                    console.log(this.errors)
                });

        },
        showIncome(id){
                var url = `api/ingreso/detalles/${id}`;
                axios.get(url).then(response =>{
                    this.detail_incomes = response.data.detail_incomes;
                    console.log(this.detail_incomes);
                }).catch(error => {
                    var error = error;
                    this.errors = error;
                    toastr.error("ERROR - En la validaciones.");
                    console.log(this.errors)
                });
        },
        deleteIncome(id){
            var url = `/api/ingreso/anular/${id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                toastr.error('El ingreso fue anulado.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");

            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        back_page(){
            this.vincome = 1;
            this.reloadTable();
        },  
        createPDF(){
            window.open('api/ingreso/pdf/' + this.id);
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