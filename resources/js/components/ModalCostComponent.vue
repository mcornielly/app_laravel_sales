<template>
   <div class="modal fade" id="modal-cost" data-backdrop="static"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content  bg-secondary">
                <div class="modal-header">
                <h4 class="modal-title" v-text="title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <!-- Balance de Costos -->
                    <div class="row col-md-12 text-muted">
                        <div class="col-md-6">
                            <div class="card card-default card-default">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-coins">&nbsp;</i> Precio al Detal</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">(%) Ganancia</label>
                                        <div class="col-xl-6 col-md-5 col-sm-5">
                                            <input type="range" min="0" max="100" step="1" value="50" class="form-control"  v-model="margin_gain_u">
                                        </div>
                                        <div class="col-xl-3 col-md-4 col-sm-4">
                                            <input type="number" class="form-control" v-model="margin_gain_u">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Ganancia</label>
                                        <div class="col-md-9">
                                            <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="price_gain_u" disabled>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Precio ($)</label>
                                        <div class="col-md-9">
                                            <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="divisa_unit" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Precio (Bs.)</label>
                                        <div class="col-md-9">
                                            <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="unit_price" disabled>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <span><small class="text-white" Monto de Inversión : {{ amount_inv | numeralFormat('0.00[,]00') }}</small></span>    
                        </div>
                        <div class="col-md-6">
                            <div class="card card-default card-default">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-coins">&nbsp;</i> Precio al Mayor</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">(%) Ganancia</label>
                                        <div class="col-xl-6 col-md-5 col-sm-5">
                                            <input type="range" min="0" max="100" step="1" value="50" class="form-control" v-model="margin_gain_w">
                                        </div>
                                        <div class="col-xl-3 col-md-4 col-sm-4">
                                            <input type="number" class="form-control" v-model="margin_gain_w">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Ganancia</label>
                                        <div class="col-md-9">
                                            <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="price_gain_w" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Precio ($)</label>
                                        <div class="col-md-9">
                                            <input v-imask="mask.amount" type="text" class="form-control text-right"  v-model="wholesale_divisa" disabled>
                                        </div>
                                    </div>                           
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Precio (Bs.)</label>
                                        <div class="col-md-9">
                                            <input v-imask="mask.amount" type="text" class="form-control text-right" v-model="wholesale_price" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" @click="updateCost()" data-dismiss="modal" data-backdrop="false">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Vue from 'vue'
import {IMaskDirective} from 'vue-imask';
import VueNumerals from 'vue-numerals';
let user = document.head.querySelector('meta[name="user"]');

export default {
    directives: {
      imask: IMaskDirective,
    },
    props:{
        data: {
            type: Object,
            default: () => ({}),
        },
        title: {
            type: String,
            default: '',
        },
        divisa: {
            type: Number,
            default: 0
        },
        stock: {
            type: String, 
        },
        wholesale_quantity: {
            type: String, 
        },
        price: {
            type: String,
        }
    },
    data(){
        return{
            mask: {
                amount: {
                    mask: Number,
                    scale: 2, 
                    signed: false,
                    thousandsSeparator: ".", 
                    padFractionalZeros: true, 
                    normalizeZeros: true,
                    radix: ",", 
                    mapToRadix: ["."], 
                    max: 100000000
                }
            },
            id: 0,
            margin_gain_u: 50,
            margin_gain_w: 25,
            amount_inv: 0,
            btnAdd: true,
            status: '1',
            errors: ''
        }
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        },
        price_gain_u: {
            get: function(){
                var result = 0;
                if(this.price > 0){
                    this.amount_inv = this.price * this.stock; 
                    result = (Math.round(this.amount_inv * this.margin_gain_u / 100)).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }
        },
        divisa_unit: {
            get: function(){
                var result = 0;
                if(this.divisa > 0 || this.unit_price > 0){
                    var result = (this.unit_price / this.divisa).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }
        },
        unit_price: {
            get: function(){
                var result = 0;
                if(this.stock > 0 || this.price > 0){
                    var result = ((parseFloat(this.price_gain_u) + parseFloat(this.amount_inv)) / this.stock).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }
        },
        price_gain_w: {
            get: function(){
                var result = 0;
                if(this.amount_inv > 0){
                    var result = (Math.round(this.amount_inv * this.margin_gain_w / 100)).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }
        },
        wholesale_divisa: {
            get: function(){
                var result = 0;
                if(this.divisa > 0 || this.wholesale_price > 0){
                    result = (this.wholesale_price / this.divisa).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }

        },
        wholesale_price: {
            get: function(){
                var result = 0;
                if(this.wholesale_quantity > 0 || this.amount_inv > 0){
                    result = Math.round((parseFloat(this.price_gain_w) + parseFloat(this.amount_inv))).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }
        }
    },
    methods:{
        updateCost(){
            this.id = this.data.id;
            var url = `api/producto/actualizar_costo/${this.id}`;
            axios.put(url,{
                'id' : this.id,
                'name' : this.data.name,
                'category_id' : this.data.category_id,
                'code' : this.data.code,
                'description' : this.data.description,
                'price' : this.price,
                'stock' : this.stock,
                'margin_gain_u' : this.margin_gain_u,
                'divisa_unit' : this.divisa_unit,
                'wholesale_quantity' : this.wholesale_quantity,
                'margin_gain_w' : this.margin_gain_w,
                'wholesale_divisa' : this.wholesale_divisa,
                'user_id': this.user.id,
                'status': this.status, 
            }).then(response =>{
                // console.log(response.data)
                toastr.success("La Ganacia del Producto ha sido actualizado.");
                this.$emit('updateCost', this.btnAdd=false); 
            }).catch(error => {
                if (error.response) {
                    this.errors = error.response;
                    console.log(this.errors)
                    toastr.error("ERROR - En la validaciones.");
                }
            });    
        },
        closeModal(){
            this.selectedRow = {};
            this.errors = '';
        },

    }
}
</script>