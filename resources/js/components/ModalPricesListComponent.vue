<template>
    <div class="modal fade" id="modal-prices" data-backdrop="static"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container pt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title text-muted">
                                            <i class="fas fa-tag" style="font-size: 20px;">&nbsp;</i>
                                            <strong>{{data.name}}</strong>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0 text-muted">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                                                <div class="col-12 mx-auto d-block">
                                                    <div v-for="(image,index) in images" :key="image.id">
                                                        <div v-show="index==0">
                                                        <img v-if="imgshow==false" :src="image.url" class="product-image img-fluid" alt="Product Image" style="height: 315px; object-fit: cover; object-fit: contain;">
                                                        <img v-else :src="imgProduct" class="product-image" alt="Product Image">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 product-image-thumbs mb-3" style="margin-left: 54px;">
                                                    <div v-for="image in images" :key="image.id">
                                                        <div class="product-image-thumb active" @click="imageShow(image.url)"><img style="height: 110px;" :src="image.url" :alt="image.id"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 text-muted">
                                                <h3 class="my-3" v-text="data.name"></h3>
                                                <p v-text="data.description"></p>
                                                <hr>
                                                <h4>Precios del Producto</h4>
                                                <h6>Stock Disponible : {{ data.stock }}</h6>

                                                <div class="bg-gray py-2 px-3 mt-4">
                                                    <h4 class="mt-0">
                                                    <small>Sin IVA: {{ tax | numeralFormat('0.00[,]00') }}</small>
                                                    </h4>
                                                    <h3 class="mb-0">Bs. {{ unit_price | numeralFormat('0.00[,]00') }} | $. {{ data.divisa_unit | numeralFormat('0.00[,]00') }}</h3>
                                                </div>
                                                <div class="bg-gray disabled color-palette py-2 px-3 mt-4">
                                                    <h4 class="mt-0">
                                                    <small>Sin IVA: {{ tax_wholesale | numeralFormat('0.00[,]00') }} </small>
                                                    </h4>
                                                    <h3 class="mb-0">Bs. {{ wholesale_price | numeralFormat('0.00[,]00') }} | $. {{ data.wholesale_divisa | numeralFormat('0.00[,]00') }} | Pack. {{ data.wholesale_quantity }}</h3>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" :class="{'justify-content-between':action}">
                    <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                    <!-- <button v-if="create" type="button" class="btn btn-primary" @click="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button> -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
import VueNumerals from 'vue-numerals';
Vue.use(VueNumerals); // default locale is 'en'
import { compensateScroll } from '@fullcalendar/core'
export default {
    props:{
        data:{
            type: Object,
            default: () => {}
        },
        title:{
            type: String,
            default: ''
        },
        images:{
            type: Array,
            default: () => [],
        },
        imgshow:{
            type: Boolean,
            default: false,
        },
    },
    data(){
        return{
            imgProduct: '',
        }
    },
    computed:{
        price_gain_u: function(){
            var result = (this.data.price * this.data.margin_gain_u / 100).toFixed(2);
            this.p_gain_u = result;
            return result;
        },
        unit_price: function(){
            var result = 0;
            if(this.data.wholesale_quantity > 0 || this.data.price > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.price)) / this.data.wholesale_quantity).toFixed(2);
            }
            return result;
        },
        price_gain_w: function(){
            var result = (this.data.price * this.data.margin_gain_w / 100).toFixed(2);
            return result;
        },
        wholesale_price: function(){
            var result = 0;
            if(this.data.wholesale_quantity > 0 || this.data.price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.data.price)).toFixed(2);
            }
            return result;
        },
        tax_wholesale(){
            var tax = 0.16;
            var priceTax = this.wholesale_price * tax;
            return (this.wholesale_price - priceTax).toFixed(2);
        },
        tax(){
            var tax = 0.16;
            var priceTax = this.unit_price * tax;
            return (this.unit_price - priceTax).toFixed(2);
        }
    },
    methods:{
        imageShow(data){
            this.imgshow = true;
            this.imgProduct = data;      
        },
        closeModal(){
            this.images = [];
            this.imgProduct = '';
            this.imgshow=false;
            return 
        }
    }
        
}
</script>

<style>
.product-image {
  max-width: 60%!important;
  height: auto;
  width: 100%;
  margin-left: 15%!important;
  margin-top: 5%!important;
}
</style>