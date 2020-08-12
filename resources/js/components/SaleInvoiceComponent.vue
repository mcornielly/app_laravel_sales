<template>
    <div class="card card-default card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-invoice">&nbsp;</i>Ingreso</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="row col-md-12  pt-3 pb-3 border">
                    <div v-if="provider" class="col-md-9">
                        <label for="">Proveedor</label>
                        <input class="form-control" type="text" v-model="provider.name" readonly>
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
                        <select class="custom-select" v-model="selected">
                          <option value="">Seleccione</option>
                          <option>Factura</option>
                          <option>Nota</option>
                        </select>
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
                            <input class="form-control text-right" type="text" v-model="num_bill" placeholder="000000" maxlength="6">
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
                                    <th>Cantidad</th>
                                    <th>Pack</th>
                                    <th >Precio</th>
                                    <th style="text-align: center;">Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detail_income, index) in detail_incomes" :key="detail_income.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ detail_income.name }}</td>
                                    <td>{{ detail_income.quantity }}</td>
                                    <td>{{ detail_income.wholesale_quantity }}</td>
                                    <td>{{ detail_income.price | currency }}</td>
                                    <td class="text-right">{{  detail_income.price*detail_income.quantity | currency }}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="5" class="text-right"><strong>Total Parcial</strong></td>
                                    <td class="text-right">Bs. {{ (calculateTotal-totalTax).toFixed(2) | currency }} </td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="5" class="text-right"><strong>Total Impuesto</strong></td>
                                    <td class="text-right">Bs. {{ totalTax = (total * iva).toFixed(2) | currency }} </td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="5" class="text-right"><strong>Total Neto</strong></td>
                                    <td class="text-right">Bs. {{ total=calculateTotal | currency }}</td>
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
        provider: {},
        detail_incomes: {
            type: Array,
        }
    },  
    directives: {mask},  
    data(){
        return {
            iva : 0.16,
            total: 0.00,
            totalTax: 0.00,
            totalPartials: 0.00,
            checked:true,
            selected: '',
            type_voucher: '',
            num_bill:'',
            num_voucher:'',
            errors:''
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
            for(var i=0; i<this.detail_incomes.length; i++){
                result = result+(this.detail_incomes[i].price*this.detail_incomes[i].quantity)
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
            var url = "api/ingresos/num_factura";
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

