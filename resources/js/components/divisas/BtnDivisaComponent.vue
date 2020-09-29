<template>
    <div>
        <a href="#"
            title="editar"
            type="button"
            data-toggle="modal"
            data-target="#modal-divisas"
            @click="click(data)"
            class="btn btn-link btn-sm">
            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
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