<template>
    <div>
        <a href="#"
            title="ver"
            @click="click(data,'show')"
            class="btn btn-link btn-sm">
            <i class="fas fa-eye text-success" aria-hidden="true"></i>
        </a>

        <a href="#"
            title="anular"
            @click="click(data,'delete')"
            class="btn btn-link btn-sm">
            <i class="fas fa-trash text-danger" aria-hidden="true"></i>
        </a>
        
    </div>
</template>

<script>
export default {
    props: {
        data: {},
        name: {},
        click: {},
        meta: {},
        classes: {},
    }  
}
</script>