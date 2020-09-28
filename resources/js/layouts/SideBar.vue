<template>
    <div>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img
                    src="/adminlte/img/sale_logo.png"
                    alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3"
                    style="opacity: .8"
                />
                <span class="brand-text font-weight-light">SaleSystems</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img
                            src="/adminlte/img/user2-160x160.jpg"
                            class="img-circle elevation-2"
                            alt="User Image"
                        />
                    </div>
                    <template v-if="currentUser">
                        <div class="info">
                            <a href="#" class="d-block">{{
                                currentUser.name
                            }}</a>
                        </div>
                    </template>
                </div>

                <!-- Main Sidebar Container  -->
                <nav class="mt-2">
                    <ul
                        class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false"
                    >
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>
                        <!-- Divisa -->
                        <li class="nav-item">
                            <router-link to="/divisas" class="nav-link">
                                <i class="nav-icon fas fa-money-bill-alt"></i>
                                <p>
                                    Divisa
                                </p>
                            </router-link>
                        </li>
                        <!-- Almacén -->
                        <li class="nav-item has-treeview">
                            <router-link to="#" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Almacén
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </router-link>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link
                                        to="/categorias"
                                        class="nav-link"
                                    >
                                        <i class="nav-icon fas fa-tags"></i>
                                        <p>Categorias</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/productos"
                                        class="nav-link"
                                    >
                                        <i class="nav-icon fas fa-box"></i>
                                        <p>Productos</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/precios_lista"
                                        class="nav-link"
                                    >
                                        <i class="nav-icon far fa-list-alt"></i>
                                        <p>Lista de Precios</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <!-- Compras -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Compras
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link
                                        to="/ingresos"
                                        class="nav-link"
                                    >
                                        <i
                                            class="nav-icon fas fa-piggy-bank"
                                        ></i>
                                        <p>Ingresos</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/proveedores"
                                        class="nav-link"
                                    >
                                        <i class="nav-icon fas fa-industry"></i>
                                        <p>Proveedores</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <!-- Ventas -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-handshake"></i>
                                <p>
                                    Ventas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/ventas" class="nav-link">
                                        <i
                                            class="nav-icon fas fa-cash-register"
                                        ></i>
                                        <p>Ventas</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/clientes"
                                        class="nav-link"
                                    >
                                        <i class="nav-icon fas fa-user-tie"></i>
                                        <p>Clientes</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <!-- Reportes -->
                        <li class="nav-item has-treeview">
                            <router-link to="#" class="nav-link">
                                <i class="nav-icon fas fa-clipboard"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </router-link>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link
                                        to="/usuarios"
                                        class="nav-link"
                                    >
                                        <i
                                            class="nav-icon fas fa-file-invoice"
                                        ></i>
                                        <p>Reportes Ingreso</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/usuarios"
                                        class="nav-link"
                                    >
                                        <i
                                            class="nav-icon fas fa-file-invoice-dollar"
                                        ></i>
                                        <p>Reportes Ventas</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                                                <template v-if="currentUser.roles[0].name=='Administrador'">
                            <!-- Usiuarios Roles  Permisos -->
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-door-open"></i>
                                    <p>
                                        Accesos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <router-link
                                            to="/usuarios"
                                            class="nav-link"
                                        >
                                            <i class="nav-icon fas fa-users"></i>
                                            <p>Usurios</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link
                                            to="/usuarios"
                                            class="nav-link"
                                        >
                                            <i
                                                class="nav-icon fas fa-users-cog"
                                            ></i>
                                            <p>Roles</p>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                        </template>
                        <!-- Logout -->
                        <li class="nav-item">
                            <a
                                id="logout"
                                href="#/"
                                class="nav-link"
                                @click.prevent="logout"
                            >
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Salir</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar -->
            </div>
        </aside>
    </div>
</template>

<script>
export default {
    name: "sidebar-app",
    methods: {
        logout() {
            this.$store.commit("logout");
            
            setTimeout(() => {
                // $("body").removeClass("sidebar-mini");
                // $("body").addClass("login-page");
                this.$router.push("/login");
            }, 1000);
        }
    },
    computed: {
        currentUser() {
            console.log(this.$store.getters.currentUser)
            return this.$store.getters.currentUser;
        }
    }
};
</script>
