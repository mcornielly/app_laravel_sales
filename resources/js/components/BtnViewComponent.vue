<template>
    <button
        type="button"
        data-toggle="modal"
        @click="click(data)"
        class="btn btn-success btn-sm"
        data-target="#">
        <i class="fas fa-eye" aria-hidden="true"></i>
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