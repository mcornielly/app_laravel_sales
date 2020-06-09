<template>
    <button
        type="button"
        data-toggle="modal"
        @click="click(data)"
        class="btn btn-primary btn-sm"
        data-target="#modal-divisas">
        <i class="fas fa-edit" aria-hidden="true"></i>
    </button>
    
</template>
<script>
export default {
    props: {
        data: {},
        name: {},
        click: {},
        meta: {},
        classes: {},
    },
}
</script>