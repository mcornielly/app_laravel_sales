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
                  <input type="text" class="form-control  text-lowercase" placeholder="Ingrese Nombre del Cliente" v-model="rol.name">
                  <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.name[0]"></span>
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
                  <span v-if="errors" class="invalid-feedback text-white" role="alert" v-html="errors.display_name[0]"></span>
              </div>
          </div>
      </div>
      <div class="modal-footer justify-content-between">
          <router-link title="regresar" class="btn btn-default btn-sm" to="/roles"><i class="fas fa-angle-double-left" aria-hidden="true">&nbsp;</i> Regresar</router-link>
          <button type="button" title="actualizar" class="btn btn-primary btn-sm" @click.prevent="updateRol(rol)" data-dismiss="modal" data-backdrop="false">Actualizar</button>
      </div>
    </div>
</template>

<script>
    export default {
        name: 'role-view-app',
        data() {
            return {
                url:'/api/auth/roles',
                rol: {
                    name:'',
                    display_name:'',
                },
                errors: null
            }
        },
        created() {
            this.getRol();
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
                        display_name: this.rol.display_name
                    }).then((response) => {
                        console.log(response)
                        this.rol = response.data;
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