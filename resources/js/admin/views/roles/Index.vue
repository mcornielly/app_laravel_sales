<template>
    <section>
        <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ titleCard }} </h3>   
                <router-link v-if="path == '/roles'" :to="{name: 'role-crear'}" class="btn btn-sm btn-success float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Rol</router-link>
                <router-link v-else to="/roles" @click="titleIndex" class="btn btn-sm btn-secondary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link>
            </div>
            <!-- /.card-header -->
        </div>
        <!-- Message Error Flash -->
        <template v-if="error_flash">
            <error-flash :error="error_flash"></error-flash>
        </template>
        <!-- /.card -->
        <div class="row">
            <div class="col-12" style="min-height: 100vh">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ title }} </h3>                   <!-- <a href="#" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template> 
                            <transition name="fade" mode="out-in">
                                <router-view 
                                    @title="title = $event" 
                                    @path="path = $event" 
                                    @errorFlash="error_flash = $event">
                                </router-view>
                            </transition>
                        </template>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </section>
</template>
<script>
export default {
    name: 'role-index-app',
    data(){
        return {
            titlePage:'Roles',
            routePage:'Roles',
            titleCard:'Roles',
            error_flash:'',
            title:'',
            path: ''
        }
    },
    created(){
        this.titleIndex;    
        this.currentPage;
    },
    methods:{
        currentPage(){
            this.path = this.$route.path;
        },
        titleIndex(){
            this.title = 'Lista de Roles';
        }

    }

}
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0
}
</style>