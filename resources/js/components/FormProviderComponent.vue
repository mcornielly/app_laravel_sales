<template>
    <div class="row">
        <div class="col-md-12">
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
    </div>   
</template>

<script>
// Local Directive - vue-the-mask
import {mask} from 'vue-the-mask'

export default {
    directives: {mask},
    props:{
        storeup: {
            type: Boolean,
            default: () => ({}),
        },
        errors: {
            type: Object,
            default: () => ({}),
        },
    },
    data(){
        return{
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
            errors:''
        }
    }
}
</script>

