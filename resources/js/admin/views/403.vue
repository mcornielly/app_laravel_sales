<template>
    <section>
        <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> - Error - </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <h1 class="text-capitalize">403 - ACCESO DENEGADO</h1>
                            <div class="text-center">
                                <router-link :to="{name: 'dashboard'}" class="btn btn-default"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i>Regresar al Dashboard</router-link>
                            </div>
                        </template>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <div>
        </div> 
    </section>
</template>
<script>
export default {
    data(){
        return {
            titlePage:'Error',
            routePage:'403',
        }
    }
}
</script>