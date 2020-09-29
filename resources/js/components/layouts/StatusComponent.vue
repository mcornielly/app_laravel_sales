<template>
    <div>
        <div v-if="data.status == 'ACTIVO'">
            <span class="badge badge-success" v-text="data.status" style="width: 100%;">
            </span>
        </div>
        <div v-else-if="data.status == 'PAGADO'">
            <span class="badge badge-success" v-text="data.status" style="width: 100%;"></span>
        </div>
        <div v-else-if="data.status == 'REGISTRADO'">
            <span class="badge badge-success" v-text="data.status" style="width: 100%;"></span>
        </div>
        <div v-else>
            <span  class="badge badge-danger" v-text="data.status" style="width: 100%;"></span>  
        </div>
    </div>
</template>

<script>
export default {
    props:['data']
    // props:{
    //       data: {
    //         type: Object,
    //         default: () => ({}),
    //     },
    // }
}
</script>

