<template>
    <div>
        <div v-if="meta.requiresAuth" class="content">
            <div class="wrapper">
                <!-- Navbar -->
                <header-app></header-app>
                <!-- /.navbar -->
                <!-- Main Sidebar Container -->
                <aside class="main-sidebar sidebar-dark-primary elevation-4">
                    <!-- Brand Logo -->
                    <a href="index3.html" class="brand-link">
                        <img
                            src="/adminlte/img/sale_logo.png"
                            alt="AdminLTE Logo"
                            class="brand-image img-circle elevation-3"
                            style="opacity: .8"
                        />
                        <span class="brand-text font-weight-light">{{
                            meta.nameApp
                        }}</span>
                    </a>

                    <!-- Main Sidebar Container  -->
                    <sidebar-app nameApp="nameApp"></sidebar-app>
                    <!-- /.sidebar -->
                </aside>

                <h1>Aqui Dashboard</h1>
                <router-view></router-view>
                <!-- Main Footer -->
                <footer class="main-footer">
                    <!-- To the right -->
                    <div class="float-right d-none d-sm-inline">
                        Anything you want
                    </div>
                    <!-- Default to the left -->
                    <strong
                        >Copyright &copy; 2020 | V-1.0
                        <a href="https://adminlte.io">{{ meta.nameApp }}.io</a
                        >.</strong
                    >
                    All rights reserved.
                </footer>
            </div>
        </div>
        <div v-else>
            <h1>Aqui login</h1>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');
export default {
    name: "main-app",
    data() {
        return {
            meta: {
                requiresAuth: false,
                nameApp: "SalesSystems"
            }
        };
    },
    mounted() {
        this.meta = this.$route.meta;
        console.log(this.meta);
    }
};
</script>
