<template>
   <div class="modal fade" id="modal-provider" data-backdrop="static"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content  bg-secondary">
                <div class="modal-header">
                <h4 class="modal-title" v-text="title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form role="form" method="POST">
                    <div v-if="!storeup" class="modal-body">
                        <div id="form-provider">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Proveedor</label>
                                <div class="input-group col-md-9">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-industry"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Proveedor" v-model="provider.name" :disabled="storeup">
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Tipo de Documento</label>
                                <div class="col-md-9">
                                    <select class="form-control" :class="{'is-invalid' : errors}" v-model="typedocument.type_document" @change="changeSelect(typedocument.type_document)" :disabled="storeup" >
                                        <option value="">Seleccione un Tipo de Documento</option>
                                        <option>V</option>
                                        <option>E</option>
                                        <option>J</option>
                                        <option>G</option>
                                        <option>P</option>
                                        <!-- <option v-for="item in types_doc" :key="item.id" :value="item.id_doc" v-text="provider.type_document"></option> -->
                                    </select>
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.type_document[0]"></span>
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
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.num_document[0]"></span>
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
                                    <input type="text" class="form-control" :class="{'is-invalid' : errors}" v-imask="mask.numphone" placeholder="(###) ###-##-##" v-model="provider.num_phone" :disabled="storeup">
                                    <!-- <input type="tel" v-mask="'(###) ###-##-##'" class="form-control" :class="{'is-invalid' : errors}" placeholder="(###) ###-##-##" v-model="provider.num_phone" :disabled="storeup"> -->
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.num_phone[0]"></span>
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
                                    <input type="text" class="form-control text-lowercase" :class="{'is-invalid' : errors}" placeholder="Ingrese Email" v-model="provider.email" :disabled="storeup">
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.email[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Dirección</label>
                                <div class="col-md-9">
                                <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors}" cols="60" rows="3" v-model="provider.address" :disabled="storeup" placeholder="Ingrese dirección"></textarea>
                                <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.address[0]"></span>
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
                                    <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Contacto" v-model="data.contact_name" :disabled="storeup">
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.contact_name[0]"></span>
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
                                    <input type="text" class="form-control" :class="{'is-invalid' : errors}" v-imask="mask.numphone" placeholder="(###) ###-##-##" v-model="data.contact_phone" :disabled="storeup">
                                    <!-- <input type="tel" v-mask="'(###) ###-##-##'" class="form-control" :class="{'is-invalid' : errors}" placeholder="(###) ###-##-##" v-model="data.contact_phone" :disabled="storeup"> -->
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.contact_phone[0]"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="tbprovider">
                        <div class="container pt-2">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-muted">
                                        <i class="fas fa-address-card">&nbsp;</i>
                                        <strong class="text-uppercase">{{provider.name}}</strong>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                            </tr>
                                        </thead>
                                        <tbody class="text-muted">
                                            <tr>
                                                <th width=300>RIF/CI:</th>
                                                <td>{{ provider.type_document + "-" + provider.num_document }}</td>
                                            </tr>
                                            <tr>
                                                <th width=300>N° Teléfono:</th>
                                                <td v-text="provider.num_phone"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Correo Electrónico</th>
                                                <td v-text="provider.email"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Dirección</th>
                                                <td class="text-capitalize" v-text="provider.address"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Persona de Contacto</th>
                                                <td class="text-capitalize" v-text="data.contact_name"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>N° Tlf. Contacto</th>
                                                <td type="text" v-text="data.contact_phone"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" :class="{'justify-content-between':action}">
                        <button type="button" class="btn btn-default" :class="{'pull-right' : storeup}" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                        <div v-if="action">
                            <button v-if="create" type="submit" class="btn btn-primary" @click.prevent="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button>
                            <button v-else type="button" class="btn btn-primary" @click.prevent="actionModal('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
import Vue from 'vue'
import {IMaskDirective} from 'vue-imask';
// import {mask} from 'vue-the-mask'

export default {
    directives: {
      imask: IMaskDirective,
    //   mask
    },    
    props:{
        data: {
            type: Object,
            default: () => ({}),
        },
        title:{
            type: String,
            default: '',
        },
        create:{
            type: Boolean,
        },
        action:{
            type: Boolean,
        },
        storeup:{
            type: Boolean,
        },
        provider:{
            type: Object,
            default: () => ({}) 
        }

    },
    data(){
        return {
            url:"api/proveedores",
            type_document:'',
            typedocument: Object.assign({}, this.provider),
            name:'',
            errors: '',
            customer_id: 0,
            mask:{
                numphone: {
                    mask: "(000) 000-00-00",
                    lazy: false
                }    
            }
        }
    },
    watch:{
        provider(newType){
            var type_doc = newType.type_document;
            if(type_doc){
                this.typedocument = Object.assign({}, type_doc)
                this.typedocument.type_document = type_doc;
            }else{
                if(!this.type_document){
                    this.typedocument.type_document='';
                }
                return this.typedocument.type_document;
            }
        }
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
    methods:{
        changeSelect(data){
            this.type_document = this.typedocument.type_document;
            return this.type_document;
        },
        actionModal(action){
            if(action == "store"){
                this.storeProvider();
            }else{
                console.log(this.typedocument)
                this.updateProvider();
            }
        },
        storeProvider(){
            var url = this.url;
            setTimeout(() => {
                axios.post(url,{
                    'name': this.provider.name,
                    'type_document':  this.typedocument.type_document,
                    'num_document': this.provider.num_document, 
                    'num_phone': this.provider.num_phone, 
                    'email': this.provider.email, 
                    'address': this.provider.address, 
                    'contact_name': this.data.contact_name, 
                    'contact_phone': this.data.contact_phone, 
                    'user_id': this.currentUser.id,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    } 
                }).then(response => {
                    this.$parent.reloadTable();
                    toastr.success('El Proveedor fue registrado.');
                    this.closeModal();
                }).catch(error => {
                    var errors = error.response.data.errors;
                    this.errors = errors;
                    console.log(this.errors)
                    $('#modal-provider').modal('show');
                });
            },1000)
        },
        updateProvider(){
            var url = `${this.url}/${this.data.id}`;
            setTimeout(() => {
                axios.put(url,{
                    'customer_id': this.provider.id,
                    'name': this.provider.name,
                    'type_document': this.typedocument.type_document,
                    'num_document': this.provider.num_document, 
                    'num_phone': this.provider.num_phone, 
                    'email': this.provider.email, 
                    'address': this.provider.address, 
                    'contact_name': this.data.contact_name, 
                    'contact_phone': this.data.contact_phone, 
                    'user_id': this.currentUser.id,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    } 
                }).then(response => {
                    this.$parent.reloadTable();
                    toastr.info('El Proveedor fue actualizado.');
                    this.closeModal();
                }).catch(error => {
                    console.log(error);
                    let errors = error.response.data.errors;
                    this.errors = errors;
                    $('#modal-provider').modal('show');
                })
            },1000)
        },
        closeModal(){
            this.type_document = "";
            this.errors = '';
        },

    }
}
</script>