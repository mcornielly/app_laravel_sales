<template>
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
                            <form role="form" method="POST" @submit.prevent="storeProvider()">
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
                                            <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese N° Docuemnto" v-model="provider.num_document" maxlength="10" :disabled="storeup">
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
</template>

<script>
// Local Directive - vue-the-mask
import {mask} from 'vue-the-mask'

export default {
    directives: {mask},
    data(){
        return {
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
            search:'',
            provider_id: 0,
            provider: [],
            providers:[],
            selected:'',
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
                console.log(value)  
                // this.provider_id = value.id;
                this.provider.push({
                    id: value.id,
                    name: value.name,
                    num_document: value.num_document,
                });
                this.$emit('selectedProvider', this.provider[0]);    
                console.log(this.provider[0])
            }
        },
        inputChange(){
            this.selected = null;
            this.storeup = false;   
        },
        closeForm(){
            this.checked = false;
            this.provider={};
            this.errors='';
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

