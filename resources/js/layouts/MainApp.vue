<template>
    <div v-if="currentUser" class="content">
        <div class="wrapper">
            <!-- set progressbar -->
            <vue-progress-bar></vue-progress-bar>
            <!-- Navbar -->
            <header-app></header-app>
            <!-- /.navbar -->
            <!-- Main Sidebar Container  -->
            <sidebar-app></sidebar-app>
            <!-- /.sidebar -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content">
                    <div class="content-fluid">
                        <router-view></router-view>
                        <!-- set progressbar -->
                        <vue-progress-bar></vue-progress-bar>
                    </div>
                </section>
            </div>
            <footer-app></footer-app>
        </div>
        <!-- ./wrapper -->
    </div>
    <div v-else class="content">
        <h3>Aqui</h3>  
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "main-app",
    data() {
        return {
            meta: {},
            currentUser: {}
        };
    },
    created() {
        this.userLogin();

        if (this.$route.path == "/login") {
            alert(1)
            $("body").removeClass("sidebar-mini");
            $("body").addClass("login-page");
        } else {
            alert(2)
            $("body").removeClass("login-page");
            $("body").addClass("sidebar-mini");
        }
    },
    methods: {
        userLogin() {
            this.currentUser = this.$store.getters.currentUser;
        }
    }
};
</script>
