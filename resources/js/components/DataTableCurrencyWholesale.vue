<template>
    <div>
        <span class="text-right">{{ wholesale_price | numeralFormat('0.00[,]00') }}</span>    
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
    },
    computed:{
        price_gain_w: function(){
            var result = (this.data.price * this.data.margin_gain_w / 100).toFixed(2);
            return result;
        },
        wholesale_price: function(){
            var result = 0;
            if(this.data.wholesale_quantity > 0 || this.data.price > 0){
                result = (parseFloat(this.price_gain_w) + parseFloat(this.data.price)).toFixed(2);
            }
            return result;
        }
    }

}
</script>