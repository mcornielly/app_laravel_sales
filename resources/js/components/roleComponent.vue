<template>
    <div>
        <span>
            {{ role.display_name }}
        </span>
    </div>
</template>
<script>
export default {
    props:{
        data:{}
    },
    data(){
        return{
            roles:[]
        }
    },
    computed:{
        role(){
            return this.roles = this.data.roles[0];
        }
    }
}
</script>