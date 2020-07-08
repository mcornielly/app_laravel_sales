<template>
    <div class="modal fade" id="modal-prices" data-backdrop="static"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container pt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title text-muted">
                                            <i class="fas fa-tag" style="font-size: 20px;">&nbsp;</i>
                                            <strong>{{data.name}}</strong>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0 text-muted">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                                                <div class="col-12">
                                                    <div v-for="(image,index) in images" :key="image.id">
                                                        <div v-show="index==0">
                                                        <img v-if="imgshow==false" :src="image.url" class="product-image" alt="Product Image">
                                                        <img v-else :src="imgProduct" class="product-image" alt="Product Image">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 product-image-thumbs">
                                                    <div v-for="image in images" :key="image.id">
                                                        <div class="product-image-thumb active" @click="imageShow(image.url)"><img :src="image.url" :alt="image.id"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 text-muted">
                                                <h3 class="my-3">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>
                                                <hr>
                                                <h4>Available Colors</h4>

                                                <div class="bg-gray py-2 px-3 mt-4">
                                                    <h2 class="mb-0">
                                                    $80.00
                                                    </h2>
                                                    <h4 class="mt-0">
                                                    <small>Ex Tax: $80.00 </small>
                                                    </h4>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" :class="{'justify-content-between':action}">
                    <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
                    <!-- <button v-if="create" type="button" class="btn btn-primary" @click="actionModal('store')" data-dismiss="modal" data-backdrop="false">Agregar</button> -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
import { compensateScroll } from '@fullcalendar/core'
export default {
    props:{
        data:{
            type: Object,
            default: () => {}
        },
        title:{
            type: String,
            default: ''
        },
        images:{
            type: Array,
            default: () => [],
        },
        imgshow:{
            type: Boolean,
            default: false,
        },
    },
    data(){
        return{
            imgProduct: '',
        }
    },
    // computed:{
    //     img(){
    //         return this.images[0].url 
    //     }
    // },
    methods:{
        imageShow(data){
            this.imgshow = true;
            this.imgProduct = data;      
        },
        closeModal(){
            this.images = [];
            this.imgProduct = '';
            this.imgshow=false;
            return 
        }
    }
        
}
</script>

<style>
.product-image {
  max-width: 60%!important;
  height: auto;
  width: 100%;
  margin-left: 20%!important;
  margin-top: 5%!important;
}
</style>