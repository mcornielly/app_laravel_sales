<template>
    <data-table
        :data="data"
        :theme="theme"
        :columns="columns"
        :translate="translate"
        @onTablePropsChanged="reloadTable"
        @loading="isLoading = true"
        @finishedLoading="isLoading = false">
    </data-table>
</template>
<script>
import Vue from 'vue';
import roleComponent from '../../../components/roleComponent';
import BtnUserComponentVue from '../../../components/users/BtnUserComponent';
import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);

export default {
    name: 'user-list-app',
    component:{
        roleComponent,
        BtnUserComponentVue
    },
    data(){
        return {
            url:"api/auth/usuarios",
            title: 'Lista de Usuarios',
            data: {},
            roles:{},
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'desc',
            },
            translate:{
                nextButton: 'Siguiente', 
                previousButton: 'Anterior', 
                placeholderSearch: 'Buscar..'
            },
            theme: "dark",
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Nombre',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Roles',
                    name: 'rol',
                    orderable: true,
                    component: roleComponent,
                },
                {
                    label: 'Email',
                    name: 'email',
                    orderable: true,
                },
                {
                    label: 'Acciones',
                    name: '',
                    orderable: false,
                    event: "click",
                    component: BtnUserComponentVue,     
                    handler: this.action,
                },
            ],
            selectedRow: {},
        }
    },
    created(){
        this.getData(this.url);
        this.$emit('title', this.title);
        this.$emit('path', this.$route.path);
    },
    computed:{
        currentUser(){
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
        let me = this;
            // this.isLoading = true;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url, {
                    params: options,
                })
                .then(response => {
                    me.data = response.data;
                    me.roles=response.data;
                    console.log(me.roles)
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                    me.$Progress.fail()
                })
            // this.isLoading = false;
            this.$Progress.finish()
            }, 1000);
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
    }
}
</script>