<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-muted">
                    <i class="fas fa-tag" style="font-size: 20px;">&nbsp;</i>
                    <strong v-if="data.name">{{data.name}}</strong>
                    <strong v-else v-html="noProduct"></strong>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0 text-muted">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <!-- <h3 class="d-inline-block d-sm-none text-muted">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3> -->
                        <div class="col-12 mx-auto d-block">
                            
                            <div v-if="images.length">
                                <div  v-for="(image,index) in images" :key="image.id">
                                    <div v-show="index==0">
                                    <img v-if="imgshow==false" :src="image.url" class="product-image img-fluid" alt="Product Image" style="height: 25%; object-fit: cover; object-fit: contain;">
                                    <img v-else :src="imgProduct" class="product-image" alt="Product Image">
                                    </div>
                                </div>
                            </div>
                            <div v-else class="col-12 product-image-thumbs mb-3" style="margin-left: 5%;">
                                <div class="product-image active"><img class="img-responsive" :src="imgProduct" alt="noimagen"></div>
                            </div>
                        </div>
                        <div class="col-12 product-image-thumbs mb-3" style="margin-left: 5%;">
                            <div v-for="image in images" :key="image.id">
                                <div class="product-image-thumb active" @click="imageShow(image.url)"><img class="img-responsive" :src="image.url" :alt="image.id"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 text-muted">
                        <!-- Descripción del producto -->
                        <status-component class="float-right mr-3 pt-4" :data="data"></status-component>
                        <h3 v-if="data.name" class="my-3" v-text="data.name"></h3>
                        <h3 v-else class="my-3 text-danger" v-text="noProduct"></h3>
                        <div>
                            
                        <p><span class="input-group-text"><i class="fas fa-barcode">&nbsp;</i><span class="ml-2">{{ data.code }}</span></span></p>
                        <p v-if="data.description" v-text="data.description"></p>
                        <p v-else>El producto debe ser registrado y agregarse una breve descripción.</p>

                        </div>
                        <hr>
                        <h4>Precios del Producto</h4>
                        <h6>Stock Disponible : {{ stock }}</h6>

                        <div class="bg-gray py-2 px-3 mt-4">
                            <h4 class="mt-0">
                            <small>Sin IVA: {{ tax | currency }}</small>
                            </h4>
                            <h3 class="mb-0">Bs. {{ unit_price | currency }} | $. {{ data.divisa_unit | currency }}</h3>
                        </div>
                        <div class="bg-gray disabled color-palette py-2 px-3 mt-4">
                            <h4 class="mt-0">
                            <small>Sin IVA: {{ tax_wholesale | currency }} </small>
                            </h4>
                            <h3 class="mb-0">Bs. {{ wholesale_price | currency }} | $. {{ data.wholesale_divisa | currency }} | Pack. {{ wholesale_quantity }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"></div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import VueNumerals from 'vue-numerals';
Vue.use(VueNumerals); // default locale is 'en'

import { compensateScroll } from '@fullcalendar/core'
export default {
    props:{
        data:{},
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
            imgProduct: '/images/img/noimagen.jpg',
            noProduct: 'Producto No Registrado'
        }
    },
    computed:{
        stock: function(){
            if(!this.data.stock){               
                return 0;
            }else{
                return this.data.stock;
            }
        },
        wholesale_quantity: function(){
            if(!this.data.wholesale_quantity){               
                return 0;
            }else{
                return this.data.wholesale_quantity;
            }
        },
        price_gain_u: function(){
            let result = 0;
            if(this.data.price > 0){
                result = (this.data.price * this.data.margin_gain_u / 100);
            }    
            return result;
        },
        // unit_price: function(){
        //     var result = 0;
        //     if(this.data.wholesale_quantity > 0 || this.data.price > 0){
        //         var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.price)) / this.data.wholesale_quantity).toFixed(2);
        //     }
        //     return result;
        // },
        unit_price: function(){
            let result = 0;
            if(this.data.price > 0){
                result = parseFloat(this.data.price) + parseFloat(this.price_gain_u);
            }
            return result;
        },
        price_gain_w: function(){
            let result = 0;
            if(this.data.price > 0){
                result = Math.round(this.cost_pack * this.data.margin_gain_w / 100).toFixed(2);
            }
            return result;
        },
        wholesale_price: function(){
            let result = 0;
            if(this.data.wholesale_quantity > 0){
                 result = parseFloat(this.price_gain_w) + parseFloat(this.cost_pack);
            }
            return result;
        },
        tax_wholesale(){
            let tax = 16;
            let priceTax = this.wholesale_price * tax/100;
            return (this.wholesale_price - priceTax).toFixed(2);
        },
        tax(){
            let tax = 16;
            let priceTax = this.unit_price * tax/100;
            return (this.unit_price - priceTax).toFixed(2);
        },
        cost_pack: function(){
            let result = 0;
            if(this.data.price){
                result = this.data.price*this.data.wholesale_quantity;
            }
            return result;
        }
    },
    methods:{
        imageShow(data){
            this.imgshow = true;
            this.imgProduct = data;      
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