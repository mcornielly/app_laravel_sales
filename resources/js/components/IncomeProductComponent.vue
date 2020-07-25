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
                                <a href="" class="btn btn-default" @click.prevent="test()"><i class="fas fa-search" aria-hidden="true">&nbsp;</i> Buscar Producto</a>
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
                            <label for="">Precio(Detal) Bs</label>
                            <input type="text" step="any" class="form-control text-right" v-model.lazy="product.price" v-money="money">
                            <span v-show="product.price"><small class="text-primary">Precio act.: {{ product.price }}</small></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Cantidad</label>
                            <input type="number" min="0" class="form-control" v-model="stock" v-mask="'#.###.###.###'">
                            <span v-show="product.stock"><small class="text-primary">Stock actual:{{ product.stock }}</small></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Cantidad Mayor</label>
                            <input type="number" min="0" class="form-control" v-model="wholesale_quantity">
                            <span v-show="product.wholesale_quantity"><small class="text-primary">Pack :{{ product.wholesale_quantity }}</small></span>
                        </div>
                    </div>
                    <div class="col-md-1" style="margin-block: inherit; padding-top: 7px;">
                        <div class="form-group">
                            <button @click="addProducts()" class="btn btn-block btn-primary" title="Fijar Margen %">
                                <i class="fas fa-percentage"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-1" style="margin-block: inherit; padding-top: 7px;">
                        <div class="form-group">
                            <button @click="addListProducts(product)" class="btn btn-block btn-success" title="Agregar Producto">
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
                            <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                <th>Opción</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Pack</th>
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
                                    <td>{{ detail_income.stock }}</td>
                                    <td>{{ detail_income.price }}</td>
                                    <td>{{ detail_income.wholesale_quantity }}</td>
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
    </div>
</template>

<script>
import Vue from 'vue'
import {VMoney} from 'v-money'
import {mask} from 'vue-the-mask'

export default {
    directives: {
        money: VMoney,
        mask
        },
    data(){
        return{
            url:"api/producto/search/",
            code:'',
            products:[],
            product:{
                name:'',
                category_id:0,
                price:0,
                description:'',
                stock:0,
                margin_gain_u:0,
                divisa_unit: 0,
                wholesale_quantity:0,
            },
            money: {
                decimal: ',',
                thousands: '.',
                prefix: '',
                suffix: '',
                precision: 2,
                masked: false /* doesn't work with directive */
            },
            stock:0,
            wholesale_quantity:0,
            detail_incomes:[],
            errors:''
        }
    },
    created(){
        this.setFocus();
    },
    methods:{
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
                        console.log(response.data.product);
                        var product = response.data.product;
                        if(product.length){
                            this.product = response.data.product[0];
                            console.log(this.product)
                            // this.code = '';
                        }else{
                            toastr.error("ERROR - Producto no registrado.");
                            this.clearSearch();
                        }
                }).catch(error =>{
                        // console.log(error.response);
                        // this.errors = error.response;
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
            this.code = '';
        },
        addListProducts(data){
           console.log(data)
           this.detail_incomes.push({
               id: this.product.id,
               name: this.product.name,
               price: this.product.price,
               stock: this.stock,
               wholesale_quantity: this.wholesale_quantity 
           });
           this.product={};
           this.stock=0;     
           this.wholesale_quantity=0;     
        },
        deleteListProduct(index)
        {
            this.detail_incomes.splice(index,1)
        }
    }
}
</script>

