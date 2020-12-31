<template>
    <div class="alert alert-danger alert-dismissible shadow">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        <ul>
            <li>{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['error'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
