<template>
    <section>
        <!-- Content Header (Page header) -->
        <bread-crumbs
            :titlePage="titlePage"
            :routePage="routePage"
        ></bread-crumbs>
        <!-- /.content-header -->
        <template>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bars">&nbsp;</i> Lista de
                                Precios
                            </h3>
                            <a
                                href="#"
                                @click="searchProduct()"
                                data-toggle="modal"
                                data-target="#modal-search"
                                class="btn btn-sm btn-primary float-right"
                                ><i class="fa fa-plus" aria-hidden="true"
                                    >&nbsp;</i
                                >
                                Consultar Producto</a
                            >
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <data-table
                                ref="tb"
                                :data="data"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                @onTablePropsChanged="reloadTable"
                                @loading="isLoading = true"
                                @finishedLoading="isLoading = false"
                            >
                            </data-table>
                            <!-- Animation -->
                            <loading
                                :is-full-page="true"
                                :active.sync="isLoading"
                            >
                            </loading>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </template>

        <!-- Modal-Searh-Product -->
        <modal-searh-product :title="title"></modal-searh-product>
        <!-- /.modal -->

        <!-- Modal-Show PricesList -->
        <modal-show-priceslist
            :data="selectedRow"
            :title="title"
            :images="images"
            :imgshow="imgshow"
        ></modal-show-priceslist>
        <!-- /.modal -->
    </section>
</template>

<script>
import Vue from "vue";
import DataTable from "laravel-vue-datatable";
import BtnProductsComponentVue from "../../components/BtnProductsComponent.vue";
import StatusComponentVue from "../../components/StatusComponent.vue";
import DataTableCurrencyUnitDivisa from "../../components/DataTableCurrencyUnitDivisa.vue";
import DataTableCurrencyWholeDivisa from "../../components/DataTableCurrencyWholeDivisa.vue";
import DataTableCurrencyWholesale from "../../components/DataTableCurrencyWholesale.vue";
import DataTableCurrencyUnit from "../../components/DataTableCurrencyUnit.vue";
import BtnPricesListComponent from "../../components/BtnPricesListComponent.vue";

Vue.use(DataTable);

// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

// Registra una directiva personalizada global llamada `v-focus`
// Vue.directive('focus', { inserted: function (el) { el.focus() } })

export default {
    components: {
        BtnProductsComponentVue,
        StatusComponentVue,
        DataTableCurrencyUnitDivisa,
        DataTableCurrencyWholeDivisa,
        DataTableCurrencyWholesale,
        DataTableCurrencyUnit,
        BtnPricesListComponent,
        Loading
    },
    data() {
        return {
            data: {},
            divisa: 0,
            code: "",
            titlePage: "Lista de Precios",
            routePage: "Lista de Precios",
            url: "api/productos/lista_precios",
            title: "",
            tableProps: {
                search: "",
                length: 10,
                column: "id",
                dir: "desc"
            },
            translate: {
                nextButton: "Siguiente",
                previousButton: "Anterior",
                placeholderSearch: "Buscar.."
            },
            theme: "dark",
            columns: [
                {
                    label: "ID",
                    name: "id",
                    orderable: true
                },
                {
                    label: "Código",
                    name: "code",
                    orderable: false
                },
                {
                    label: "Nombre",
                    name: "name",
                    orderable: true
                },
                {
                    label: "Cant",
                    name: "stock",
                    orderable: true
                },
                {
                    label: "P.U Bs.",
                    name: "price",
                    orderable: true,
                    component: DataTableCurrencyUnit
                },
                {
                    label: "P.U.$",
                    name: "divisa_unit",
                    orderable: true,
                    component: DataTableCurrencyUnitDivisa
                },
                {
                    label: "P.M Bs.",
                    name: "price_wholesale",
                    orderable: true,
                    component: DataTableCurrencyWholesale
                },
                {
                    label: "P.M.$",
                    name: "wholesale_divisa",
                    orderable: true,
                    component: DataTableCurrencyWholeDivisa
                },
                {
                    label: "Estatus",
                    component: StatusComponentVue,
                    orderable: true
                },
                {
                    label: "",
                    name: "",
                    orderable: false,
                    component: BtnPricesListComponent,
                    event: "click",
                    handler: this.modalProduct
                }
            ],
            selectedRow: {},
            product_id: 0,
            images: [],
            imgshow: false,
            isLoading: false
        };
    },
    created() {
        this.getData(this.url);
        this.getDivisa();
        this.getCategories();
    },
    computed: {
        user() {
            let user = document.head.querySelector('meta[name="user"]');
            return JSON.parse(user.content);
        }
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
            this.isLoading = true;
            setTimeout(() => {
                axios
                    .get(url, {
                        params: options
                    })
                    .then(response => {
                        this.data = response.data;
                        console.log(this.data);
                    })
                    // eslint-disable-next-line
                    .catch(errors => {
                        //Handle Errors
                    });
                this.isLoading = false;
            }, 1000);
        },
        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },
        getDivisa() {
            var url = "api/divisa/precio";
            axios
                .get(url)
                .then(response => {
                    this.divisa = response.data;
                    console.log(this.divisa);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
        getCategories() {
            var url = "api/categorias/lista";
            axios
                .get(url)
                .then(response => {
                    this.categories = response.data;
                    console.log(this.categories);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
        searchProduct() {
            this.title = "Consulta de Precio del Producto";
            $("#modal-search").on("shown.bs.modal", function() {
                $("#input_focus").focus();
            });
        },
        modalProduct(data) {
            this.title = "Consulta del Producto";
            this.selectedRow = data;
            this.product_id = data.id;
            this.getImages(this.product_id);
        },
        deleteProduct(data) {
            this.id = data.id;
            console.log(this.id);
            var url = `/api/producto/eliminar/${this.id}`;
            axios
                .delete(url)
                .then(response => {
                    this.reloadTable();
                    this.destroy = false;
                    toastr.error("El producto fue eliminada.");
                    // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
                })
                .catch(error => {
                    console.log(error);
                    var errors = error.response.data.errors;
                    this.errors = errors;
                });
        },
        restoreProduct(data) {
            this.id = data.id;
            var url = `/api/producto/restore/${this.id}`;
            axios
                .get(url)
                .then(response => {
                    this.reloadTable();
                    toastr.success("El producto fue restaurada.");
                    // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
                })
                .catch(error => {
                    console.log(error);
                    var errors = error.response.data.errors;
                    this.errors = errors;
                });
        },
        back_pag() {
            this.vproducts = false;
        },
        getImages(product_id) {
            var id = product_id;
            var url = `/api/producto/imagenes/${id}`;
            axios
                .get(url)
                .then(response => {
                    this.images = response.data;
                    console.log(this.images);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }
    }
};
</script>
