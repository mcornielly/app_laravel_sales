<template>
    <section>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark" v-text="titlePage"></h1>
                </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
                            </li>
                            <li v-show="nameModule" class="breadcrumb-item">
                                <router-link :to="{name: nameModule}" v-text="nameSubModule"></router-link>
                            </li>     
                            <li class="breadcrumb-item active" v-text="routePage"></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>  
    </section>
</template> 

<script>
export default {
    props:['titlePage','routePage','nameModule','nameSubModule']
}
</script> 