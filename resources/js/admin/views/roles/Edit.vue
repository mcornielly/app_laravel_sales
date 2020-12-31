<template>
    <div v-if="rol">
        <div id="form-rol">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Nombre</label>
                    <div class="input-group col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-user-tag"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control  text-lowercase" :class="{'is-invalid' : errors.name}" placeholder="Ingrese Nombre del Cliente" v-model="rol.name">
                    <span v-if="errors.name" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Rol</label>
                    <div class="input-group col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-user-tag"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control text-capitalize" placeholder="Ingrese Nombre del Cliente" v-model="rol.display_name">
                    <span v-if="errors.display_name" class="invalid-feedback text-white" role="alert" v-html="errors.display_name[0]"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Descripción</label>
                <div class="col-md-9">
                <textarea class="form-control text-capitalize" :class="{'is-invalid' : errors.description}" cols="60" rows="3" v-model="rol.description" placeholder="Ingrese dirección"></textarea>
                <span v-if="errors.description" class="invalid-feedback text-danger" role="alert" v-html="errors.description[0]"></span>
                </div>
            </div>  
        </div>
        <div class="modal-footer clearfix pb-0">
            <!-- <router-link title="regresar" class="btn btn-default btn-sm" to="/roles"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link> -->
            <button type="button" title="actualizar" class="btn btn-info btn-block" @click.prevent="updateRol(rol)" data-dismiss="modal" data-backdrop="false">Actualizar</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'role-view-app',
        data() {
            return {
                url:'/api/auth/roles',
                title:'Editar Rol',
                rol: {
                    name:'',
                    display_name:'',
                    description: ''
                },
                errors: ''
            }
        },
        created() {
            this.getRol();
            this.$emit('title', this.title);
            this.$emit('path', this.$route.path);
        },
        computed: {
            currentUser(){
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            getRol(){
                let url = `/api/auth/roles/${this.$route.params.role}/edit`
                console.log(url)
                axios.get(url).then((response) => {
                    console.log(response)
                    this.rol = response.data;
                }) 
            },
            updateRol(){
                let url = `/api/auth/roles/${this.$route.params.role}`
                console.log(url)
                setTimeout(() => {
                    this.$Progress.start()    
                    axios.put(url,{
                        id: this.$route.params.role,
                        name: this.rol.name,
                        display_name: this.rol.display_name,
                        description: this.rol.description
                    }).then((response) => {
                        console.log(response)
                        this.rol = response.data;
                        toastr.info('El Rol fue actualizado.');
                        this.$router.push({ path: "/roles" });
                    }).catch(error => {
                        let errors = error.response.data.errors;
                        console.log(errors)
                        if (error.response.status == 422) {
                            this.errors = errors;
                            toastr.error("ERROR - En la validaciones.");
                        }
                        this.$Progress.fail()
                    })
                this.$Progress.finish()
                },1000)    
            }
        }
    }
</script>