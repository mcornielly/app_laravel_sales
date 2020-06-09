<template>
    <div>
        <a href="#"
            title="editar"
            type="button"
            data-toggle="modal"
            data-target="#modal-customer"
            @click="click(data, 'edit')"
            class="btn btn-link" 
            style="font-size: 125%">
            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
        </a>

        <a href="#"
            title="ver"
            data-toggle="modal"
            data-target="#modal-customer"
            @click="click(data,'show')"
            class="btn btn-link" 
            style="font-size: 125%">
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
        classes: {},
    }  
}
</script>