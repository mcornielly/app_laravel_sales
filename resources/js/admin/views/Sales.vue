<template>
    <section>
    <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header --> 
        <template v-if="vsale==1">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        <h3 class="card-title" v-text="titlePage"><i class="fas fa-bars">&nbsp;</i></h3>
                        <a href="#" @click="createSale()" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Venta</a>
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

        <!-- Crear Venta-->
        <template v-else-if="vsale==2">
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

                                <tab-content title="Cliente"  icon="ti-id-badge" :before-change="validateCustomer">
                                    <sale-customer @selectedCustomer="customer = $event"></sale-customer>
                                </tab-content>

                                <tab-content title="Producto" icon="ti-bag" :before-change="validateProduct">
                                    <sale-product :divisa="divisa" :typeCurrency="typeCurrency" @addProduct="detail_sales = $event"></sale-product>
                                </tab-content>
                                
                                <tab-content title="Ingreso" icon="ti-receipt" :before-change="validateInvoice">
                                    <sale-invoice :detail_sales="detail_sales"
                                    :errors="errors"
                                    :iva="iva" 
                                    :customer="customer"
                                    :typeCurrency="typeCurrency" 
                                    @selectType="type_voucher = $event" 
                                    @numVoucher="num_voucher = $event"
                                    @numBill="num_bill = $event"
                                    @invoiceTotal="total = $event"
                                    @tax="iva = $event"></sale-invoice>
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

        <!-- Detail Sale -->
        <template v-else>
            <div id="canvas" class="invoice p-3 mb-3">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ title }} | {{ sale.num_voucher }} | 
                    </h3>
                    <a href="#" @click="back_page()" class="btn btn-sm btn-primary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i>Regresar</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <b>Cliente:</b> <span>{{ customer.name }}</span><br>
                                <hr>
                                <address>
                                    {{ customer.address }}<br>
                                    <b>Phone: </b> <span> {{ customer.num_phone }}</span> <br>
                                    <b>Email: </b> <span> {{ customer.email }}</span>
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                            <b>N° <span>{{ sale.type_voucher }}</span> <span>#{{ sale.num_voucher }}</span> </b>
                            <span v-if="sale.status=='ANULADO'" class="badge badge-danger" v-text="sale.status" style="width: 100%;"></span>
                            <span v-else class="badge badge-success" v-text="sale.status" style="width: 100%;"></span><br>
                            <br>
                            <b>N° Comprobante :</b> <span>{{ sale.num_bill }}</span><br>
                            <b>Fecha de Pago :</b> <span>{{ sale.created_at }}</span><br>
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
                                        <th>Tipo Venta</th>
                                        <th>Cantidad </th>
                                        <th>Pack</th>
                                        <th>Precio</th>
                                        <th>% Descuento</th>
                                        <th style="text-align: center;">Sub-Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(detail_sale, index) in detail_sales" :key="detail_sale.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ detail_sale.code }}</td>
                                        <td>{{ detail_sale.name }}</td>
                                        <td>{{ detail_sale.type_sale }}</td>
                                        <td class="text-center">{{ detail_sale.quantity }}</td>
                                        <td class="text-center">
                                            <div v-if="detail_sale.type_sale=='Venta Mayor'">
                                                {{ detail_sale.quantity/detail_sale.wholesale_quantity }}
                                            </div>
                                            <div v-else>
                                                {{ 0 }}
                                            </div>
                                        </td>
                                        <td>{{ detail_sale.price_sale | currency }}</td>
                                        <td style="text-align: center;">{{ parseFloat(detail_sale.discount).toFixed() }}</td>
                                        <td style="text-align: right;">
                                            <div v-if="detail_sale.type_sale=='Venta Mayor'">
                                                {{ (detail_sale.price_sale*(detail_sale.quantity/detail_sale.wholesale_quantity))-((detail_sale.price_sale*(detail_sale.quantity/detail_sale.wholesale_quantity))*(detail_sale.discount/100)) | currency }}
                                            </div>
                                            <div v-else>
                                                {{ (detail_sale.price_sale*detail_sale.quantity)-(detail_sale.price_sale*detail_sale.quantity*(detail_sale.discount/100)) | currency }}
                                            </div>
                                        </td>
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
                                    <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ sale.total-totalTax | currency }}</td>
                                </tr>
                                <tr>
                                    <th>IVA <span>({{ sale.tax*100/100 }}%)</span></th>
                                    <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ totalTax=sale.total*sale.tax/100 | currency }}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ sale.total | currency }}</td>
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
import BtnSalesComponentVue from '../../components/BtnSalesComponent.vue';
import StatusComponentVue from '../../components/StatusComponent.vue';
import DataTableCurrencyCell from '../../components/DataTableCurrencyCell.vue';
Vue.use(DataTable);
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        BtnSalesComponentVue,
        StatusComponentVue,
        DataTableCurrencyCell,
        Loading
    },
    data(){
        return{
            data: {},
            url:"api/ventas",
            titlePage:'Ventas',
            routePage:'Ventas',
            divisa: 0,
            typeCurrency: 'Bs.',
            name:'',
            vsale: 1,
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
                    label: 'Cliente',
                    name: 'customer.name',
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
                    component: BtnSalesComponentVue,
                    event: "click",
                    handler: this.selectAction
                },

            ],
            selectedRow: {},
            action: false,
            storeup: true,
            isLoading: false,
            loadingWizard: false,
            sale:{},
            detail_sales: [],
            customer:{},
            type_voucher: '',
            num_bill:'',
            num_voucher:'',
            total: 0.00,
            totalTax: 0.00,
            iva:16,
            errors: {
                num_bill:'',
                selected: ''
            }
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
        // calculateTotal: function(){
        //     var result = 0.0;
        //     var subtotal = 0;
        //     for(var i=0; i<this.detail_sales.length; i++){
        //         subtotal = result+(this.detail_sales[i].price_sale*this.detail_sales[i].quantity)-(this.detail_sales[i].price_sale*this.detail_sales[i].quantity*(this.detail_sales[i].discount/100));
        //         result = subtotal;
        //     }
        //     return result;
        // },
        // calculateDiscount: function(){
        //     var total_discount = 0.0;
        //     // var i = 0;
        //     total_discount = this.detail_sale.price*this.detail_sale.quantity*(this.detail_sale.discount/100);

        //     return total_discount;
        // },
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
        createSale(){
            if(this.divisa > 0){
                this.vsale = 2;
            }else{
                toastr["info"]("Debe establecer el monto de la Divisa..!!", "Cotización de la Divisa");  
            }
        },
        onComplete(){
            toastr["info"]("Venta de Productos completados con exito..!!", "Comprobante de Venta");
            setTimeout(() => {
                this.storeSale();
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
        validateCustomer:function() {
            // console.log(this.customer)
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                if(Object.keys(this.customer).length > 0){
                    resolve(true)
                }else{
                    var errors = "validate";
                    toastr.error("ERROR - Debe seleccionar un Cliemte.");
                    reject(errors);
                }
            }, 1000)
          })
        },
        validateProduct(){
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                if(this.detail_sales.length > 0){
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
                    var errors = 'validate';
                    toastr.error("ERROR - Debe completar los campos.");
                    reject(errors);
                    this.validateField();   
                }
            }, 1000)
          }) 
        },
        validateField(){
            if(!this.num_bill){
                this.errors.num_bill = 'Debe llenar el campo.';
            }
            if(!this.type_voucher){
                this.errors.type_voucher = 'Debe seleccionar el tipo de comprobante.';
            }
            console.log(this.errors)
        },
        selectAction(data, action){
            console.log(data.id)
            switch(action){
                case 'show':
                    {
                        this.title = "Venta";
                        this.id = data.id;    
                        this.vsale = 3;
                        this.showSale(this.id);
                        break;
                    }
                case 'delete':
                    {         
                        this.id = data.id;                   
                        this.deleteSale(this.id);
                        break;
                    }
                case 'pdf':
                    {         
                        this.id = data.id;                   
                        this.createPDF(this.id);
                        break;
                    }
            }
        },
        storeSale(){
            var url = `api/venta`;
            axios.post(url,{
                'customer_id' : this.customer.id,
                'user_id': this.user.id,
                'type_voucher' : this.type_voucher,
                'num_voucher' : this.num_voucher,
                'num_bill' : this.num_bill,
                'tax':this.iva,
                'total':this.total,
                'detail_sales': this.detail_sales
            }).then(response =>{
                console.log(response.data)
                this.errors = {};
                this.back_page();
                toastr.success("La Venta ha sido registrado.");
            }).catch(error => {
                var error = error.response.data.errors;
                this.errors = error;
                toastr.error("ERROR - En la validaciones.");
                console.log(this.errors)
            });
        },
        showSale(id){
            var url = `api/venta/${id}`;
            axios.get(url).then(response =>{
                this.detail_sales = response.data.detail_sales;
                this.sale = response.data.sale;
                this.customer = response.data.sale.customer;
            }).catch(error => {
                var error = error;
                this.errors = error;
                toastr.error("ERROR - En la validaciones.");
                console.log(this.errors)
            });
        },
        deleteSale(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
 
            swalWithBootstrapButtons.fire({
                title: '¿Esta seguro que desea anular la Venta.?',
                text: "Esta operación no podra ser reversada!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Anular!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var url = `/api/venta/anular/${id}`;
                    axios.delete(url).then(response => {
                        this.reloadTable();
                        // toastr.error('La Venta fue anulada.');
                        // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
                        swalWithBootstrapButtons.fire(
                        'Anulado!',
                        'El Comprobante de Venta ha sido Anulado.',
                        'success'
                        )
                        this.reloadTable();

                    }).catch(error => {
                        console.log(error);
                        var errors = error.response.data.errors;
                        this.errors = errors;
                    });
                
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'La Anulación de la Venta ha sido cancelada',
                    'error'
                    )
                }
            })    
        },
        back_page(){
            this.vsale = 1;
            this.reloadTable();
        },
        createPDF(){
            window.open('api/venta/pdf/' + this.id);
        }        

    }
}
</script>
 