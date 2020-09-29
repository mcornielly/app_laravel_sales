<template>
    <div>
        <a href="#"
            title="detalle"
            type="button"
            data-toggle="modal"
            data-target="#modal-prices"
            @click="click(data)"
            class="btn btn-link btn-sm">
            <i class="fas fa-eye text-success" aria-hidden="true"></i>
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
        classes: {}
    }  
}
</script>