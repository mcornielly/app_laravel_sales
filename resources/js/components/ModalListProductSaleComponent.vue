<template>
    <div class="modal fade" id="modal-list-prod" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content  bg-secondary">
                <div class="modal-header">
                <h4 class="modal-title" v-text="title"></h4>
                <button type="button" class="close" @click="closeModal()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form role="form" method="POST">
                    <div class="modal-body">
                            <data-table ref="tb"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                url="api/productos"
                                >
                            </data-table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                        <!-- <button type="submit" class="btn btn-primary" @click.prevent="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="actionModal('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button> -->
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import BtnListProductsComponentVue from './BtnListProductsComponent.vue';
import StatusComponentVue from './StatusComponent.vue';
import DataTableCurrencyUnit from './DataTableCurrencyUnit.vue';


Vue.use(DataTable);

export default {
    props:['item','priceCost'],
    components:{
        BtnListProductsComponentVue,
        StatusComponentVue,
        DataTableCurrencyUnit,
    },
    data(){
        return {
            title: 'Lista de Productos',
            translate:{
                nextButton: 'Siguiente', 
                previousButton: 'Anterior', 
                placeholderSearch: 'Buscar..'
            },
            theme: "dark",
            columns: [
                {
                    label: 'Accióm',
                    name: '',
                    orderable: false,
                    component: BtnListProductsComponentVue,
                    event: "click",
                    handler: this.selectProduct
                },
                {
                    label: 'Código',
                    name: 'code',
                    orderable: true,
                },
                {
                    label: 'Nombre',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Precio',
                    name: 'price',
                    orderable: true,
                    component: DataTableCurrencyUnit
                },
                {
                    label: 'Stock',
                    name: 'stock',
                    orderable: true,
                },
                {
                    label: 'Pack',
                    name: 'wholesale_quantity',
                    orderable: true,
                },
                {
                    label: 'Estatus',
                    component: StatusComponentVue,
                    orderable: true,
                },

            ],
            selectedRow: {},
            product:{},
            quantity: 0,
            wholesale_quantity: 0,
            price: 0,
            isLoading: false
        }
    },
    computed:{
        user(){
            let user = document.head.querySelector('meta[name="user"]');
            return JSON.parse(user.content);
        },
        price_gain_u: {
            get: function(){
                var result = 0;
                if(this.product.price){
                    result = (Math.round(this.product.price * this.product.margin_gain_u / 100)).toFixed(2);
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
        selectProduct(data){
            this.product = data;
            this.wholesale_quantity = this.product.wholesale_quantity;

            //se consulta el producto exitente en la lista
            this.$parent.findProduct(this.product.id);
            this.isLoading = true;
            this.isPrice(this.product.price);
            this.quantity = 1;
            setTimeout(() => {
                if(this.item == false && this.product.stock > 0){
                    this.$emit('selectProduct', this.product);
                    this.$emit('saleWhole', this.wholesale_quantity);
                    this.$emit('salePrice', this.price);
                    this.$emit('addQuantity', this.quantity);
                    toastr.success("El producto fue agregado.");
                    this.closeModal();
                }else{
                    if(this.product.stock == 0){
                        toastr["error"]("No hay en Invetario. Producto agotado.!")
                    }else{
                        toastr.error("El producto ya se encuentra en la lista.");
                    }
                }
                this.isLoading = false;
            },500)        
        },
        closeModal(){
            $('#modal-list-prod').modal('hide');
        },
        isPrice(price){
            var priceSale = 0.0;
            this.price_sale = price;
            console.log(this.price_sale)
            priceSale =  (parseFloat(this.price_sale) + parseFloat(this.price_gain_u));
            console.log(priceSale)
            this.price = parseFloat(priceSale).toFixed(2);
        },

    },

}
</script>