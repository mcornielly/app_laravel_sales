/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import router from './routes';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('modal-divisa', require('./components/ModalDivisaComponent.vue').default);
Vue.component('modal-category', require('./components/ModalCategoryComponent.vue').default);
Vue.component('modal-provider', require('./components/ModalProviderComponent.vue').default);
Vue.component('modal-customer', require('./components/ModalCustomerComponent.vue').default);
Vue.component('modal-product', require('./components/ModalProductComponent.vue').default);
Vue.component('bread-crumbs', require('./components/BreadCrumbs').default);
Vue.component('product-create', require('./components/ProductCreate.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('btn-divisa', require('./components/BtnDivisaComponent.vue').default);
Vue.component('btn-category', require('./components/BtnCategoryComponent.vue').default);
Vue.component('btn-products', require('./components/BtnProductsComponent.vue').default);
Vue.component('btn-providers', require('./components/BtnProvidersComponent.vue').default);
Vue.component('btn-customers', require('./components/BtnCustomersComponent.vue').default);
Vue.component('status-component', require('./components/StatusComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
