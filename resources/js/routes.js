import Dashboard from "./admin/views/Dashboard";
import Login from "./auth/Login";

export const routes = [
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: "/",
        name: "dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/divisas",
        name: "divisas",
        component: require("./admin/views/Divisas").default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/categorias',
        name: 'categories',
        component: require('./admin/views/Categories').default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/productos',
        name: 'products',
        component: require('./admin/views/Products').default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/precios_lista',
        name: 'prices',
        component: require('./admin/views/PricesList').default,
        meta: {
            requiresAuth: true
        }
    },

    // {
    //     path: '/usuarios',
    //     name: 'users',
    //     component: require('./admin/views/Users').default,
    // },
    // {
    //     path: '/proveedores',
    //     name: 'providers',
    //     component: require('./admin/views/Providers').default,
    // },
    // {
    //     path: '/ingresos',
    //     name: 'incomes',
    //     component: require('./admin/views/Incomes').default,
    // },
    // {
    //     path: '/clientes',
    //     name: 'clients',
    //     component: require('./admin/views/Customers').default,
    // },
    // {
    //     path: '/ventas',
    //     name: 'sales',
    //     component: require('./admin/views/Sales').default,
    // },
    {
        path: '*',
        component: require('./admin/views/404').default
    }
];
