<template>
    <section> 
        <!-- form start -->
        <form role="form" @submit.prevent="storeProduct()">
            <div class="container-fluid">
                <div class="row">
                    <!-- Datos del Producto -->
                    <div class="col-md-8">
                        <div class="card card-primary card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-store">&nbsp;</i> Datos del Producto</h3>
                            </div>
                            <!-- /.card-header -->                  
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Nombre del Producto</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" :class="{'is-invalid' : errorsProd}"  placeholder="Nombre del Producto" v-model="productName">
                                        <!-- <span v-if="errorsProd" class="invalid-feedback" role="alert" v-html="errorsProd.name[0]"></span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" :class="{'is-invalid' : errorsProd}" v-model="categoryId">
                                            <option value="0">Seleccione</option>
                                            <option v-for="category in categories" :key="category.id" :value="category.id" v-text="category.name"></option>
                                        </select>
                                        <!-- <span v-if="errorsProd" class="invalid-feedback" role="alert" v-html="errorsProd.category_id[0]"></span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" :class="{'is-invalid' : errorsProd}" placeholder="Ingresar descripción" v-model="description">
                                        <!-- <span v-show="errorsProd" class="invalid-feedback" role="alert" v-html="errorsProd.description[0]"></span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Precio Costo</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-right" :class="{'is-invalid' : errorsProd}" v-model="cost_price">
                                        <!-- <span v-if="errorsProd" class="invalid-feedback" role="alert" v-html="errorsProd.cost_price[0]"></span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Sctok</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" :class="{'is-invalid' : errorsProd}" placeholder="Stock" v-model="stock">
                                        <!-- <span v-if="errorsProd" class="invalid-feedback" role="alert" v-html="errorsProd.stock[0]"></span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Bulto (Cantidad)</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" :class="{'is-invalid' : errorsProd}" placeholder="Cantidad por bultor" v-model="wholesale_quantity">
                                        <!-- <span v-if="errorsProd" class="invalid-feedback" role="alert" v-html="errorsProd.wholesale_quantity[0]"></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Generar Coódigo -->
                        <div class="card card-primary card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-barcode">&nbsp;</i> Generar Código del Producto</h3>
                            </div>
                            <div class="card-body">
                                <!-- /.card-header -->                  
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Código de Barras" v-model="code">
                                        <barcode :value="code" :options="{ format: 'EAN-13'}">
                                        </barcode>
                                    </div>
                                </div>
                            </div>    
                            <!-- /.card-body -->
                        </div>
                        <!-- Imagnes del Producto -->
                        <div class="card card-primary card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-camera">&nbsp;</i> Imagenes del Producto</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="my-input">Text</label>
                                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
                                    </div>     
                                </div>
                                <div class="col-md-8">
                                    <!-- timeline item -->
                                    <!-- <div class="timeline-item">
                                        <div class="timeline-body">
                                            <img src="http://placehold.it/150x100" alt="...">
                                            <img src="http://placehold.it/150x100" alt="...">
                                            <img src="http://placehold.it/150x100" alt="...">
                                            <img src="http://placehold.it/150x100" alt="...">
                                            <img src="http://placehold.it/150x100" alt="...">
                                        </div>
                                    </div> -->
                                    <!-- END timeline item -->
                                </div>
                                <!-- /.card-header -->                  
                            </div>    
                            <!-- /.card-body -->
                        </div>              
                        <!-- /.card -->
                    </div>
                    <!-- Balance de Costos -->
                    <div class="col-md-4">
                        <div class="card card-primary card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-coins">&nbsp;</i> Balance de Costos</h3>
                            </div>
                            <!-- /.card-header -->
                                <div class="card-footer">
                                    <label class="pt-2 ml-2 mb-0 text-primary">Precio al Detal</label> 
                                </div>                  
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">(%) Ganancia</label>
                                        <div class="col-md-7 col-sm-6">
                                            <input type="range" min="0" max="100" step="1" value="50" class="form-control"  v-model="margin_gain_u">
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <input type="number" class="form-control" v-model="margin_gain_u">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Ganancia D.</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right"  v-model="price_gain_u" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">P. Divisa ($)</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right"  v-model="divisa_unit" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">P.U. (Bs.)</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right" v-model="unit_price" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <label class="ml-2 mb-0 mt-0 text-primary">Precio al Mayor</label> 
                                </div>  
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">(%) Ganancia</label>
                                        <div class="col-md-7 col-sm-6">
                                            <input type="range" min="0" max="100" step="1" value="50" class="form-control" v-model="margin_gain_w">
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <input type="number" class="form-control" v-model="margin_gain_w">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Ganancia M.</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right" v-model="price_gain_w" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">P. Divisa M. ($)</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right"  v-model="wholesale_divisa" disabled>
                                        </div>
                                    </div>                           
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">P.M. (Bs.)</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right" v-model="wholesale_price" disabled>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" @click="storeProduct()" class="btn btn-primary btn-block"> Registrar Producto</button>
                                </div>
                        </div>
                    </div>  
                </div>
            </div> 
        </form>
    </section>
</template>
<script>
import VueBarcode from 'vue-barcode'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    props:['product','productName','categoryId','divisa', 'categories'],
    data(){
        return{
            name: '',
            code: '',
            category_id:0,
            description: '',
            cost_price: 0,
            stock: 0,
            wholesale_quantity: 0,
            margin_gain_u: 50,
            margin_gain_w: 25,
            dropzoneOptions: {
                url: '/productos',
                thumbnailWidth: 150,
                maxFilesize: 2,
                headers: { "My-Awesome-Header": "header value" },
                dictDefaultMessage: 'Arrastra las imagenes para subirlas'
            },
            errorsProd: '',
            vproducts:true
        }
    },
    template: '<product-create v-else="vproducts==false" ></product-create>',
    components: {
        'barcode': VueBarcode,
        'vueDropzone': vue2Dropzone,
    },
    computed:{
        price_gain_u: function(){
            var result = (this.cost_price * this.margin_gain_u / 100).toFixed(2);
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
            if(this.stock > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.cost_price)) / this.stock).toFixed(2);
            }
            return result;
        },
        price_gain_w: function(){
            var result = (this.cost_price * this.margin_gain_w / 100).toFixed(2);
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
            if(this.wholesale_quantity > 0 || this.cost_price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.cost_price)).toFixed(2);
            }
            return result;
        }
    },
    methods:{
        storeProduct(){
            if(this.divisa > 0){
                this.id = this.product.id;
                var url = `api/producto/${this.id}`;
                axios.put(url,{
                    'product_id': this.id,
                    'name' : this.productName,
                    'category_id' : this.categoryId,
                    'code' : this.code,
                    'description' : this.description,
                    'cost_price' : this.cost_price,
                    'stock' : this.stock,
                    'margin_gain_u' : this.margin_gain_u,
                    'divisa_unit' : this.divisa_unit,
                    'wholesale_quantity' : this.wholesale_quantity,
                    'margin_gain_w' : this.margin_gain_w,
                    'wholesale_divisa' : this.wholesale_divisa,
                }).then(response =>{
                    console.log(response.data)
                    this.getProducts();
                    this.$emit('vcreate', this.vproducts);
                    toastr.success("El Producto ha sido registrado.");
                }).catch(error => {
                    var errors = error.response.data;
                    this.errorsProd = errors;
                    console.log(errors)
                });
            }else{
                toastr.error('El precio de la Divisa no se encuentra establecido.');
            }

        },
        getDataTable(){
            var url = "/api/productos";
            axios.get(url).then(response => {
                this.products = response.data;
                console.log(this.products)        
                this.mytable();
            }).catch(errors => {
                console.log(errors)
            });
        }

    }
}
</script>