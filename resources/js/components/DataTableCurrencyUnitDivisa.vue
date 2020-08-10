<template>
    <div class="text-right">
        <span>{{ data.divisa_unit | currency }}</span>    
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