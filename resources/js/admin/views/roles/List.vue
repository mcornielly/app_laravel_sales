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
            title:'Lista de Roles',
            data: {},
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'asc',
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
                    handler: this.selectAction,
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
            // this.isLoading = true;
            this.$Progress.start()
            setTimeout(() => {
                axios.get(url, {
                    params: options
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
        selectAction(data, action){
            switch(action){
                case 'delete':
                {
                    this.deleteRole(data);
                    break; 
                }

            }
        },
        deleteRole(data){
            this.id = data.id;
            console.log(this.id)
            var url = `${this.url}/${this.id}`;
            axios.delete(url).then(response => {
                this.reloadTable();
                this.destroy = false;
                toastr.error('El Rol fue eliminado.');
                // toastr["error"]("I do not think that means what you think it means.", "Eliminar");
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },

    }
}
</script>