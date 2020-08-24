<template>
    <div class="card card-default card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-invoice">&nbsp;</i>Venta</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="row col-md-12  pt-3 pb-3 border">
                    <div v-if="customer" class="col-md-9">
                        <label for="">Cliente</label>
                        <input class="form-control" type="text" v-model="customer.name" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="">Impuesto IVA</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-percentage"></i>
                                </span>
                            </div>
                            <input class="form-control text-right" type="text" v-model="iva" readonly>
                        </div>
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4" v-model="checked" @click="inputChange">
                            <label class="custom-control-label" for="customSwitch4">
                                <small v-if="checked" class="text-primary">Aplica IVA</small>
                                <small v-else class="text-primary">Exento de IVA</small>
                            </label>
                        </div>
                    </div>    
                </div>
                <div class="row col-md-12 form-group mt-3 pt-3 pb-3 border">
                    <div class="col-md-4">
                        <label for="">Tipo de Comprobante <span class="text-danger">(*)</span></label>
                        <select class="custom-select" :class="{'is-invalid' : errors.type_voucher}" v-model="selected">
                          <option value="">Seleccione</option>
                          <option>Factura</option>
                          <option>Nota</option>
                        </select>
                        <span v-if="errors.type_voucher" class="invalid-feedback" role="alert" v-html="errors.type_voucher"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="">N° de Factura <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                            </div>
                            <input class="form-control text-right" type="text" v-model="num_voucher" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">N° de Comprobante <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                            </div>
                            <input class="form-control text-right" :class="{'is-invalid' : errors.num_bill}" type="text" v-model="num_bill" placeholder="000000" maxlength="6">
                            <span v-if="errors.num_bill" class="invalid-feedback" role="alert" v-html="errors.num_bill"></span>
                        </div>
                    </div>
                </div>
                <div class="row col md-12 mt-3 pb-3 border">
                    <div class="table-responsive p-0">
                        <table class="table table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                    <td>{{ index+1 }}</td>
                                    <td>{{ detail_sale.name }}</td>
                                    <td>{{ detail_sale.type_sale }}</td>
                                    <td class="text-center">{{ detail_sale.quantity }}</td>
                                    <td class="text-center">{{ detail_sale.pack }}</td>
                                    <td>{{ detail_sale.price | currency }}</td>
                                    <td style="text-align: center;">{{ parseFloat(detail_sale.discount).toFixed() }}</td>
                                    <td style="text-align: right;">
                                        <div v-if="detail_sale.type_sale=='Venta Mayor'">
                                            {{ (detail_sale.price*detail_sale.pack)-(detail_sale.mont_discount) | currency }}
                                        </div>     
                                        <div v-else>
                                            {{ (detail_sale.price*detail_sale.quantity)-(detail_sale.mont_discount) | currency }}
                                        </div> 
                                    </td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="7" class="text-right"><strong>Total Parcial</strong></td>
                                    <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ (calculateTotal-totalTax).toFixed(2) | currency }} </td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="7" class="text-right"><strong>Total Impuesto</strong></td>
                                    <td class="text-right"><span class="float-left" v-text="typeCurrency"></span> {{ totalTax = (total * iva/100).toFixed(2) | currency }} </td>
                                </tr>
                                <tr style="background-color: #1A8AB6; border-top: white 1px solid;">
                                    <td colspan="7" class="text-right text-white"><strong>Total Neto</strong></td>
                                    <td class="text-right text-white"><span class="float-left" v-text="typeCurrency"></span> {{ total=calculateTotal | currency }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
        <!-- /.card-body -->
        <!-- <div class="card-footer"> -->
            <!-- <button type="submit" class="btn btn-default btn-sm" @click.prevent="closeForm()">Cancelar</button> -->
            <!-- <button type="submit" class="btn btn-info btn-sm float-right" @click.prevent="storeInvoice()">Agregar</button> -->
        <!-- </div> -->
        <!-- /.card-footer -->
    </div>
</template>

<script>
// Local Directive - vue-the-mask
import {mask} from 'vue-the-mask'

export default {
    props:{
        customer: {},
        detail_sales: {
            type: Array,
            default: () => ({}),
        },
        errors: {
            type: Object,
             default: () => ({}),
        },
        iva: {
            type: Number,
        },
        typeCurrency: {
            type: String,
        }
    },  
    directives: {mask},  
    data(){
        return {
            total: 0.00,
            totalTax: 0.00,
            totalPartials: 0.00,
            checked:true,
            selected: '',
            type_voucher: '',
            num_bill:'',
            num_voucher:'',
        }
    },
    mounted() {
        this.getCount();
    },
    watch: {
        selected: function(){
            this.type_voucher = this.selected;
            this.$emit('selectType', this.type_voucher);
            this.$emit('numVoucher', this.num_voucher);
        },
        num_bill: function(){
            this.$emit('numBill', this.num_bill);
        },
        total: function(){
            this.$emit('invoiceTotal', this.total);
        }
    },
    computed:{
        user(){
            let user = document.head.querySelector('meta[name="user"]');
            return JSON.parse(user.content);
        },
        calculateTotal: function(){
            var result = 0.0;
            for(var i=0; i<this.detail_sales.length; i++){
                if(this.detail_sales[i].type_sale == 'Venta Mayor'){
                    result = result+(this.detail_sales[i].price*this.detail_sales[i].pack)-(this.detail_sales[i].mont_discount);
                }else if(this.detail_sales[i].type_sale == 'Venta Detal'){
                    result = result+(this.detail_sales[i].price*this.detail_sales[i].quantity)-(this.detail_sales[i].mont_discount);
                }
            }
            return result;
        }
    },
    methods:{
        inputChange(){
            if(this.checked == true){
                this.checked = false;
                this.iva=0.00;
            }else{
                this.checked = false;
                this.iva=0.16;
            }
            this.$emit('tax', this.iva);
        },
        getCount(){
            var url = "api/ventas/num_factura";
            axios.get(url).then(response => {
                this.num_voucher = response.data;
                console.log(this.num_voucher)
            })
            // eslint-disable-next-line
            .catch(errors => {
                //Handle Errors
            })
        }
    }
}
</script>

