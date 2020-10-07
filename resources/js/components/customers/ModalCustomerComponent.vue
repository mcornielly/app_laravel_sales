<template>
   <div class="modal fade" id="modal-customer" data-backdrop="static"  tabindex="-1" role="dialog">
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
                                <label class="col-md-3 form-control-label">Cliente</label>
                                 <div class="input-group col-md-9">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control text-capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Cliente" v-model="data.name" :disabled="storeup">
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Tipo de Documento</label>
                                <div class="col-md-9">
                                    <select class="form-control" :class="{'is-invalid' : errors}" v-model="typedocument.type_document" @change="changeSelect(typedocument.type_document)" :disabled="storeup">
                                        <option value="">Seleccione un Tipo de Documento</option>
                                        <option>V</option>
                                        <option>E</option>
                                        <option>J</option>
                                        <option>G</option>
                                        <option>P</option>
                                        <!-- <option v-for="item in types_doc" :key="item.id" :value="item.id_doc" v-text="data.type_document"></option> -->
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
                                    <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese N° Docuemnto" v-model="data.num_document" maxlength="10" :disabled="storeup">
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
                                    <input type="text" class="form-control" :class="{'is-invalid' : errors}" v-mask="'(###) ###-##-##'" placeholder="(###) ###-##-##" v-model="data.num_phone" :disabled="storeup">
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
                                    <input type="text" class="form-control text-lowercase" :class="{'is-invalid' : errors}" placeholder="Ingrese Email" v-model="data.email" :disabled="storeup">
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.email[0]"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Dirección</label>
                                <div class="col-md-9">
                                <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors}" cols="60" rows="3" v-model="data.address" :disabled="storeup" placeholder="Ingrese dirección"></textarea>
                                <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.address[0]"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="tbcustomer">
                       <show-customer :data="data"></show-customer>
                    </div>
                    <div class="modal-footer" :class="{'justify-content-between':action}">
                        <button type="button" class="btn btn-default" :class="{'pull-right' : storeup}" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                        <div v-if="action">
                            <button v-if="create" type="submit" class="btn btn-primary" @click.prevent="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button>
                            <button v-else type="submit" class="btn btn-primary" @click.prevent="actionModal('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
import {mask} from 'vue-the-mask'

export default {
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

    },
    data(){
        return {
            url:"api/clientes",
            type_document:'',
            typedocument: Object.assign({}, this.data),
            name:'',
            errors: '',
            customer_id: 0
        }
    },
    watch:{
        data(newType){
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
        },
    },
    methods:{
        changeSelect(data){
            this.type_document = this.typedocument.type_document;
            return this.type_document;
        },
        actionModal(action){
            if(action == "store"){
                this.storeCustomer();
            }else{
                this.updateCustomer();
            }
        },
        storeCustomer(){
            let url = this.url;
            setTimeout(() => {
                axios.post(url,{
                    'name': this.data.name,
                    'type_document':  this.typedocument.type_document,
                    'num_document': this.data.num_document, 
                    'num_phone': this.data.num_phone, 
                    'email': this.data.email, 
                    'address': this.data.address,
                    'user_id': this.currentUser.id,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    } 
                }).then(response => {
                    this.$parent.reloadTable();
                    toastr.success('El Cliente fue registrado.');
                    this.closeModal();
                }).catch(error => {
                    var errors = error.response.data.errors;
                    this.errors = errors;
                    console.log(this.errors)
                    $('#modal-customer').modal('show');
                });
            },1000)
        },
        updateCustomer(){
            let url = `${this.url}/${this.data.id}`;
            setTimeout(() => {
                axios.put(url,{
                    'id': this.data.id,
                    'name': this.data.name,
                    'type_document': this.typedocument.type_document,
                    'num_document': this.data.num_document, 
                    'num_phone': this.data.num_phone, 
                    'email': this.data.email, 
                    'address': this.data.address,
                    'user_id': this.currentUser.id,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    } 
                }).then(response => {
                    this.$parent.reloadTable();
                    toastr.info('El Cliente fue actualizado.');
                    this.closeModal();
                }).catch(error => {
                    console.log(error);
                    let errors = error.response.data.errors;
                    this.errors = errors;
                    $('#modal-customer').modal('show');
                });
            },1000)
        },
        closeModal(){
            this.type_document = "";
            this.errors = '';
        },

    }
}
</script>