<template>
    <div>
        <a href="#"
            title="editar"
            type="button"
            data-toggle="modal"
            data-target="#modal-category"
            @click="click(data, 'edit')"
            class="btn btn-link btn-sm">
            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
        </a>

        <a href="#"
            title="ver"
            data-toggle="modal"
            data-target="#modal-category"
            @click="click(data,'show')"
            class="btn btn-link btn-sm">
            <i class="fas fa-eye text-success" aria-hidden="true"></i>
        </a>

        <a v-if="data.status == 'ACTIVO'" href="#"
            title="eliminar"
            @click="click(data,'delete')"
            class="btn btn-link btn-sm">
            <i class="fas fa-trash text-danger" aria-hidden="true"></i>
        </a>
        
        <a v-else href="#"
            title="restore"
            @click="click(data,'restore')"
            class="btn btn-link btn-sm">
            <i class="fas fa-trash-restore text-warning" aria-hidden="true"></i>
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