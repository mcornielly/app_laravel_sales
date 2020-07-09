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
                            <prices-product
                            :data="data"
                            :images="images"
                            :imgshow="imgshow"
                            >
                            </prices-product>            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="closeModal()" data-dismiss="modal">Cerrar</button>
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
        }
    },
    methods:{
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
  margin-left: 15%!important;
  margin-top: 5%!important;
}
</style>