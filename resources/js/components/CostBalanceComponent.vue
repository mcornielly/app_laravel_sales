<template>
    <!-- Balance de Costos -->
    <div class="row col-md-12">
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
                            <input v-money="money" type="text" class="form-control text-right"  v-model="price_gain_u" disabled>
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Precio ($)</label>
                        <div class="col-md-9">
                            <input v-money="money" type="text" class="form-control text-right"  v-model="divisa_unit" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Precio (Bs.)</label>
                        <div class="col-md-9">
                            <input v-money="money" type="text" class="form-control text-right" v-model="unit_price" disabled>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <span><small class="text-white" v-money="money">Monto de Inversión : {{ amount_inv }}</small></span>
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
                            <input v-money="money" type="text" class="form-control text-right" v-model="price_gain_w" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Precio ($)</label>
                        <div class="col-md-9">
                            <input v-money="money" type="text" class="form-control text-right"  v-model="wholesale_divisa" disabled>
                        </div>
                    </div>                           
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Precio (Bs.)</label>
                        <div class="col-md-9">
                            <input v-money="money" type="text" class="form-control text-right" v-model="wholesale_price" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
export default {
    props:{
        data: {
            type: Object,
            default: () => ({}),
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
            money: {
                decimal: ',',
                thousands: '.',
                prefix: '',
                suffix: '',
                precision: 2,
                masked: false /* doesn't work with directive */
            },
            margin_gain_u: 50,
            margin_gain_w: 25,
            amount_inv: 0
        }
    },
    computed:{
        price_gain_u: {
            get: function(){
                var result = 0;
                if(this.price > 0){
                    this.amount_inv = this.price * this.stock; 
                    result = (this.amount_inv * this.margin_gain_u / 100).toFixed(2);
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
                    var result = (this.amount_inv * this.margin_gain_w / 100).toFixed(2);
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
                    result = (parseFloat(this.price_gain_w) + parseFloat(this.amount_inv)).toFixed(2);
                }
                return result;
            },
            set: function(){
                var result = 0;
                return result;
            }
        }
    }
}
</script>

