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
            return result;
        },
        unit_price: function(){
            var result = 0;
            if(this.data.price > 0){
                var result = parseFloat(this.data.price) + parseFloat(this.price_gain_u);
            }
            return result;
        }
    }

}
</script>