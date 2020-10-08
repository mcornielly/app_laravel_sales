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
                    <div class="modal-body">
                            <data-table ref="tb"
                                :data="data"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                @onTablePropsChanged="reloadTable"
                                @loading="isLoading = true"
                                @finishedLoading="isLoading = false">
                        </data-table>
                    </div>
                <form role="form" method="POST">
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
import BtnListProductsComponentVue from '../products/BtnListProductsComponent';
import StatusComponentVue from '../../components/layouts/StatusComponent';
import DataTableCurrencyCell from '../../components/datatable/DataTableCurrencyCell';


Vue.use(DataTable);

export default {
    props:['item','priceCost'],
    components:{
        BtnListProductsComponentVue,
        StatusComponentVue,
        DataTableCurrencyCell,
    },
    data(){
        return {
            data:{},
            url:'api/productos',
            title: 'Lista de Productos',
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'desc',
            },
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
                    component: DataTableCurrencyCell
                },
                {
                    label: 'Stock',
                    name: 'stock',
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
            wholesale_quantity: 0,
            price: 0,
            isLoading: false
        }
    },
    computed:{
        // user(){
        //     let user = document.head.querySelector('meta[name="user"]');
        //     return JSON.parse(user.content);
        // },
        currentUser() {
            console.log(this.$store.getters.currentUser)
            return this.$store.getters.currentUser;
        },
    },
    methods:{
        getData(url = this.url, options = this.tableProps) {
            // this.isLoading = true;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url, {
                    params: options,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }
                })
                .then(response => {
                    this.data = response.data;
                    console.log(this.data)
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                    this.$Progress.fail()
                })
                // this.isLoading = false;
                this.$Progress.finish()
            },1000)
        },
        selectProduct(data){
            this.product = data;
            this.wholesale_quantity = this.product.wholesale_quantity;
            this.price = this.product.price;
            console.log(this.product.id)
            //se consulta el producto exitente en la lista
            this.$parent.findProduct(this.product.id);
            // this.isLoading = true;
            setTimeout(() => {
                if(this.item == false){
                    this.$emit('selectProduct', this.product);
                    this.$emit('saleWhole', this.wholesale_quantity);
                    this.$emit('salePrice', this.price);
                    toastr.success("El producto fue agregado.");
                    this.closeModal();
                }else{
                    toastr.error("El producto ya se encuentra en la lista.");
                }
                // this.isLoading = false;
            },500)        
        },
        closeModal(){
            $('#modal-list-prod').modal('hide');
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
    },
    mounted(){
        this.getData(this.url);
    }

}
</script>