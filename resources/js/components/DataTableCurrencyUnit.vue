<template>
    <div class="text-right">
        <span>{{ unit_price | currency }}</span>    
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
    },
    computed:{
        price_gain_u: function(){
            var result = (this.data.price * this.data.margin_gain_u / 100).toFixed(2);
            this.p_gain_u = result;
            return result;
        },
        unit_price: function(){
            var result = 0;
            if(this.data.wholesale_quantity > 0 || this.data.price > 0){
                var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.price)) / this.data.wholesale_quantity).toFixed(2);
            }
            return result;
        }
    }

}
</script>