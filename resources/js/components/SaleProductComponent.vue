<template>
    <div>
        <div class="card card-default card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tags">&nbsp;</i>Producto</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input ref="code" type="text" @keyup="getDataProduct()" class="form-control text-center" id="input_focus" v-model="code" maxlength="13" placeholder="Ingrese Código del Producto" autocomplete="off">
                            <div class="input-group-append">
                                <a href="" @click="clearCode()" class="btn btn-default" data-toggle="modal" data-target="#modal-list-prod"><i class="fas fa-search" aria-hidden="true">&nbsp;</i> Buscar Producto</a>
                            </div>
                        </div>
                    </div>     
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Producto</label>
                            <input type="text" class="form-control" v-model="product.name" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Precio Bs <span class="text-danger">(*)</span></label>
                            <!-- <input class="form-control text-right" v-model.lazy="price" v-money="money" readonly> -->
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
                                class="form-control text-right" 
                                placeholder="0,00"
                                require
                            >
                            </imask-input>    
                            <span v-show="product.price"><small class="text-primary">Precio act.: {{ product.divisa_unit | currency }}</small></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Cantidad <span class="text-danger">(*)</span></label>
                            <input type="number" min="0" class="form-control text-center" v-model="quantity" placeholder="0">
                            <span v-show="product.stock"><small class="text-primary">Stock actual:{{ product.stock }}</small></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <label for="">Cantidad Mayor <span class="text-danger">(*)</span></label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <input type="checkbox">
                                </span>
                            </div>
                            <input type="text" class="form-control text-center" v-model="wholesale_quantity" readonly>
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Cantidad Mayor <span class="text-danger">(*)</span></label>
                            <input type="number" min="0" class="form-control" v-model="wholesale_quantity" placeholder="0">
                            <span v-show="product.wholesale_quantity"><small class="text-primary">Pack :{{ product.wholesale_quantity }}</small></span>
                        </div> -->
                    </div>
                    <div class="col-md-1" style="margin-block: inherit; padding-top: 7px;">
                        <div class="form-group">
                            <button :disabled="btnDiscount" @click="costBalance(product)" data-toggle="modal" data-target="#modal-cost" class="btn btn-block btn-primary float-right" title="Descuento %">
                                <i class="fas fa-percentage" aria-hidden="true">&nbsp;</i>
                            </button>
                        </div>    
                    </div>
                    <div class="col-md-1" style="margin-block: inherit; padding-top: 7px;">
                        <div class="">
                            <button :disabled="btnAdd" @click="addListProducts(product)" class="btn btn-block btn-success" title="Agregar Producto">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="detail_incomes.length">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Productos Agragados</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped text-nowrap">
                            <thead>
                                <tr>
                                <th>Opción</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Pack</th>
                                <th>Precio</th>
                                <th style="text-align: center;">Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detail_income, index) in detail_incomes" :key="detail_income.id">
                                    <td>
                                        <button @click="deleteListProduct(index)" type="button" class="btn btn-danger btn-sm" title="Quitar Producto">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </td>
                                    <td>{{ detail_income.name }}</td>
                                    <td>{{ detail_income.quantity }}</td>
                                    <td>{{ detail_income.wholesale_quantity }}</td>
                                    <td>{{ detail_income.price | currency }}</td>
                                    <td style="text-align: right;">{{ detail_income.price*detail_income.quantity | currency }}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="5" class="text-right"><strong>Total Neto</strong></td>
                                    <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ calculateTotal | currency }} </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>            
            </div>
        </div>

        <div>
           <modal-list-prod 
                @selectProduct="product = $event" 
                @saleWhole="wholesale_quantity = $event" 
                @salePrice="price = $event" 
                :item="item"></modal-list-prod> 
        </div>     
    </div>
</template>

<script>
import Vue from 'vue'
import {VMoney} from 'v-money'
import {mask} from 'vue-the-mask'
import {IMaskComponent} from 'vue-imask';

export default {
    props:[
        'divisa',
        'typeCurrency'
    ],
    directives: {
        money: VMoney,
        mask,
    },
    components: {
        'imask-input': IMaskComponent,
    },
    data(){
        return{
            url:"api/producto/search/",
            code:'',
            products:[],
            product:{},
            value: '',
            money: {
                decimal: ',',
                thousands: '.',
                prefix: '',
                suffix: '',
                precision: 2,
                masked: false /* doesn't work with directive */
            },
            price: '',
            stock: '',
            quantity: '',
            wholesale_quantity: 0,
            detail_incomes:[],
            modalCost: false,
            btnDiscount: true,
            btnAdd: true,
            title:'',
            errors:'',
            item:false,
            onAccept (value) {
                console.log(value)
                // const maskRef = e.detail;
                // this.value = maskRef.value;
                // console.log('accept', maskRef.value);
            },
        }
    },
    created(){
        this.setFocus();
    },
    watch: {
        price: function(){
            if(this.price != '' && this.quantity != ''){
                this.btnDiscount = false;
                this.btnAdd = false;
            }else{
                this.btnDiscount = true;
                this.btnAdd = true;
            }
        },
        quantity: function(){
            if(this.price != '' && this.quantity != ''){
                this.btnDiscount = false;
                this.btnAdd = false;
            }else{
                this.btnDiscount = true;
                this.btnAdd = true;
            }
        },
        unmaskedValue: function(){
            alert(1)
        }
    },
    computed:{
        calculateTotal: function(){
            var result = 0.0;
            for(var i=0; i<this.detail_incomes.length; i++){
                result = result+(this.detail_incomes[i].price*this.detail_incomes[i].quantity)
            }
            return result;
        }

    },
    methods:{
        clearCode(){
            this.code = '';
        },
        formatPrice(value) {
            let val = (value/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        setFocus(){
            this.$nextTick(() => this.$refs.code.focus());
        },
        getDataProduct(){
            var leng_code = this.code.length;
            var code = this.code;
            var x = 0;
            if(leng_code == 13 && x == 0){
                x=x+1;
                var url = `${this.url}${code}`;
                axios.get(url).then(response => {
                    var product = response.data.product;
                    this.price = product[0].price;
                    this.wholesale_quantity = product[0].wholesale_quantity;
                    console.log(product)
                    if(this.findProduct(product[0].id)==false){
                        if(product.length){
                            this.product = response.data.product[0];
                            // this.btnDiscount=false;     
                        }else{
                            toastr.error("ERROR - Producto no registrado.");
                            // this.btnDiscount=true;     
                            this.clearSearch();
                        }
                    }else{
                        toastr.error("El producto ya se encuentra en la lista.");
                    }
                }).catch(error =>{
                        // console.log(error.response);

                });
            }else{
                if(this.code == ''){
                        this.clearSearch();
                        this.resultProduct = false;
                }
            }
        },
        clearSearch(){
            this.product = {};
            this.price = 0;
            this.wholesale_quantity = 0;
            // this.errors = error.response;
            // this.code = '';
        },
        addListProducts(data){
           if(this.quantity > 0 && this.wholesale_quantity > 0){
               if(this.findProduct(this.product.id)==false){
                   this.detail_incomes.push({
                       id: this.product.id,
                       name: this.product.name,
                       price: this.price, 
                       quantity: this.quantity,
                       wholesale_quantity: this.wholesale_quantity,
                   });
                   this.$emit('addProduct', this.detail_incomes); 
                   //Se limpia el proceso
                   this.product={};
                   this.price='';  
                   this.quantity = 0;
                   this.wholesale_quantity = 0;
                   this.code='';
               }else{
                   toastr.error("El producto ya se encuentra en la lista.");
               }
           }else{
                toastr["info"]("Debe completar los campos requeridos, para dar ingreso al Producto.");
           } 

        },
        findProduct(id){
            var item=false;

            for(var i=0; i<this.detail_incomes.length; i++){
                if(this.detail_incomes[i].id==id){
                    item = true;
                    this.item = item;
                }
            }
            return this.item = item;
                
        },
        deleteListProduct(index)
        {
            this.detail_incomes.splice(index,1)
        }

    }
}
</script>

