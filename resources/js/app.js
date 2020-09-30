require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";
import { routes } from "./routes";
import VueFormWizard from "vue-form-wizard";
import StoreData from "./store";
import {initialize} from  './helpers/general'
import "vue-form-wizard/dist/vue-form-wizard.min.css";

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 58)',
  failedColor: 'red',
  height: '2px'
})
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// window.Vue = require('vue');


// Dependency
window.jsPDF = require("jspdf");
Vue.use(VueFormWizard);
Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(StoreData);
const router = new VueRouter({
    routes,
    mode: "history",
    linkExactActiveClass: "active"
});

initialize(store, router);
// router.beforeEach((to, from, next) => {
//     const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
//     const currentUser = store.state.currentUser;
//     console.log(currentUser);
//     if (requiresAuth && !currentUser) {
//         next("/login");
//     } else if (to.path == "/login" && currentUser) {
//         next("/");
//     } else {
//         next();
//     }
// });

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("main-app", require("./components/layouts/MainApp.vue").default);
Vue.component("header-app", require("./components/layouts/Header.vue").default);
Vue.component("footer-app", require("./components/layouts/Footer.vue").default);
Vue.component("sidebar-app", require("./components/layouts/SideBar.vue").default);
Vue.component("bread-crumbs", require("./components/layouts/BreadCrumbs").default);
Vue.component('status-component', require('./components/layouts/StatusComponent.vue').default);
Vue.component("login-app", require("./auth/Login.vue").default);
Vue.component("modal-divisa",require("./components/divisas/ModalDivisaComponent.vue").default);
Vue.component('modal-category', require('./components/categories/ModalCategoryComponent.vue').default);
Vue.component('modal-product', require('./components/products/ModalProductComponent.vue').default);
Vue.component('product-create', require('./components/products/ProductCreateComponent.vue').default);
Vue.component('modal-list-prod', require('./components/products/ModalListProductComponent.vue').default);
Vue.component('show-product', require('./components/products/ShowProductComponent.vue').default);
Vue.component('modal-show-priceslist', require('./components/priceslists/ModalPricesListComponent.vue').default);
Vue.component('modal-searh-product', require('./components/priceslists/ModalSearchProductComponent.vue').default);
Vue.component('prices-product', require('./components/priceslists/PricesProductComponent.vue').default);
Vue.component('income-provider', require('./components/incomes/IncomeProviderComponent.vue').default);
Vue.component('income-product', require('./components/incomes/IncomeProductComponent.vue').default);
Vue.component('income-invoice', require('./components/incomes/IncomeInvoiceComponent.vue').default);

// Vue.component('modal-cost', require('./components/ModalCostComponent.vue').default);
// Vue.component('modal-provider', require('./components/ModalProviderComponent.vue').default);
// Vue.component('modal-customer', require('./components/ModalCustomerComponent.vue').default);
// Vue.component('modal-list-prod-sale', require('./components/ModalListProductSaleComponent.vue').default);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('btn-category', require('./components/categories/BtnCategoryComponent.vue').default);
// Vue.component('btn-products', require('./components/products/BtnProductsComponent.vue').default);
// Vue.component('btn-divisa', require('./components/BtnDivisaComponent.vue').default);
// Vue.component('btn-providers', require('./components/BtnProvidersComponent.vue').default);
// Vue.component('btn-customers', require('./components/BtnCustomersComponent.vue').default);
// Vue.component('show-customer', require('./components/ShowCustomerComponent.vue').default);
// Vue.component('sale-customer', require('./components/SaleCustomerComponent.vue').default);
// Vue.component('sale-product', require('./components/SaleProductComponent.vue').default);
// Vue.component('sale-invoice', require('./components/SaleInvoiceComponent.vue').default);
// Vue.component('form-provider', require('./components/FormProviderComponent.vue').default);
// Vue.component('cost-balance', require('./components/CostBalanceComponent.vue').default);
// Vue.component('currency-cell', require('./components/DataTableCurrencyCell.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter("currency", function(value) {
    if (!value) return "";
    // var formatter = new Intl.NumberFormat('es-ES',{
    //     minimumFractionDigits: 2
    // });
    let val = (value / 1).toFixed(2).replace(".", ",");
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    // return formatter.format(value);
});

const app = new Vue({
    el: "#app",
    router,
    store
});
