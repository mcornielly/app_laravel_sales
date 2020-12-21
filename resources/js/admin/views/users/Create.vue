<template>
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> {{ titleCard }} </h3>
                        <router-link :to="{path: '/usuarios'}" class="btn btn-sm btn-primary float-right"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link>
                    </div>
                    <!-- /.card-header -->
                    <!-- <div class="card-body">
                    </div> -->
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="row">
                    <div class="col-md-12 pt-2">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div> 
                </div>
            </div>
            <!-- /.col -->
        </div>
    </section>
</template>
<script>
export default {
    name: 'user-create-app',
    data(){
        return {
            titlePage:'Usuarios',
            routePage:'Usuarios',
            titleCard:'Nuevo Usuario',
        }
    }
}
</script>