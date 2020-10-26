<template>
    <div>
        <router-link 
            title="ver"
            :to="{name: 'role-show', params: {role:data.id}}"
            class="btn btn-link btn-sm"
        >
            <i class="fas fa-eye text-success" aria-hidden="true"></i>
        </router-link>

        <router-link 
            title="editar"
            :to="{name: 'role-edit', params: {role:data.id}}"
            class="btn btn-link btn-sm"
        >
            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
        </router-link>

                <router-link 
            title="permisos"
            :to="{name: 'role-permissions', params: {role:data.id}}"
            class="btn btn-link btn-sm"
        >
            <i class="fas fa-th-large text-warning" aria-hidden="true"></i>
        </router-link>
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
