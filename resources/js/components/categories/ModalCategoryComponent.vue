<template>
   <div class="modal fade" id="modal-category" data-backdrop="static"  tabindex="-1" role="dialog">
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
                            <label class="col-md-3 form-control-label">Categoría</label>
                            <div class="col-md-9">
                            <input id="name-category" type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese Categoría" v-model="data.name" :disabled="storeup" autofocus>
                            <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Descripción</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" :class="{'is-invalid' : errors}" placeholder="Ingrese Descripción" v-model="data.description" :disabled="storeup" autofocus>
                            <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.description[0]"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" :class="{'justify-content-between':action}">
                        <button type="button" class="btn btn-default" :class="{'pull-right' : storeup}" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                        <div v-if="action">
                            <button v-if="create" type="submit" class="btn btn-primary" @click="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button>
                            <button v-else type="submit" class="btn btn-primary" @click="actionModal('update')" data-dismiss="modal" data-backdrop="false">Actualizar</button>
                        </div>
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
        },
        action:{
            type: Boolean,
        },
        storeup:{
            type: Boolean,
        }
    },
    data(){
        return {
            url:"api/categoria",
            errors: '',
        }
    },
    computed:{
        user(){
            return JSON.parse(user.content);
        }
    },
    methods:{
        actionModal(action){
            if(action == "store"){
                this.storeCategory();
            }else{
                this.updateCategory();
            }
        },
        storeCategory(){
            var url = this.url;
            axios.post(url,{
                'name': this.data.name, 
                'description': this.data.description 
            }).then(response => {
                console.log(response.data)
                this.$parent.reloadTable();
                toastr.success('La categoría fue registrada.');
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        updateCategory(){
            var url = `${this.url}/${this.data.id}`;
            console.log(url)
            axios.put(url,{
                'id': this.data.id,
                'name':this.data.name,
                'description': this.data.description,
            }).then(response => {
                toastr.info('La categoría fue actualizada.');
                this.$parent.reloadTable();
            }).catch(error => {
                console.log(error);
                var errors = error.response.data.errors;
                this.errors = errors;
            });
        },
        closeModal(){
            this.selectedRow = {};
            this.errors = '';
            this.$parent.reloadTable();
        },

    }
}
</script>