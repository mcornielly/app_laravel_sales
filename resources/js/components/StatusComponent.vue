<template>
    <div>
        <span v-if="data.status == 'ACTIVO'" class="badge badge-success" v-text="data.status">
        </span>
        <span v-if="data.status == 'PAGADO'" class="badge badge-success" v-text="data.status">
        </span>   
        <span v-else class="badge badge-danger" v-text="data.status">
        </span>  
    </div>
</template>

<script>
export default {
    props:{
          data: {
            type: Object,
            default: () => ({}),
        },
    }
}
</script>

