<template>
    <section>
        <div class="border border-primary rounded text-center pt-4 pb-4 mb-4">
            <div class="container">
                <img class="profile-user-img img-fluid img-circle" :src="user.avatar" alt="User profile picture">
                    <a v-show="editImg" style="position: absolute; padding-top: 75px; margin-left: -15px;" class="btn btn-link text-primary" @click.prevent="onInput" id="edit-photo-profile" href="#" title="editar foto" data-toggle="modal" data-target="#modal-profile-img">
                        <i class="fas fa-user-edit"></i>
                    </a>
                <h3 class="profile-username text-center text-capitalize" v-text="user.name"></h3>
                <p class="text-primary text-center text-capitalize" v-text="role.display_name"></p>
            </div>
            <!-- Modal Img Profile -->
            <template>
                <div v-show="loaded">
                    <div class="modal fade show" id="modal-profile-img" style="display: block; padding-right: 16px;" aria-modal="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Editar Imagen de Usuario</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12" >
                                            <div class="form-group">    
                                                <div class="row justify-content-center h-100">
                                                    <figure v-show="img_profile">
                                                        <img id="user_image" class="profile-user-img img-fluid img-circle" :src="img_profile" width="200" height="200" alt="Foto del Usuario">
                                                        <input id="img_user" type="hidden" name="img_user" v-model="pre_img">
                                                    </figure>
                                                </div>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input accept="image/*" type="file" class="custom-file-input" :class="{'is-invalid' : errorsImg[0] }" id="img_profile" ref="file" name="photo_profile" @change="getImage" size="1">
                                                        <label class="custom-file-label" for="img_profile"><span class="text-capitalize"> {{ nameImg }}</span></label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="">
                                                            <a href="#" @click.prevent="updateImg" data-dismiss="modal">Subir Imagen</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="text-left text-danger" role="alert">
                                                    <small>{{ errorsImg[0] }}</small>
                                                </span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                <button type="button" class="btn btn-default" data-dismiss="modal"  @click.prevent="closeModal()">Close</button>
                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>                       
                </div>
            </template>
        </div>  
    </section>
</template>

<script>
    export default {
        name: 'imagen-profile',
        props:[
            'user',
            'role',
            'editImg'
        ],
        data(){
            return{
                user_id: this.$route.params.usuario,
                avatar:'',
                errorsImg: [],
                pre_img:'',
                loaded: false,
                img_profile:'/images/avatars/default.jpg', 
                nameImg: 'Seleccionar Imagen',
            }    
        }, 
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            onInput(){
                if(this.loaded == false){
                    this.loaded = true;
                }else{
                    this.loaded = false;
                }
            },
            getImage(e){
                // let file = e.target.files[0];
                let file = e.target.files[0];
                let fileSize = parseInt(e.target.files[0].size/1024);
                let img = new Image();
                // console.log(file)
                
                this.nameImg = file.name.toLowerCase();
                this.errorsImg = [];
                if(fileSize >= 100){
                    this.avatar = file;
                    this.preImage(file);
                    // console.log(this.avatar)
            
                    setTimeout(() => {                    
                        let img_user =  $('#img_user').val(); 
                        img.onload = function(){
                            setTimeout(() => {
                                    if(this.height.toFixed(0) >= 400 && this.width.toFixed(0) >= 400 
                                        && this.height.toFixed(0) <= 700 && this.width.toFixed(0) <= 700){
                                        $("#user_image").attr("src",img_user);
                                    }else{
                                        this.nameImg = 'Seleccionar Imagen';
                                        this.errorsImg.push('Formato de Imagen no permitido'); 
                                        $("#user_image").attr("src",'/images/avatars/default.jpg');
                                        toastr.error("ERROR - Formato de Imagen Errado...!");
                                    }
                                }, 300)
                            }
                            img.src = URL.createObjectURL(file);

                    }, 300)
                }else{
                    this.nameImg = 'Seleccionar Imagen';
                    this.errorsImg.push('Formato de Imagen no permitido'); 
                    $("#user_image").attr("src",'/images/avatars/default.jpg');
                    toastr.error("ERROR - Formato de Imagen Errado...!");
                }   
            },
            preImage(file){
                let reader = new FileReader();

                reader.onload = e => {
                    this.pre_img = e.target.result;
                    $('#img_user').val(this.pre_img)
                    // this.img_profile = this.pre_img;
                }
                reader.readAsDataURL(file);

            },
            updateImg(){
                let me = this;
                let url = `/api/auth/usuarios/${this.user_id}/avatar`
                let data = new FormData();

                data.append('img', this.avatar);
                data.append('name', this.user.name); 
                
                this.$Progress.start()
                setTimeout(() => {
                    axios.post(url,data).then((response) =>{
                        me.user.avatar = response.data.userAvatarUpdate.avatar;
                        console.log(me.user.avatar)
                        toastr.info('La imagen del Usuario fue actualizada.');
                        this.closeModal();
                    })
                    .catch(error => {
                        let errors = error.response.data.errors;
                        this.$Progress.fail();
                        if (error.request.status == 422) {
                            this.errorsImg.push(errors.img[0])
                            toastr.error("ERROR - En la validaciones.");
                            $("#modal-profile-img").modal("show");
                        }
                    })
                this.$Progress.finish();
                }, 500);
            },
            closeModal(){
                this.avatar = '';
                this.errorsImg = [];
                this.loaded = false;
                this.nameImg = 'Seleccionar Imagen';
                this.img_profile = '/images/avatars/default.jpg';
                $("#user_image").attr("src",'/images/avatars/default.jpg');
            } 
        }
    }
</script>
