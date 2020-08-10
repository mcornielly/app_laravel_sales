<template>
    <div class="card card-default card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-circle">&nbsp;</i>Cliente</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <v-select
                        ref="theSelect"
                        @search="selectCliente"
                        @input="setSelected"
                        v-model="selected"
                        :value="value.selected"
                        label="name"
                        :options="customers"
                        placeholder="Buscar Clientes">
                        <span slot="no-options" @click="$refs.select.open=false">
                            Lo sentimos. No existe coincidencia, en la busqueda.
                        </span>
                    </v-select>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success float-right" style="padding-top: 6px;">
                        <input type="checkbox" class="custom-control-input" id="customSwitch3" v-model="checked" @click="inputChange">
                        <label class="custom-control-label" for="customSwitch3">Nuevo Cliente</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <transition name="fade">
                        <div v-show="checked">
                            <hr>
                            <form role="form" method="POST" @submit.prevent="storeCustomer()">
                                <div id="form-provider">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Cliente</label>
                                        <div class="input-group col-md-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user-tag"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Cliente" v-model="customer.name" :disabled="storeup">
                                            <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.name[0]"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Tipo de Documento</label>
                                        <div class="col-md-9">
                                            <select class="form-control" :class="{'is-invalid' : errors}" v-model="type_document" :disabled="storeup">
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
                                            <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese N° Docuemnto" v-model="customer.num_document" maxlength="10" :disabled="storeup">
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
                                            <input type="tel" v-mask="'(###) ###-##-##'" class="form-control" :class="{'is-invalid' : errors}" placeholder="(###) ###-##-##" v-model="customer.num_phone" :disabled="storeup">
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
                                            <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese Email" v-model="customer.email" :disabled="storeup">
                                            <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.email[0]"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Dirección</label>
                                        <div class="col-md-9">
                                        <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors}" cols="60" rows="3" v-model="customer.address" placeholder="Ingrese dirección" :disabled="storeup"></textarea>
                                        <span v-if="errors" class="invalid-feedback" role="alert" v-html="errors.address[0]"></span>
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
                <button type="submit" class="btn btn-info btn-sm float-right" @click.prevent="storeCustomer()">Agregar</button>
            </div>
            <!-- /.card-footer -->
        </transition>
    </div>
</template>

<script>
// Local Directive - vue-the-mask
import {mask} from 'vue-the-mask'

export default {
    directives: {mask},
    data(){
        return {
            customer:{
                name:'',
                type_document:'',
                num_document:'',
                num_phone:'',
                email:'',
                address:'',
            },
            type_document:'',
            search:'',
            customer_id: 0,
            selectedProvider:{},
            customers:[],
            selected: null,
            value:'',
            checked:false,
            storeup:false,
            errors:''
        }
    },
    computed:{
        user(){
            let user = document.head.querySelector('meta[name="user"]');
            return JSON.parse(user.content);
        }
    },
    methods:{
        selectCliente(search, loading){
            let me = this;
            loading(true);
            setTimeout(() => {            
                var url = '/api/seleccionar-cliente?filter='+search;
                axios.get(url).then(function (response){

                    var result = response.data;
                    q: search
                    if(result.length > 0){
                        me.customers = result;
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
                console.log(value)
                this.selectedCustomer = value;
                this.customer_id = value.id;
                this.$emit('selectedCustomer', this.selectedCustomer);    
            }
        },
        inputChange(){
            this.selected = null;
            this.storeup = false;   
        },
        closeForm(){
            this.checked = false;
            this.customer={};
            this.errors='';
        },
        storeCustomer(){
            var url = 'api/cliente';
            axios.post(url,{
                'name': this.customer.name,
                'type_document':  this.type_document,
                'num_document': this.customer.num_document, 
                'num_phone': this.customer.num_phone, 
                'email': this.customer.email, 
                'address': this.customer.address, 
                'user_id': this.user.id,  
            }).then(response => {
                toastr.success('El Cliente fue registrado.');
                this.closeForm();
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
    }
}
</script>

