<template>
    <div class="text-right">
        <span v-if="data.price">{{ data.price | currency }}</span>    
        <span v-else>{{ data.total | currency }}</span>    
    </div>
</template>
<script>
import Vue from 'vue';
 
export default {
    props: {
        data: {
            type: Object,
            default: () => ({})
        }
    }

}
</script>