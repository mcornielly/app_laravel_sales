<template>
    <div class="text-right">
        <span>{{ wholesale_price | currency }}</span>    
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
        price_gain_w: function(){
            var result = 0.0;
            if(this.data.price > 0){
                result = Math.round(this.cost_pack * this.data.margin_gain_w / 100).toFixed(2);
            }
            return result;
        },
        wholesale_price: function(){
            var result = 0;
            if(this.data.wholesale_quantity > 0){
                result = parseFloat(this.price_gain_w) + parseFloat(this.cost_pack);
            }
            return result;
        },
        cost_pack: function(){
            var result = 0.0;
            if(this.data.price){
                result = this.data.price*this.data.wholesale_quantity;
            }
            return result;
        }
    }

}
</script>