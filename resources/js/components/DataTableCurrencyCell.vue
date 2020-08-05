<template>
    <div>
        <span v-if="data.price" class="text-right">{{ data.price | numeralFormat('0.00[,]00') }}</span>    
        <span class="text-right">{{ data.total | numeralFormat('0.00[,]00') }}</span>    
    </div>
</template>
<script>
import Vue from 'vue';
import VueNumerals from 'vue-numerals';
 
Vue.use(VueNumerals); // default locale is 'en'
 
export default {
    props: {
        data: {
            type: Object,
            default: () => ({})
        }
    }

}
</script>