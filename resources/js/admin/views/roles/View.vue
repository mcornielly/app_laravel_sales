<template>
    <div class="customer-info" v-if="rol">
        <div class="user-img">
            <img src="" alt="">
        </div>
        <div class="user-info">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ rol.id }}</td>
                </tr>
                <tr>
                    <th>Nick</th>
                    <td>{{ rol.name }}</td>
                </tr>
                <tr>
                    <th>Nombre Rol</th>
                    <td>{{ rol.display_name }}</td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ rol.created_at }}</td>
                </tr>
            </table>
            <router-link to="/roles">Volver</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'role-view-app',
        created() {
            this.showRol();
        },
        data() {
            return {
                url:'api/auth/roles',
                rol: null
            }
        },
        computed: {
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            showRol(){
                let url = `api/auth/roles/${this.$route.params.role}`
                console.log(url)
                axios.get(url,{
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}` 
                    } 
                }).then((response) => {
                    console.log(response)
                    this.rol = response.data.role;
                }) 
            }
        }
    }
</script>