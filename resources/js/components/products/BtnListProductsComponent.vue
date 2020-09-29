<template>
    <div>
        <a href="#"
            title="seleccionar"
            type="button"
            @click="click(data, 'select')"
            class="btn btn-link btn-sm">
            <i class="far fa-check-circle text-success" aria-hidden="true"></i>
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
        // item:false
    }  
}
</script>