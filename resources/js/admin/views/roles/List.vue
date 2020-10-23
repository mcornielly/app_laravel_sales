<template>
    <div>
        <data-table
            :data="data"
            :theme="theme"
            :columns="columns"
            :translate="translate"
            @onTablePropsChanged="reloadTable"
            @loading="isLoading = true"
            @finishedLoading="isLoading = false">
        </data-table>
    </div>
</template>
<script>
import Vue from 'vue';
import BtnRolComponentVue from '../../../components/roles/BtnRolComponent';
import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);

export default {
    name: 'role-list-app',
    component:{
        BtnRolComponentVue
    },
    data(){
        return {
            url:"api/auth/roles",
            data: {},
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
                    label: 'Rol',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Nombre',
                    name: 'display_name',
                    orderable: true,
                },
                {
                    label: 'Fecha',
                    name: 'created_at',
                    orderable: true,
                },
                {
                    label: 'Acciones',
                    name: '',
                    orderable: false,
                    event: "click",
                    component: BtnRolComponentVue,     
                    handler: this.action,
                },
            ],
            selectedRow: {},
        }
    },
    created(){
        this.getData(this.url);
    },
    computed:{
        currentUser(){
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
            // this.isLoading = true;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url, {
                    params: options,
                    headers: {
                        "Authorization": `Bearer ${this.currentUser.token}`
                    }
                })
                .then(response => {
                    this.data = response.data;
                    console.log(this.data)
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                    this.$Progress.fail()
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