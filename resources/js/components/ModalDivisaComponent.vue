<template>
    <div class="modal fade" id="modal-divisas" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content  bg-secondary">
                <div class="modal-header">
                <h4 class="modal-title" v-text="title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form role="form" method="POST">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Precio Divisa</label>
                            <div class="col-md-9">
                            <input ref="modalPrice" id="nameprice" type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese Cotización" v-model="data.price" autofocus>
                            <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.price[0]"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                        <button v-if="create" type="submit" class="btn btn-primary" @click.prevent="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button>
                        <button v-else type="submit" class="btn btn-primary" @click.prevent="actionModal('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');
import Vue from 'vue';
import Divisas from './../admin/views/Divisas.vue';

export default {
    props:{
        data: {
            type: Object,
            default: () => ({}),
        },
        title:{
            type: String,
            default: () => ({}),
        },
        create:{
            type: Boolean,
        }
    },
    data(){
        return {
            url:"api/divisas",
            user_id: 0,
            errors: '',
        }
    },
    mounted(){
         this.focusInput();
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        }
    },
    methods:{
        actionModal(action){
            if(action == "store"){
                this.storeDivisa();
            }else{
                this.updateDivisa();
            }
        },
        storeDivisa(){
            var url = "/api/divisas";
            axios.post(url,{
                'price': this.data.price, 
                'user_id': this.user.id 
            }).then(response => {
                console.log(response.data)
                toastr.success('El Precio de la Divisa fue registrado.');
                this.$parent.reloadTable();
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
                $('#modal-divisas').modal('show');
            });
        },
        updateDivisa(){
            console.log(this.data.id)
            var url = `/api/divisa/${this.data.id}`;
            axios.put(url,{
                'id': this.data.id,
                'price': this.data.price, 
                'user_id': this.user.id 
            }).then(response => {
                toastr.info('El Precio de la Divisa fue actualizado.');
                this.$parent.reloadTable();
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
                $('#modal-divisas').modal('show');
            });
        },
        closeModal(){
            this.data.price = '';
            this.errors = '';
        },
        focusInput(){
            this.$refs.modalPrice.focus();
        }

    }
}
</script>