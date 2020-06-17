<template>
    <div class="container pt-2">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-muted">
                            <i class="fas fa-tag" style="font-size: 20px;">&nbsp;</i>
                            <strong>{{data.name}}</strong>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody class="text-muted">
                                <tr>
                                    <th width=300>Stock</th>
                                    <td v-text="data.stock"></td>
                                </tr>
                                <tr>
                                    <th width=300>Bulto - Paca</th>
                                    <td v-text="data.wholesale_quantity"></td>
                                </tr>
                                <tr>
                                    <th width=300>Categoría</th>
                                    <td v-text="categoryName.name"></td>
                                </tr>
                                <tr>
                                    <th width=300>Descripción:</th>
                                    <td v-text="data.description"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-muted">
                            <i class="fas fa-barcode" style="font-size: 20px;">&nbsp; </i>
                            <strong>Código de Barras</strong>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                    </tr>
                                </thead>
                                <tbody class="text-muted">
                                    <tr>
                                        <th width=300>Código</th>
                                        <td>
                                            <barcode :value="data.code" :options="{ format: 'EAN-13'}">
                                            </barcode>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-muted">
                            <i class="fas fa-hand-holding-usd" style="font-size: 20px;">&nbsp; </i>
                            <strong>Balance de Costos</strong>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active ml-0" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Precio Detal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Precio Mayor</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <table class="table table-sm">
                                        <tbody class="text-muted">
                                            <tr>
                                                <th width=300>Precio Costo:</th>
                                                <td v-text="data.cost_price"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Margen de Ganancia</th>
                                                <td v-text="data.margin_gain_u"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Precio Divisa</th>
                                                <td v-text="divisa_unit"></td>
                                            </tr>
                                            <tr>
                                            <th width=300>Precio Venta</th>
                                                <td v-text="unit_price"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                    <table class="table table-sm">
                                        <tbody class="text-muted">
                                            <tr>
                                                <th width=300>Precio Costo:</th>
                                                <td v-text="data.cost_price"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Margen de Ganancia</th>
                                                <td v-text="data.margin_gain_w"></td>
                                            </tr>
                                            <tr>
                                                <th width=300>Precio Divisa</th>
                                                <td v-text="data.wholesale_divisa"></td>
                                            </tr>
                                            <tr>
                                            <th width=300>Precio Venta</th>
                                                <td v-text="wholesale_price"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-muted">
                            <i class="fas fa-camera" style="font-size: 20px;">&nbsp; </i>
                            <strong>Imagen del Producto</strong>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody class="text-muted">
                                <tr>
                                    <th width=300>Imagen:</th>
                                    <td>
                                        <!-- <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueBarcode from 'vue-barcode';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
export default {
    props: ['data','categoryName','divisa'],
    components:{
        'barcode': VueBarcode,
        'vueDropzone': vue2Dropzone,
    },
    computed:{
        price_gain_u: function(){
            var result = (this.data.cost_price * this.data.margin_gain_u / 100).toFixed(2);
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
            if(this.data.stock > 0 || this.data.cost_price > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.cost_price)) / this.data.stock).toFixed(2);
            }
            return result;
        },
        price_gain_w: function(){
            var result = (this.data.cost_price * this.data.margin_gain_w / 100).toFixed(2);
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
            if(this.datawholesale_quantity > 0 || this.price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.data.cost_price)).toFixed(2);
            }
            return result;
        }
    }
}
</script>