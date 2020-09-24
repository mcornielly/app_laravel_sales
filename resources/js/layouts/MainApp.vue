<template>
    <div v-if="currentUser" class="content">
        <div class="wrapper">
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
                    </div>
                </section>
            </div>
            <footer-app></footer-app>
        </div>
        <!-- ./wrapper -->
    </div>
    <div v-else class="content">
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
    // computed: {
    //     currentUser(){
    //         return
    //     }
    // },
    mounted() {
        // location.reload();
        this.currentUser = this.$store.getters.currentUser;
        // this.userLogin();
        // this.meta = this.$route.meta;
        // if (this.meta.auth) {
        //    $('body').removeClass('gray-bg');
        // } else {
        //     $('body').addClass('gray-bg');

        // }
    },
    methods: {
        userLogin() {
            this.currentUser = this.$store.getters.currentUser;
        }
    }
};
</script>
