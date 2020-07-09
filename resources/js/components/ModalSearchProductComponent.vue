<template>
    <div class="modal fade" id="modal-ex">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title">Info Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <form role="form" @submit.prevent="getDataProduct()" method="POST">
                    <div class="modal-body">
                        <label for="">Código del Producto</label>
                        <input type="text" class="form-control" id="input_focus" v-model="code" maxlength="10">
                    </div>
                    <hr>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button  @click.prevent="getDataProduct()" type="submit" class="btn btn-outline-light">Save changes</button>
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
            user_id:0,
            errors: '',
            name:'',
            product_id: 0,
            category_id: 0,
            description:'',
            price: 0,
            stock: 0,
            code:'',
            wholesale_quantity: 0,
            margin_gain_u: 0,
            margin_gain_w: 0,
            value:'',
            image: '',
            photos:[],
            close: false
        }
    },
    components:{
        'barcode': VueBarcode,
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
            if(this.data.wholesale_quantity > 0 || this.data.price > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.price)) / this.data.wholesale_quantity).toFixed(2);
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
            if(this.data.wholesale_quantity > 0 || this.data.price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.data.price)).toFixed(2);
            }
            return result;
        }
    },
    methods:{
        getDataProduct(){
            console.log(this.code)
            var url = `${this.url}${this.code}`;
            console.log(url)
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