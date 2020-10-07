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
                            <input ref="code" type="text" @keypress.enter="getDataProduct()" class="form-control text-center" id="input_focus" v-model="code" maxlength="13" placeholder="Ingrese Código del Producto" autocomplete="off">
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
                                readonly
                                require
                            >
                            </imask-input>
                            <div v-if="checked == false">
                                <span v-show="product.price"><small class="text-primary">Precio $ : {{ divisa_product_u | currency }}</small></span>
                            </div>
                            <div v-else>
                                <span v-show="product.price"><small class="text-primary">Precio $ : {{ divisa_product_w | currency }}</small></span>
                            </div>    
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Cant. <span class="text-danger">(*)</span></label>
                            <input type="number" min="0" class="form-control text-center" v-model="quantity" placeholder="0" :readonly="stockStop">
                            <span v-if="product.stock==0"><small :class="stockClass">Stock actual : 0</small></span>
                            <span v-else><small :class="stockClass">Stock actual : {{ stockLimit }}</small></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="">Pack <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <input type="checkbox" v-model="checked" @click="changeSale()">
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
                            <button :disabled="btnDiscount" @click="openModalDiscount()" data-toggle="modal" data-target="#modal-discount" class="btn btn-block btn-primary float-right" title="Descuento %">
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
                <div class="row" v-if="detail_sales.length">
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
                                        <th>Tipo Venta</th>
                                        <th>Cantidad</th>
                                        <th>Pack</th>
                                        <th>Precio</th>
                                        <th>% Descuento</th>
                                        <th style="text-align: center;">Sub-Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detail_sale, index) in detail_sales" :key="detail_sale.id">
                                            <td>
                                                <button @click="deleteListProduct(index)" type="button" class="btn btn-danger btn-sm" title="Quitar Producto">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                            </td>
                                            <td>{{ detail_sale.name }}</td>
                                            <td>{{ detail_sale.type_sale }}</td>
                                            <td style="text-align: center;">{{ detail_sale.quantity }}</td>
                                            <td style="text-align: center;">{{ detail_sale.pack }}</td>
                                            <td style="text-align: right;">{{ detail_sale.price | currency }}</td>
                                            <td style="text-align: center;">{{ detail_sale.discount }}</td>
                                            <td style="text-align: right;">
                                                <div v-if="quantity_w">
                                                    {{ (detail_sale.price*detail_sale.pack)-(detail_sale.mont_discount) | currency }}
                                                </div>     
                                                <div v-else>
                                                    {{ (detail_sale.price*detail_sale.quantity)-(detail_sale.mont_discount) | currency }}
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="7" class="text-right"><strong>Total Neto</strong></td>
                                            <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ calculateTotal | currency }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- <div class="row" v-if="detail_sales.length"> -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control text-right" v-model="divisa_price">
                                <div class="input-group-append">
                                    <span class="input-group-text ">.00</span>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>            
            </div>
        </div>

        <div>
           <modal-list-prod-sale 
                @selectProduct="product = $event" 
                @saleWhole="wholesale_quantity = $event" 
                @salePrice="price = $event"
                @addQuantity="quantity = $event"
                :item="item">
            </modal-list-prod-sale> 
        </div>

        <div>
            <div class="modal fade" id="modal-discount">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-secondary">
                        <div class="modal-header">
                        <h4 class="modal-title">Descuento del Producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="container" style="border-radius: 6px;border: 1px solid beige;">
                                <div class="form-group pt-3 pl-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio0" value="0" v-model="discount" checked>
                                        <label class="form-check-label">Descuento por 0 %</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio1" value="5" v-model="discount">
                                        <label class="form-check-label">Descuento por 5 %</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio2" value="10" v-model="discount">
                                        <label class="form-check-label">Descuento por 10 %</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio3" value="15" v-model="discount">
                                        <label class="form-check-label">Descuento por 15 %</label>
                                    </div>
                                </div>
                            </div>
                            <div class="container pt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" >Descuento (%)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                </div>
                                                <input type="text" class="form-control text-center" v-model="discount" maxlength="2" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" >Precio</label>
                                            <input type="text" class="form-control text-center" v-model="priceProduct" readonly v-money="money">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" >Cantidad</label>
                                            <input type="text" class="form-control text-center" v-model="quantity" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                <table class="table table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="bg-primary" colspan="2">Balance de Descuento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Monto Producto</td>
                                            <td class="text-right"><span class="float-left" v-text="typeCurrency"></span>{{ montProduct | currency }}</td>
                                        </tr>
                                        <tr>
                                            <td>Monto Descuento (%)</td>
                                            <td v-if="discount==0" class="text-right"><span class="float-left" v-text="typeCurrency"></span>0,00</td>
                                            <td v-else class="text-right"><span class="float-left" v-text="typeCurrency"></span>{{ productDiscount | currency }}</td>
                                        </tr>
                                        <tr>
                                            <td>Descuento Aplicado</td>
                                            <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ montProduct-productDiscount | currency }}</td>
                                        </tr>
                                        <!-- <tr style="background-color: #CEECF5;">
                                            <td colspan="6" class="text-right"><strong>Total Neto</strong></td>
                                            <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ calculateTotal | currency }} </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModalDiscount">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="addDiscount">Aplicar Descuento</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>     
    </div>
</template>

<script>
import Vue from 'vue'
import {VMoney} from 'v-money'
import {mask} from 'vue-the-mask'
import {IMaskComponent} from 'vue-imask';
// import { pack } from 'html2canvas/dist/types/css/types/color';

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
            url:"api/producto",
            code:'',
            codeSearched:'',
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
            quantity: 0,
            quantity_w: 0,
            discount: 0,
            montDiscount:0,
            margin_gain_u: 0,
            wholesale_quantity: 0,
            detail_sales:[],
            stock_limit: 15,
            btnDiscount: true,
            btnAdd: true,
            typeSale:'Venta Detal',
            title:'',
            errors:'',
            item:false,
            saleUnit:true,
            checked:false,
            priceProduct:0,
            totalDiscount:0,
            onAccept (value) {
                console.log(value)
                // const maskRef = e.detail;
                // this.value = maskRef.value;
                // console.log('accept', maskRef.value);
            }
        }
    },
    created(){
        this.setFocus();
    },
    watch: {
        quantity: function(){
            if(this.quantity > 0){
                this.btnDiscount = false;
                this.btnAdd = false;
            }else{
                this.btnDiscount = true;
                this.btnAdd = true;
            }
        }
    },
    computed:{
        calculateTotal: function(){
            let result = 0.0;
            for(let i=0; i<this.detail_sales.length; i++){
                if(this.detail_sales[i].type_sale == 'Venta Mayor'){
                    result = result+(this.detail_sales[i].price*this.detail_sales[i].pack)-(this.detail_sales[i].mont_discount);
                }else if(this.detail_sales[i].type_sale == 'Venta Detal'){
                    result = result+(this.detail_sales[i].price*this.detail_sales[i].quantity)-(this.detail_sales[i].mont_discount);
                }
            }
            return result;
        },
        divisa_price: function(){
            let result = 0.0;
            if(this.calculateTotal){
                result = Math.round(this.calculateTotal / this.divisa).toFixed();
            }

            return result;
        },
        divisa_product_u: function(){
            let result = 0.0;
            if(this.product.divisa_unit){
                result = Math.round(this.product.divisa_unit)
            }
            return result;
        },
        divisa_product_w: function(){
            let result = 0.0;
            if(this.product.wholesale_divisa){
                result = Math.round(this.product.wholesale_divisa)
            }
            return result;
        },
        numDecimal: function(){
            let decimal = Math.floor(parseFloat(this.divisa_price)) - Math.floor(this.divisa_price)
            console.log(this.divisa_price)
            return decimal.toFixed(2);
        },
        price_gain_u: {
            get: function(){
                let result = 0;
                let gain_u = 0.0;
                if(this.product.price){
                    gain_u = (Math.round(this.product.price * this.product.margin_gain_u / 100)).toFixed(2);
                    result = parseFloat(this.product.price) + parseFloat(gain_u);
                }
                return result;
            },
            set: function(){
                let result = 0;
                return result;
            }
        },
        price_gain_w: {
            get: function(){
                let result = 0.0;
                let gain_w = 0.0;
                let cost_pack = 0.0;
                if(this.product.price > 0){
                    cost_pack = this.product.price*this.product.wholesale_quantity;
                    gain_w = (Math.round(cost_pack * this.product.margin_gain_w / 100)).toFixed(2);
                    result  = parseFloat(cost_pack) + parseFloat(gain_w);

                }
                return result;
            },
            set: function(){
                let result = 0;
                return result;
            }
        },
        stockLimit: function(){
            let result = 0;
            if(this.checked){
                if(this.product.stock > this.product.wholesale_quantity){
                    result = this.product.stock - (this.product.wholesale_quantity*this.quantity);
                    this.btnDiscount = false;
                    this.btnAdd = false;
                }else{
                    result = this.product.stock - this.quantity;
                    this.btnDiscount = true;
                    this.btnAdd = true;
                }

            }else{
                if(this.product.stock > this.product.wholesale_quantity){
                    result = this.product.stock - this.quantity;
                    this.btnDiscount = false;
                    this.btnAdd = false;
                }else{
                    result = this.product.stock;
                    this.btnDiscount = true;
                    this.btnAdd = true;
                }
            }
            return result;
        },
        stockClass: function(){
            if(this.stock_limit > this.stockLimit){
                toastr["info"]("Stock Limit. El limite del stock del inventario ha sido superado.!")
                return 'text-danger';
            }else{
                return 'text-primary';
            }
        },
        stockStop: function(){
           let readonly = false;
            if(this.checked){
                if(this.stockLimit < this.wholesale_quantity){
                    readonly = true;
                }else{
                    readonly = false;
                }
            }else{
                if(this.stockLimit == 0){
                    readonly = true;
                }else{
                    readonly = false;
                }
            }
            return readonly;
        },
        montProduct: function(){
            let result = 0;
            if(this.checked){
                result = parseFloat(this.price_gain_w)*this.quantity;
            }else{
                result = parseFloat(this.price_gain_u)*this.quantity;
            }
            return result;
        },
        productDiscount: function(){
            let result = 0;
            result = parseFloat(this.montProduct)*this.discount/100;
            return result;
        },
        calculateDiscount: function(){
            let total_discount = 0.0;
            // let i = 0;
            total_discount = this.detail_sales[0].price*this.detail_sales[0].quantity*(this.detail_sales[0].discount/100);

            return total_discount;
        },

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
            // let leng_code = this.code.length;
            let code = this.code;
            
            if(code != this.codeSearched){
                this.clearSearch();
            }
            setTimeout(() => {
                let url = `${this.url}/${code}`;
                axios.get(url).then(response => {
                    let product = response.data.product;
                    let price = product[0].price;
                    this.codeSearched = product[0].code;
                    this.wholesale_quantity = product[0].wholesale_quantity;
                    if(product.length){
                        if(this.findProduct(product[0].id)==false){
                            this.product = response.data.product[0];
                            this.addQuantity(code);
                        }else{
                            toastr.error("El producto ya se encuentra en la lista.");
                        }
                    }
                    this.price = parseFloat(this.price_gain_u).toFixed(2);
                }).catch(error =>{
                    // console.log(error.response);
                    toastr.error("ERROR - Producto no registrado.");
                    this.clearSearch();
                });
                this.code='';
            }, 500)
   
        },
        addQuantity(code){
            if(code == this.codeSearched){
                this.quantity += 1;
            }else{
                this.quantity = 1;
            }
        },
        clearSearch(){
            this.product = {};
            this.price = '';
            this.quantity = 0;
            this.wholesale_quantity = 0;
        },
        addListProducts(data){
           let quantity = 0;
           let pack = 0;
           if(this.quantity_w){
               pack = this.quantity;
               quantity = this.quantity_w*pack;
           }else{
               pack = this.wholesale_quantity;
               quantity = this.quantity;
           } 
           if(this.quantity > 0 && this.wholesale_quantity > 0){
               if(this.findProduct(this.product.id)==false){
                   this.detail_sales.push({
                       product_id: this.product.id,
                       name: this.product.name,
                       price: this.price, 
                       pack: pack, 
                       quantity: quantity,
                       discount: this.discount,
                       wholesale_quantity: pack,
                       type_sale: this.typeSale,
                       mont_discount: this.montDiscount,
                   });
                   console.log(this.detail_sales)
                   this.$emit('addProduct', this.detail_sales); 
                   //Se limpia el proceso
                   this.product={};
                   this.price='';  
                   this.quantity = 0;
                   this.wholesale_quantity = 0;
                   this.code='';
                   this.checked=false;
                   this.discount = 0;
                   this.montDiscount = 0;
               }else{
                   toastr.error("El producto ya se encuentra en la lista.");
               }
           }else{
                toastr["info"]("Debe completar los campos requeridos, para dar ingreso al Producto.");
           } 

        },
        findProduct(id){
            let item=false;

            for(let i=0; i<this.detail_sales.length; i++){
                if(this.detail_sales[i].id==id){
                    item = true;
                    this.item = item;
                }
            }
            return this.item = item;
                
        },
        deleteListProduct(index)
        {
            this.detail_sales.splice(index,1)
        },
        changeSale(){
            if(this.product){
                if(this.checked){
                    this.typeSale = 'Venta Detal';
                    this.quantity_w = 0;
                    this.price = parseFloat(this.price_gain_u).toFixed(2);
            
                }else{
                    this.typeSale = 'Venta Mayor';
                    this.quantity_w = this.quantity * this.wholesale_quantity;
                    this.price = parseFloat(this.price_gain_w).toFixed(2);
                }
            }
        },
        openModalDiscount(){
            this.priceProduct = parseFloat(this.price).toFixed(2);
        },
        closeModalDiscount(){
            this.discount = 0;
            this.price = parseFloat(this.price_gain_u).toFixed(2);
        },
        addDiscount(){
            let discount = 0.0;
            if(this.checked){
                discount = parseFloat(this.price_gain_w)*parseFloat(this.discount)/100;
            }else{
                discount = parseFloat(this.price_gain_u)*parseFloat(this.discount)/100;
            }
            this.montDiscount = (discount * this.quantity).toFixed(2);
            
            $('#modal-discount').modal('hide');
        },
        // changeQty(data){
        //     alert(data)
        //     if(this.stockStop==true && data > 0){
        //         this.quantity = data-1;
        //         readonly = false;
        //     }
        // }


    }
}
</script>

