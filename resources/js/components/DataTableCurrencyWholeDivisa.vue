<template>
    <div class="text-right">
        <span>{{ data.wholesale_divisa | currency }}</span>    
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