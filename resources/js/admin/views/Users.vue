<template>
    <section>
        <!-- Content Header (Page header) -->
        <bread-crumbs :titlePage="titlePage" :routePage="routePage"></bread-crumbs>
        <!-- /.content-header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Lista Usuarios</h3>
                    <a href="#" @click="createDivisa()" data-toggle="modal" data-target="#modal-divisas" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Precio</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <template>
                            <data-table
                                :data="data"
                                :theme="theme"
                                :columns="columns"
                                :translate="translate"
                                @onTablePropsChanged="reloadTable">
                            </data-table>
                        </template>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    
        <!-- Modal-Divisa -->
        <div class="modal fade" id="modal-divisas" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content  bg-secondary">
                    <div class="modal-header">
                    <h4 class="modal-title" v-text="title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form role="form" method="POST" @submit.prevent="actionDivisa()">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Precio Divisa</label>
                                <div class="col-md-9">
                                <input id="name-price" type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese Cotización" v-model="price" autofocus>
                                <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.price[0]"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                            <button v-if="create" type="submit" class="btn btn-primary" @click.prevent="actionDivisa('store')" data-dismiss="modal" data-backdrop="false">Agregar</button>
                            <button v-else type="submit" class="btn btn-primary" @click.prevent="actionDivisa('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');
import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);

export default {
    data() {
        return {
            url:"api/usuarios",
            titlePage:'Divisa',
            routePage:'Divisa',
            create:false,
            title: '',
            price:'',
            errors: '',
            data: {},
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'desc',
                placeholderSearch: 'Buscar'
            },
            translate:{
                nextButton: 'Siguiente', previousButton: 'Anterior', placeholderSearch: 'Buscar..'
            },
            theme: "light",
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Name',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Email',
                    name: 'email',
                    orderable: true,
                },
            ]

        }
    },
    created(){
        this.getData(this.url);
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        }
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
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
            })
        },
        reloadTable(tableProps){
            this.getData(this.url, tableProps);
        },
        createDivisa(){
            this.title = 'Nuevo Precio de la Divisa'
            this.price = '';
            this.create = true
        },
        actionDivisa(action){
            if(action == "store"){
                this.storeDivisa();
            }else{
                this.updateDivisa();
            }
        },
        storeDivisa(){
            var url = "/api/divisas";
            axios.post(url,{
                'price': this.price, 
                'user_id': this.user.id 
            }).then(response => {
                console.log(response.data)
                this.getData();
                toastr.success('El Precio de la Divisa fue registrado.');
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
                $('#modal-divisas').modal('show');
            });
        },
        updateDivisa(){
            var url = `/api/divisa/${this.id}`;
            axios.put(url,{
                'id': this.id,
                'price':this.price,
                'user_id': this.user_id,
            }).then(response => {
                this.getDivisas();
                this.closeModal();
                toastr.info('El Precio de la Divisa fue actualizado.');
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
                $('#modal-divisas').modal('show');
            });
        }
    }
}
</script>