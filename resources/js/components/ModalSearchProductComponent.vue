<template>
    <div class="modal fade" id="modal-search">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"@click.prevent="closeModal()">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <!-- <form role="form" @submit.prevent="getDataProduct()" method="POST"> -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Código del Producto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="text" @keypress.enter="getDataProduct()" class="form-control text-center" id="input_focus" v-model="code" maxlength="13" placeholder="Ingrese Código del Producto" autocomplete="off">
                            </div>
                        </div>
                        <div v-show="resultProduct">
                            <hr class="bg-light disabled color-palette">
                            <prices-product
                                :data="product"
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
                    <div class="modal-footer" :class="{'justify-content-between':!resultProduct}">
                        <button type="button" class="btn btn-outline-light" :class="{'pull-right' : resultProduct}" data-dismiss="modal" @click.prevent="closeModal()">Cerrar</button>
                        <button v-show="!resultProduct" @click.prevent="getDataProduct()" type="submit" class="btn btn-outline-light">Consultar</button>
                    </div>
                <!-- </form> -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>  
</template>

<script>

import {IMaskDirective} from 'vue-imask';
import {IMaskComponent} from 'vue-imask';
import VueBarcode from 'vue-barcode';

export default {
    props:{
        title:{
            type: String,
            default: ''
        }
    },
    data(){
        return {
            url:"api/producto/search/",
            product: [],
            errors: '',
            code:'',
            images:[],
            resultProduct:false,
            resultFail:false,
            imgshow: false,
            codeSearched:''
        }
    },
    components:{
        'barcode': VueBarcode,
    },
    computed:{
        user(){
            let user = document.head.querySelector('meta[name="user"]');
            return JSON.parse(user.content);
        }
    },
    methods:{
        getDataProduct(){
            // var leng_code = this.code.length;
            var code = this.code;

            setTimeout(() => {
            var url = `${this.url}${code}`;
                axios.get(url).then(response => {
                    this.product = response.data.product[0]; 
                    if(this.product){
                       this.images = response.data.product[0].photos;
                       this.resultProduct = true;
                    }else{
                        this.product = [];
                    }
                    console.log(this.product)
                    
                    // $('#modal-search').on('shown.bs.modal', function() {
                    //     $('#input_focus').focus();
                    // });
                }).catch(error =>{
                    console.log(error);
                    // if(this.data.length == 0){
                    //     // this.errors = error.response;
                    //     this.clearSearch();
                    //     this.resultProduct = true;
                    // }    
                });
            this.code='';
            }, 500)        
        },
        clearSearch(){
            // this.data = {};
            this.images = [];
            this.code = '';
        },
        closeModal(){
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