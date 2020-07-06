import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: require('./admin/views/Dashboard').default
        },
        {
            path: '/divisas',
            name: 'divisas',
            component: require('./admin/views/Divisas').default
        },
        {
            path: '/categorias',
            name: 'categories',
            component: require('./admin/views/Categories').default
        },
        {
            path: '/productos',
            name: 'products',
            component: require('./admin/views/Products').default,
        },
        {
            path: '/precios_lista',
            name: 'prices',
            component: require('./admin/views/PricesList').default,
        },
        {
            path: '/usuarios',
            name: 'users',
            component: require('./admin/views/Users').default,
        },
        {
            path: '/proveedores',
            name: 'providers',
            component: require('./admin/views/Providers').default,
        },
        {
            path: '/clientes',
            name: 'clients',
            component: require('./admin/views/Customers').default,
        },
        {
            path: '*',
            component: require('./admin/views/404').default
        }
    ],
    linkExactActiveClass: 'active',
    // mode: 'history'
});
