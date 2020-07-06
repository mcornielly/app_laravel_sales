<template>
   <div class="modal fade" id="modal-product" data-backdrop="static"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                <h4 class="modal-title" v-text="title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form role="form" method="POST">
                    <div v-if="!storeup" class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Nombre</label>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control capitalize" :class="{'is-invalid' : errors}" placeholder="Ingrese Nombre del Producto" v-model="data.name" autofocus>
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Categoría</label>
                                    <div class="col-md-9">
                                    <select class="form-control" :class="{'is-invalid' : errors}" v-model="data.category_id">
                                        <option value="0">Seleccione</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id" v-text="category.name"></option>
                                    </select>
                                    <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.category_id[0]"></span>
                                    <!-- <span v-html="errors.name"></span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Ingresar descripción" v-model="data.description">
                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.description[0]"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Precio Costo</label>
                                    <div class="col-md-9">
                                        <imask-input
                                            :value="value"
                                            v-model="data.price"
                                            :mask="Number"
                                            :unmask="true"
                                            thousandsSeparator= "."
                                            :padFractionalZeros="true"
                                            :normalizeZeros="true" 
                                            radix=","
                                            @accept="onAccept" 
                                            class="form-control text-right" :class="{'is-invalid' : errors}" 
                                            placeholder="Ingrese Cotización"
                                            require
                                        >
                                        </imask-input>    
                                        <!-- <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="data.price"> -->
                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.price[0]"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Sctok</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" placeholder="Stock" v-model="data.stock">
                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.stock[0]"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Bulto (Cantidad)</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" placeholder="Cantidad por bultor" v-model="data.wholesale_quantity">
                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.wholesale_quantity[0]"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-unit-tab" data-toggle="pill" href="#custom-tabs-four-unit" role="tab" aria-controls="custom-tabs-four-unit" aria-selected="false">Precios al Detal</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-mayor-tab" data-toggle="pill" href="#custom-tabs-four-mayor" role="tab" aria-controls="custom-tabs-four-mayor" aria-selected="true">Precios Al Mayor</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-code-tab" data-toggle="pill" href="#custom-tabs-four-code" role="tab" aria-controls="custom-tabs-four-code" aria-selected="false">Código</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-photo-tab" data-toggle="pill" href="#custom-tabs-four-photo" role="tab" aria-controls="custom-tabs-four-photo" aria-selected="false">Imagen</a>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                            <div class="tab-pane fade show active" id="custom-tabs-four-unit" role="tabpanel" aria-labelledby="custom-tabs-four-unit-tab">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted" for="text-input">(%) Ganancia</label>
                                                    <div class="col-md-7">
                                                        <input type="range" min="1" max="100" step="1" value="50" class="form-control" v-model="data.margin_gain_u">
                                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.margin_gain_u[0]"></span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" class="form-control" v-model="data.margin_gain_u">

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">Ganancia D.</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="price_gain_u" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">P. Divisa ($)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="divisa_unit" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">P.U. (Bs.)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="unit_price" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-four-mayor" role="tabpanel" aria-labelledby="custom-tabs-four-mayor-tab">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted" for="text-input">(%) Ganancia</label>
                                                    <div class="col-md-7">
                                                        <input type="range" min="1" max="100" step="1" value="50" class="form-control" v-model="data.margin_gain_w">
                                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.margin_gain_w[0]"></span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" class="form-control" v-model="data.margin_gain_w">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">Ganancia M.</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="price_gain_w" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">P. Divisa M. ($)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="wholesale_divisa" disabled>
                                                    </div>
                                                </div>                           
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">P.M. (Bs.)</label>
                                                    <div class="col-md-9">
                                                        <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="wholesale_price" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-four-code" role="tabpanel" aria-labelledby="custom-tabs-four-code-tab">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label text-muted">Código</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Código de Barras" v-model="data.code">
                                                        <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.code[0]"></span>
                                                        <barcode :value="data.code" :options="{ format: 'EAN-13'}">
                                                        </barcode>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-four-photo" role="tabpanel" aria-labelledby="custom-tabs-four-photo-tab">
                                                <div class="col-md-12">
                                                    <div class="form-group" v-show="images.length < 3">
                                                        <label for="my-input" class="form-control-label text-muted">Agregar Imagenes al Producto: </label>
                                                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"
                                                            @vdropzone-error="eventError"
                                                            @vdropzone-success="eventSuccess">
                                                        </vue-dropzone>
                                                    </div>     
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="my-input" class="form-control-label text-muted">Imagenes del Producto: </label>
                                                    <!-- timeline item -->
                                                    <div class="timeline-body align-center text-center">
                                                        <div v-for="image in images" :key="image.id" class="float-left pt-2 pb-2 pr-2">
                                                            <router-link to="" class="btn btn-link btn-danger btn-sm" style="position: absolute" @click.native="deleteImag(image.id)"><i class="fas fa-trash-alt"></i></router-link>
                                                            <!-- <a href="#" class="btn btn-link btn-danger btn-sm" style="position: absolute; text-decoration:none;" @click="deleteImag(image.id)"><i class="fas fa-trash-alt"></i></a>  -->
                                                            <!-- <button type="button" class="btn btn-danger btn-sm" style="position: absolute" @click.stop="deleteImag(image.id)"><i class="fas fa-trash-alt"></i></button> -->
                                                            <img :src="image.url" :alt="data.name" class="img-thumbnail" width="150" height="100">
                                                        </div>
                                                    </div>
                                                    <!-- END timeline item -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="tbcustomer">
                       <show-product 
                            :data="data"
                            :images="images"    
                            :divisa="divisa"
                            :categoryName="categoryName">
                        </show-product>
                    </div>
                    <div class="modal-footer" :class="{'justify-content-between':action}">
                        <button type="button" class="btn btn-default" :class="{'pull-right' : storeup}" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                        <button v-show="action" type="button" class="btn btn-primary" @click="actionModal('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button>
                        <!-- <button v-if="create" type="button" class="btn btn-primary" @click="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button> -->
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');
import {IMaskDirective} from 'vue-imask';
import {IMaskComponent} from 'vue-imask';
import VueBarcode from 'vue-barcode';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';

export default {
    props:{
        data: {
            type: Object,
            default: () => ({}),
        },
        categories: {
            type: Array,
            default: () => [],
        },
        divisa: {
            type: Number,
            default: 0,
        },
        categoryName:{
            type: Object,
            default: () => ({}),
        },
        images:{
            type: Array,
            default: () => [],
        },
        title:{
            type: String,
            default: () => ({}),
        },
        action:{
            type: Boolean,
        },
        storeup:{
            type: Boolean,
        }
    },
    data(){
        return {
            url:"api/producto",
            errors: '',
            name:'',
            product_id: 0,
            category_id: 0,
            description:'',
            price: 0,
            stock: 0,
            code:0,
            wholesale_quantity: 0,
            margin_gain_u: 0,
            margin_gain_w: 0,
            dropzoneOptions: {
                url: 'api/producto/img',
                paramName: 'photo',
                acceptedFiles: 'image/*',
                thumbnailWidth: 150,
                thumbnailHeight: 100,
                maxFilesize: 2,
                maxFiles: 3,
                headers: { "My-Awesome-Header": "header value" },
                dictDefaultMessage: 'Arrastra las imagenes para subirlas',
                // autoProcessQueue:false
            },
            value:'',
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
                }
            },
            image: '',
            photos:[],
            close: false
        }
    },
    components:{
        'barcode': VueBarcode,
        'vueDropzone': vue2Dropzone,
        'imask-input': IMaskComponent
    },
    directives: {
      imask: IMaskDirective
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        },
        price_gain_u: function(){
            var result = (this.data.price * this.data.margin_gain_u / 100).toFixed(2);
            this.p_gain_u = result;
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
            if(this.data.stock > 0 || this.data.price > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.price)) / this.data.stock).toFixed(2);
            }
            return result;
        },
        price_gain_w: function(){
            var result = (this.data.price * this.data.margin_gain_w / 100).toFixed(2);
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
            if(this.datawholesale_quantity > 0 || this.data.price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.data.price)).toFixed(2);
            }
            return result;
        }
    },
    methods:{
        onAccept (value) {
            console.log(value)
            // const maskRef = e.detail;
            // this.value = maskRef.value;
            // console.log('accept', maskRef.value);
        },
        vremoved(file, xhr, error) {
            this.$refs.myVueDropzone.removeAllFiles();
            if(this.close == true && !this.photos){
                this.removeStorage();
                this.close = false;    
            }
            this.photos = [];
            // window.toastr.warning('', 'Event : vdropzone-removedFile')
        },
        removeStorage(){
            console.log(this.photos)
            var url = "api/fotos/url";
            axios.post(url,{
                'photos': this.photos, 
            }).then(response => {
                console.log(response.data)
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        eventError(file, message, xhr){
            var error = message.message;
            // console.log(message)
            $('.dz-error-message:last > span').text(error);
        },
        eventSuccess(file, response){
            this.image = response;  
            this.photos.push(this.image);
            // console.log(this.photos)  
        },
        actionModal(action){
            if(action == "store"){
                this.storeProduct();
            }else{
                this.updateProduct();
            }
        },
        // storeProduct(){
        //     var url = this.url;
        //     axios.post(url,{
        //         'name': this.data.name, 
        //         'description': this.data.description 
        //     }).then(response => {
        //         console.log(response.data)
        //         this.$parent.reloadTable();
        //         toastr.success('El producto fue registrado.');
        //     }).catch(error => {
        //         console.log(error);
        //         var errors = error.response.data.errors;
        //         this.errors = errors;
        //     });
        // },
        updateProduct(){
            var url = `${this.url}/${this.data.id}`;
            axios.put(url,{
                'id': this.data.id,
                'name':this.data.name,
                'category_id':this.data.category_id,
                'code':this.data.code,
                'price':this.data.price,
                'stock':this.data.stock,
                'description': this.data.description,
                'margin_gain_u':this.data.margin_gain_u,
                'divisa_unit':this.data.divisa_unit,
                'wholesale_quantity':this.data.wholesale_quantity,
                'margin_gain_w':this.data.margin_gain_w,
                'wholesale_divisa':this.data.wholesale_divisa,
                'photos':this.photos
            }).then(response => {
                this.$parent.reloadTable();
                this.vremoved();
                toastr.info('El producto fue actualizado.');
            }).catch(error => {
                console.log(error.response.data);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        deleteImag(data){
            var url = `api/fotos/eliminar/${data}`;
            axios.delete(url,{
                'photo': this.photos
            }).then(response => {
                console.log(response.data)
                this.product_id = response.data.product_id;
                console.log(this.product_id);
                this.$parent.getImages(this.product_id);
                toastr.success('La foto del producto ha sido eliminada.');
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        closeModal(){
            this.close = true;
            this.selectedRow = {};
            this.errors = '';
            this.vremoved();
            this.$parent.reloadTable();
            this.data.price = '';
        },

    }
}
</script>

<style>
.capitalize {
  text-transform: capitalize;
}
</style>