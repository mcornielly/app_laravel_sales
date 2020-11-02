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
        // meta: {
        //     requiresAuth: true
        // }
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
    {
        path: '/ingresos',
        name: 'incomes',
        component: require('./admin/views/Incomes').default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/proveedores',
        name: 'providers',
        component: require('./admin/views/Providers').default,
    },
    {
        path: '/ventas',
        name: 'sales',
        component: require('./admin/views/Sales').default,
    },
    {
        path: '/clientes',
        name: 'clients',
        component: require('./admin/views/Customers').default,
    },
    // {
    //     path: '/usuarios',
    //     name: 'users',
    //     component: require('./admin/views/Users').default,
    // },
    {
        path: '/usuarios',
        name: 'users',
        component: require('./admin/views/users/Index').default,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: require('./admin/views/users/List').default, 
            },
            {
                path: ':usuario',
                name: 'user-show',
                component: require('./admin/views/users/View').default,
                props: true
            },
            {
                path: ':usuario/editar',
                name: 'user-edit',
                component:require('./admin/views/users/Edit').default,
                props: true
            },
            {
                path: ':usuario',
                name: 'user-crear',
                component:require('./admin/views/users/Create').default,
                props: true
            }
        ]
    },
    // {
    //     path: '/roles',
    //     name: 'roles',
    //     component: require('./admin/views/Roles').default,
    // },
    {
        path: '/roles',
        name: 'roles',
        component: require('./admin/views/roles/Index').default,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: require('./admin/views/roles/List').default,
            },
            {
                path: ':role',
                name: 'role-show',
                component: require('./admin/views/roles/View').default,
                props: true
            },
            {
                path: ':role/editar',
                name: 'role-edit',
                component:require('./admin/views/roles/Edit').default,
                props: true
            },
            {
                path: ':role/permisos',
                name: 'role-permissions',
                component:require('./admin/views/roles/Permissions').default,
                props: true
            }     
        ]
    },
    {
        path: '/403',
        component: require('./admin/views/403').default
    },
    {
        path: '/404',
        component: require('./admin/views/404').default
    }
];
