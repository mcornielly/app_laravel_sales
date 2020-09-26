import Dashboard from "./admin/views/Dashboard";
import Login from "./auth/Login";

export const routes = [
    {
        path: "/",
        name: "dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
        // beforeEnter: () => {
        //     window.location.href = window.location.origin +'/'
        // }
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            title: 'Login',
            requiresAuth: false
        }
    },
    {
        path: "/divisas",
        name: "divisas",
        component: require("./admin/views/Divisas").default
    }
    // {
    //     path: '/categorias',
    //     name: 'categories',
    //     component: require('./admin/views/Categories').default
    // },
    // {
    //     path: '/productos',
    //     name: 'products',
    //     component: require('./admin/views/Products').default,
    // },
    // {
    //     path: '/precios_lista',
    //     name: 'prices',
    //     component: require('./admin/views/PricesList').default,
    // },
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
    // {
    //     path: '*',
    //     component: require('./admin/views/404').default
    // }
];
