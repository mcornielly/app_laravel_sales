<template>
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Nuevo Producto</h3>
                    <a href="#" @click="back_page()" class="btn btn-sm btn-primary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</a>
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
                            <tab-content title="Producto"  icon="ti-bag" :before-change="validateAsync">
                                <div class="card card-default card-default">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-store">&nbsp;</i> Datos del Producto</h3>
                                    </div>
                                    <!-- /.card-header -->                  
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Nombre del Producto</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control capitalize" :class="{'is-invalid' : errors.name}"  placeholder="Nombre del Producto" v-model="name" v-focus>
                                                <span v-if="errors.name" class="invalid-feedback" role="alert">{{ errors.name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Categoría</label>
                                            <div class="col-md-9">
                                                <select class="form-control" :class="{'is-invalid' : errors.category_id}" v-model="category_id">
                                                    <option value="0">Seleccione</option>
                                                    <option v-for="category in categories" :key="category.id" :value="category.id" v-text="category.name"></option>
                                                </select>
                                                <span v-if="errors.category_id" class="invalid-feedback" role="alert">{{ errors.category_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Descripción</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" :class="{'is-invalid' : errors.description}" v-model="description" placeholder="Ingresar descripción"></textarea>
                                                <!-- <input type="text" class="form-control" :class="{'is-invalid' : errors.description}" placeholder="Ingresar descripción" v-model="description"> -->
                                                <span v-if="errors.description" class="invalid-feedback" role="alert">{{errors.description[0]}}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Precio Costo</label>
                                            <div class="col-md-9 input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                </div>
                                                    <imask-input
                                                        :value="value"
                                                        v-model="price"
                                                        :mask="Number"
                                                        :unmask="true"
                                                        thousandsSeparator= "."
                                                        :padFractionalZeros="true"
                                                        :normalizeZeros="true" 
                                                        radix=","
                                                        @accept="onAccept" 
                                                        class="form-control text-right" :class="{'is-invalid' : errors.price}" 
                                                        placeholder="Ingrese Cotización"
                                                        require
                                                    >
                                                    </imask-input>
                                                    <span v-if="errors.price" class="invalid-feedback" role="alert">{{ errors.price[0] }}</span>
                                            </div> 
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Sctok</label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" :class="{'is-invalid' : errors.stock}" placeholder="Stock" min="0" v-model="stock">
                                                <span v-if="errors.stock" class="invalid-feedback" role="alert">{{ errors.stock[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Bulto (Cantidad)</label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" :class="{'is-invalid' : errors.wholesale_quantity}" placeholder="Cantidad por bultor" min="0" v-model="wholesale_quantity">
                                                <span v-if="errors.wholesale_quantity" class="invalid-feedback" role="alert">{{ errors.wholesale_quantity[0] }}</span>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </tab-content>
                            <!-- <tab-content title="Ganancia" icon="ti-panel"> -->
                                <!-- Balance de Costos -->
                                <!-- <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <div class="card card-default card-default">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-coins">&nbsp;</i> Precio al Detal</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">(%) Ganancia</label>
                                                    <div class="col-xl-6 col-md-5 col-sm-5">
                                                        <input type="range" min="0" max="100" step="1" value="50" class="form-control"  v-model="margin_gain_u">
                                                    </div>
                                                    <div class="col-xl-3 col-md-4 col-sm-4">
                                                        <input type="number" class="form-control" v-model="margin_gain_u">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Ganancia</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="price_gain_u" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Precio ($)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="divisa_unit" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Precio (Bs.)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="unit_price" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- /.card-body -->
                                    <!-- <div class="col-md-6">
                                        <div class="card card-default card-default">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-coins">&nbsp;</i> Precio al Mayor</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">(%) Ganancia</label>
                                                    <div class="col-xl-6 col-md-5 col-sm-5">
                                                        <input type="range" min="0" max="100" step="1" value="50" class="form-control" v-model="margin_gain_w">
                                                    </div>
                                                    <div class="col-xl-3 col-md-4 col-sm-4">
                                                        <input type="number" class="form-control" v-model="margin_gain_w">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Ganancia</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="price_gain_w" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Precio ($)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="wholesale_divisa" disabled>
                                                    </div>
                                                </div>                           
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Precio (Bs.)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="wholesale_price" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>   -->
                            <!-- </tab-content> -->
                            
                            <tab-content title="Código" icon="ti-layout-column4" :before-change="validateCode">
                            <!-- Generar Coódigo -->
                                <div class="card card-default card-default">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-barcode">&nbsp;</i> Generar Código del Producto</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- /.card-header -->                  
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Código</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                                    </div>
                                                    <input ref="code" type="text" class="form-control" :class="{'is-invalid' : errors.code}" placeholder="Código de Barras" v-model="code" v-imask="mask.code" maxlength="13">
                                                </div>   
                                                <small>Los números de código debe ser de 13 dígitos.</small>
                                                <span v-if="errors.code" class="invalid-feedback" role="alert">{{ errors.code[0] }}</span>
                                            </div>   
                                                <div class="col-md-3">
                                                    <img class="mediana" :src="imgLector" alt=""> 
                                                </div> 
                                                <div class="col-md-4 border_code text-center">
                                                    <barcode :value="code" :options="{ format: 'EAN-13'}">
                                                    </barcode>
                                                </div>
                                        </div>
                                    </div>    
                                    <!-- /.card-body -->
                                </div>
                            </tab-content>
                            <tab-content title="Imagen" icon="ti-camera">
                                <!-- Imagnes del Producto -->
                                <div class="card card-default card-default">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fa fa-camera">&nbsp;</i> Imagenes del Producto</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="my-input">Agregar Imagenes al Producto</label>
                                                <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" 
                                                @vdropzone-error="eventError"
                                                @vdropzone-success="eventSuccess">
                                                </vue-dropzone>
                                            </div>     
                                        </div>
                                        <div class="col-md-12">
                                            <!-- timeline item -->
                                            <!-- <div class="timeline-item" style="width: max-content;margin: auto; margin-top: auto;margin-top: 9%;">
                                                <div class="timeline-body text-muted">
                                                    <div v-for="image in photos" :key="image.id" class="float-left pt-2 pb-2 pr-2">
                                                        <img style="height: 160px;" :src="image.url" :alt="data.name" class="img-thumbnail" width="150">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- END timeline item -->
                                        </div>
                                        <!-- /.card-header -->                  
                                    </div>    
                                    <!-- /.card-body -->
                                </div>              
                                <!-- /.card -->
                            </tab-content>
                        </form-wizard>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer"></div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </section>
</template>
<script>
import {IMaskDirective} from 'vue-imask';
import {IMaskComponent} from 'vue-imask';
import VueBarcode from 'vue-barcode'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import Vue from "vue";
// autofocus
Vue.directive('focus', {
    // Cuando el elemento enlazado se inserta en el DOM...
    inserted: function (el) {
        // Enfoca el elemento
        el.focus();
    }
})

export default {
    props:{
        categories: {
            type: Array,
        },
        divisa: {
            type: Number,
            default: 0
        },
        token: {
            type: String,
        },
    },    
    data(){
        return{
            url: 'api/productos',
            imgLector: '/images/img/lector-codigo.jpg',
            name: '',
            code: '',
            category_id: 0,
            description: '',
            price: '0',
            stock: 0,
            wholesale_quantity: 0,
            margin_gain_u: 50,
            margin_gain_w: 25,
            tokenUser: this.token,
            dropzoneOptions: {
                url: 'api/fotos',
                paramName: 'photo',
                acceptedFiles: 'image/*',
                thumbnailWidth: 150,
                maxFilesize: 2,
                maxFiles: 3,
                // headers: { "Authorization": `Bearer ${this.tokenUser}`},
                headers: { "My-Awesome-Header": "header value" },
                dictDefaultMessage: 'Arrastra las imagenes para subirlas',
                // autoProcessQueue:false
            },
            value: '',
            mask: {
                amount: {
                    mask: Number,
                    scale: 2, 
                    signed: false,
                    thousandsSeparator: ".", 
                    padFractionalZeros: true, 
                    normalizeZeros: true,
                    radix: ",", 
                    mapToRadix: ["."], 
                    max: 100000000
                },
                code: {
                    mask:Number
                }
            },
            image: '',
            photos:[],
            errors: '',
            backPage:false,
            vproducts:false,
            loadingWizard: false,
            errorMsg: null,
            // count: 0
        }
    },
    created(){
        this.setFocus();
    },
    components: {
        'barcode': VueBarcode,
        'vueDropzone': vue2Dropzone,
        'imask-input': IMaskComponent,
        'form-wizard': FormWizard,
        'tab-content': TabContent,
    },
    directives: {
      imask: IMaskDirective,
      focus:{
          inserted: function(el){
              el.focus()
          }
      }
    },
    computed:{
        // user(){
        //     let user = document.head.querySelector('meta[name="user"]');
        //     return JSON.parse(user.content);
        // },
        currentUser() {
            return this.$store.getters.currentUser;
        },
        price_gain_u: function(){
            var result = 0;
             if(this.price > 0){
                 var result = (this.price * this.margin_gain_u / 100).toFixed(2);
             }
            return result;
        },
        divisa_unit: function(){
            var result = 0;
            if(this.divisa > 0 || this.unit_price > 0){
                var result = (this.unit_price / this.divisa).toFixed(2);
            }
            return result;
        },
        unit_price: function(){
            var result = 0;
            if(this.wholesale_quantity > 0 || this.price > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.price)) / this.wholesale_quantity).toFixed(2);
            }
            return result;
        },
        price_gain_w: function(){
            var result = 0;
            if(this.price > 0){
                var result = (this.price * this.margin_gain_w / 100).toFixed(2);
            }
            return result;
        },
        wholesale_divisa: function(){
            var result = 0;
            if(this.divisa > 0 || this.wholesale_price > 0){
                result = (this.wholesale_price / this.divisa).toFixed(2);
            }
            return result;
        },
        wholesale_price: function(){
            var result = 0;
            if(this.wholesale_quantity > 0 || this.price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.price)).toFixed(2);
            }
            return result;
        }
    },
    methods:{
        setFocus(){
            this.$nextTick(() => this.$refs.code.focus());
        },
        onComplete(){
            toastr["info"]("Formulario completado con exito..!!", "Nuevo Producto");
            setTimeout(() => {
                this.storeProduct();
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
                var url = `${this.url}/validate`;
                axios.post(url,{
                    'name' : this.name,
                    'category_id' : this.category_id,
                    'description' : this.description,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }   
                }).then(response =>{
                    // console.log(response.data)
                    this.setFocus();
                    resolve(true)
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        console.log(this.errors)
                        toastr.error("ERROR - En la validaciones.");
                        reject(this.errors);
                    }
                });   
            }, 1000)
          })
        },
        validateCode(){
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                var url = `${this.url}/validate/code`;
                axios.post(url,{
                    'code' : this.code,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }
                }).then(response =>{
                    // console.log(response.data)
                    resolve(true)
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        console.log(this.errors)
                        toastr.error("ERROR - En la validaciones.");
                        reject(this.errors);
                    }
                });   
            }, 1000)
          })
        },
        onAccept (value) {
            console.log(value)
            // const maskRef = e.detail;
            // this.value = maskRef.value;
            // console.log('accept', maskRef.value);
        },
        eventError(file, message, xhr){
            var error = message.message;
            // console.log(message)
            $('.dz-error-message:last > span').text(error);
        },
        eventSuccess(file, response){
          this.image = response;  
          this.photos.push(this.image);
          console.log(this.photos)  
        },
        storeProduct(){
            if(this.divisa > 0){
                var url = `${this.url}`;
                setTimeout(() => {
                    axios.post(url,{
                        'name' : this.name,
                        'category_id' : this.category_id,
                        'code' : this.code,
                        'description' : this.description,
                        'user_id': this.currentUser.id,
                        'photos':this.photos,
                        'stock': 0,
                        'price' : 0,
                        'margin_gain_u' : 0,
                        'divisa_unit' : 0,
                        'wholesale_quantity' : 0,
                        'margin_gain_w' : 0,
                        'wholesale_divisa' : 0,
                        headers: {
                            "Authorization": `Bearer ${this.tokenUser}`
                        }
                    }).then(response =>{
                        console.log(response.data)
                        this.back_page();
                        toastr.success("El Producto ha sido registrado.");
                    }).catch(error => {
                        var error = error.response.data.errors;
                        this.errors = error;
                        toastr.error("ERROR - En la validaciones.");
                        console.log(this.errors)
                    });
                }, 1000)
            }else{
                toastr.error('El precio de la Divisa no se encuentra establecido.');
            }

        },
        back_page(){
            this.$parent.reloadTable();
            // this.$router.push({path:'/productos'})
            this.$emit('returned', this.vproducts);
        }
    }
}
</script>

<style>
.capitalize {
  text-transform: capitalize;
}
.border_code {
    border: 1px solid gray;
    border-radius: 9px;
    -webkit-border-radius:9px;
    padding: 10px;
    margin-left: 7px;
    margin-top: 10px;                                            
}
img.mediana{
  width: 100px; height: 100px;
}
</style>