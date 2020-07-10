<template>
    <div class="modal fade" id="modal-ex">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title">Consultar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <form role="form" @submit.prevent="getDataProduct()" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Código del Producto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="text" :on="inputListeners()" class="form-control text-center" id="input_focus" v-model="code" maxlength="13" placeholder="Ingrese Código del Producto" autocomplete="off">
                                <!-- <input type="text" @keyup="getDataProduct()" class="form-control text-center" id="input_focus" v-model="code" maxlength="13" placeholder="Ingrese Código del Producto" autocomplete="off"> -->
                                <!-- <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors"></span> -->
                            </div>
                        </div>
                        <div v-show="resultProduct">
                            <hr class="bg-light disabled color-palette">
                            <prices-product
                                :data="data"
                                :images="images"
                                :imgshow="imgshow"
                                >
                            </prices-product>   
                        </div>
                        <!-- <div v-show="resultFail">
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    <li>No existe producto registrado.</li>  
                                </ul>
                            </div>    
                        </div> -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal" @click.prevent="closeModal()">Cerrar</button>
                        <button  @click.prevent="getDataProduct()" type="submit" class="btn btn-outline-light">Consultar</button>
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

export default {
    data(){
        return {
            url:"api/producto/search/",
            data: {},
            errors: '',
            code:'',
            images:[],
            resultProduct:false,
            resultFail:false,
            imgshow: false
        }
    },
    components:{
        'barcode': VueBarcode,
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        },
        inputListeners: function () {
            var vm = this
            // `Object.assign` merges objects together to form a new object
            return Object.assign({},
                // We add all the listeners from the parent
                this.$listeners,
                console.log(this.$listeners)
                // Then we can add custom listeners or override the
                // behavior of some listeners.
                ,{
                // This ensures that the component works with v-model
                input: function (event) {
                    vm.$emit('input', event.target.value)

                    console.log(event.target.value);
                }
            })
        }
    },
    methods:{
        getDataProduct(){
            var leng_code = this.code.length;
            var code = this.code;
           if(leng_code == 13 && code != ''){
               var url = `${this.url}${this.code}`;
               axios.get(url).then(response => {
                   console.log(response.data[0]);
                    this.data = response.data[0];
                    this.images = response.data[0].photos;
                    this.resultProduct = true;
               }).catch(error =>{
                    console.log(error.response);
                    this.errors = error.response;
                    this.clearSearch();
                    this.resultProduct = true;
               });
           }else{
               if(this.code == ''){
                    this.clearSearch();
                    this.resultProduct = false;
               }
           }
        },
        clearSearch(){
            this.data = {};
            this.images = [];
        },
        closeModal(){
            this.code='';
            this.clearSearch();
            this.resultProduct = false;
        },

    }
}
</script>

<style>
.capitalize {
  text-transform: capitalize;
}
</style>