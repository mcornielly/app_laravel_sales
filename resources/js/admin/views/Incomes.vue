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

        <!-- Crear Producto -->
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
                                        <div class="card card-default card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-industry">&nbsp;</i>Proveedor</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <v-select
                                                            ref="theSelect"
                                                            @search="selectProvider"
                                                            @input="setSelected"
                                                            v-model="selected"
                                                            :value="value.selected"
                                                            label="name"
                                                            :options="providers"
                                                            placeholder="Buscar Proveedores">
                                                            <span slot="no-options" @click="$refs.select.open=false">
                                                                Lo sentimos. No existe coincidencia, en la busqueda.
                                                            </span>
                                                        </v-select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success float-right" style="padding-top: 6px;">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch3" v-model="checked" @click="inputChange">
                                                            <label class="custom-control-label" for="customSwitch3">Nuevo Proveedor </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <transition name="fade">
                                                            <div v-show="checked">
                                                                <hr>
                                                                <form role="form" method="POST">
                                                                    <div id="form-provider">
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">Proveedor</label>
                                                                            <div class="col-md-9">
                                                                            <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Proveedor" v-model="provider.name" :disabled="storeup">
                                                                            <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.name[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">Tipo de Documento</label>
                                                                            <div class="col-md-9">
                                                                                <select class="form-control" :class="{'is-invalid' : errors}" v-model="provider.type_document" :disabled="storeup">
                                                                                    <option value="">Seleccione un Tipo de Documento</option>
                                                                                    <option>V</option>
                                                                                    <option>E</option>
                                                                                    <option>J</option>
                                                                                    <option>G</option>
                                                                                    <option>P</option>
                                                                                </select>
                                                                                <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.type_document[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">N° Documento</label>
                                                                            <div class="input-group col-md-9">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="far fa-address-card"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese N° Docuemnto" v-model="provider.num_document" :disabled="storeup">
                                                                                <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.num_document[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">N° de Teléfono</label>
                                                                            <div class="input-group col-md-9">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fas fa-phone"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="tel" v-mask="'(###) ###-##-##'" class="form-control" :class="{'is-invalid' : errors}" placeholder="(###) ###-##-##" v-model="provider.num_phone" :disabled="storeup">
                                                                                <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.num_phone[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">Email</label>
                                                                            <div class="input-group col-md-9">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fas fa-envelope"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese Email" v-model="provider.email" :disabled="storeup">
                                                                                <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.email[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">Dirección</label>
                                                                            <div class="col-md-9">
                                                                            <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors}" cols="60" rows="3" v-model="provider.address" placeholder="Ingrese dirección" :disabled="storeup"></textarea>
                                                                            <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.address[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">Persona Contacto</label>
                                                
                                                                            <div class="input-group col-md-9">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Contacto" v-model="provider.contact_name" :disabled="storeup">
                                                                                <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.name_contact[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-3 form-control-label">N° Tlf de Contacto</label>
                                                                            <div class="input-group col-md-9">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fas fa-phone"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="tel" v-mask="'(###) ###-##-##'"  class="form-control" :class="{'is-invalid' : errors}" placeholder="(###) ###-##-##" v-model="provider.contact_phone" :disabled="storeup">
                                                                                <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.contact_phone[0]"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>   
                                                        </transition>
                                                    </div>
                                                </div>    
                                            </div>
                                            <transition name="fade">
                                                <!-- /.card-body -->
                                                <div v-show="checked" class="card-footer">
                                                    <button type="submit" class="btn btn-default btn-sm" @click.prevent="closeForm()">Cancelar</button>
                                                    <button type="submit" class="btn btn-info btn-sm float-right" @click.prevent="storeProvider()">Agregar</button>
                                                </div>
                                                <!-- /.card-footer -->
                                            </transition>
                                        </div>
                                </tab-content>
                                <tab-content title="Producto"  icon="ti-bag" :before-change="validateAsync">
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

// Local Directive - vue-the-mask
import {mask} from 'vue-the-mask'

//wizard component
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

export default {
    directives: {mask},
    components:{
        BtnProductsComponentVue,
        StatusComponentVue,
        FormWizard,
        TabContent
    },
    data(){
        return{
            search:'',
            data: {},
            url:"api/ingresos",
            titlePage:'Ingresos',
            routePage:'Ingresos',
            divisa: 0,
            provider_id: 0,
            providers:[],
            name:'',
            vincome:true,
            create: false,
            title: 'Nuevo Ingreso',
            provider:{
                name:'',
                type_document:'',
                num_document:'',
                num_phone:'',
                email:'',
                address:'',
                contact_name:'',
                contact_phone:''
            },
            errors:'',
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
            providerName: '',
            selectedRow: {},
            action: false,
            storeup: true,
            product_id: 0,
            images:[],
            isLoading: false,
            selected:'',
            value:'',
            checked:false,
            storeup:false,
            loadingWizard: false,
            errorMsg: null,
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
        getCategories(){
            var url = "api/categorias/lista";
            axios.get(url).then(response => {
                this.categories = response.data;
                console.log(this.categories)
            }).catch(error =>{
                console.log(error.response.data)
            });
        },
        selectProvider(search, loading){
            let me = this;
            loading(true);
            setTimeout(() => {            
                var url = '/api/seleccionar-proveedor?filter='+search;
                axios.get(url).then(function (response){

                    var result = response.data;
                    q: search
                    if(result.length > 0){
                        me.providers = result;
                    }else{
                        me.selected=null;
                    }
                    console.log(result);
                }).catch(function (error){
                    // console.log(error);
                    me.$refs.theSelect.clearSelection(); 
                    me.selected=null;
                });
            
            loading(false);
            },1000);
        },
        setSelected(value){
            if(value){  
                this.provider_id = value.id;
                console.log(this.provider_id)
            }
        },
        inputChange(){
            this.selected = null;   
        },
        closeForm(){
            this.checked = false;
            this.provider={};
        },
        storeProvider(){
            var url = 'api/proveedor';
            axios.post(url,{
                'name': this.provider.name,
                'type_document':  this.provider.type_document,
                'num_document': this.provider.num_document, 
                'num_phone': this.provider.num_phone, 
                'email': this.provider.email, 
                'address': this.provider.address, 
                'name_contact': this.provider.name, 
                'contact_phone': this.provider.contact_phone,
                'user_id': this.user.id,  
            }).then(response => {
                toastr.success('El Proveedor fue registrado.');
            }).catch(error => {
                var errors = error.response.data.errors;
                if (error.response.status == 422) {
                    this.errors = errors;
                    console.log(this.errors)
                    toastr.error("ERROR - En la validaciones.");
                    // reject(this.errors);
                }
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
        validateAsync:function() {
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
        back_pag(){
            this.vincome = false;
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