<template>
         <div class="modal fade" id="modal-ex">
            <div class="modal-dialog">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">Info Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <label for="">Código del Producto</label>
                        <input type="text" class="form-control" id="input_focus" v-modal="code">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-light">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');
// import {IMaskDirective} from 'vue-imask';
// import {IMaskComponent} from 'vue-imask';
// import VueBarcode from 'vue-barcode';
// import vue2Dropzone from 'vue2-dropzone';
// import 'vue2-dropzone/dist/vue2Dropzone.min.css';

export default {
    // props:{
    //     data: {
    //         type: Object,
    //         default: () => ({}),
    //     },
    //     categories: {
    //         type: Array,
    //         default: () => [],
    //     },
    //     divisa: {
    //         type: Number,
    //         default: 0,
    //     },
    //     categoryName:{
    //         type: Object,
    //         default: () => ({}),
    //     },
    //     images:{
    //         type: Array,
    //         default: () => [],
    //     },
    //     title:{
    //         type: String,
    //         default: () => ({}),
    //     },
    //     action:{
    //         type: Boolean,
    //     },
    //     storeup:{
    //         type: Boolean,
    //     }
    // },
    // data(){
    //     return {
    //         url:"api/producto",
    //         user_id:0,
    //         errors: '',
    //         name:'',
    //         product_id: 0,
    //         category_id: 0,
    //         description:'',
    //         price: 0,
    //         stock: 0,
    //         code:0,
    //         wholesale_quantity: 0,
    //         margin_gain_u: 0,
    //         margin_gain_w: 0,
    //         dropzoneOptions: {
    //             url: 'api/producto/img',
    //             paramName: 'photo',
    //             acceptedFiles: 'image/*',
    //             thumbnailWidth: 150,
    //             thumbnailHeight: 100,
    //             maxFilesize: 2,
    //             maxFiles: 3,
    //             headers: { "My-Awesome-Header": "header value" },
    //             dictDefaultMessage: 'Arrastra las imagenes para subirlas',
    //             // autoProcessQueue:false
    //         },
    //         value:'',
    //         mask: {
    //             amount: {
    //                 mask: Number,
    //                 scale: 2, 
    //                 signed: false,
    //                 thousandsSeparator: ".", 
    //                 padFractionalZeros: true, 
    //                 normalizeZeros: true,
    //                 radix: ",", 
    //                 mapToRadix: ["."], 
    //                 max: 100000000
    //             }
    //         },
    //         image: '',
    //         photos:[],
    //         close: false
    //     }
    // },
    // components:{
    //     'barcode': VueBarcode,
    //     'vueDropzone': vue2Dropzone,
    //     'imask-input': IMaskComponent
    // },
    // directives: {
    //   imask: IMaskDirective
    // },
    // computed:{
    //     user(){
    //         return JSON.parse(user.content);
    //     },
    //     price_gain_u: function(){
    //         var result = (this.data.price * this.data.margin_gain_u / 100).toFixed(2);
    //         this.p_gain_u = result;
    //         return result;
    //     },
    //     divisa_unit: function(){
    //         var result = 0;
    //         if(this.divisa > 0 || this.unit_price > 0){
    //             var result = (this.unit_price / this.divisa).toFixed(2);
    //         }
    //         return result;
    //     },
    //     unit_price: function(){
    //         var result = 0;
    //         if(this.data.stock > 0 || this.data.price > 0){
    //             var result = ((parseFloat(this.price_gain_u) + parseFloat(this.data.price)) / this.data.stock).toFixed(2);
    //         }
    //         return result;
    //     },
    //     price_gain_w: function(){
    //         var result = (this.data.price * this.data.margin_gain_w / 100).toFixed(2);
    //         return result;
    //     },
    //     wholesale_divisa: function(){
    //         var result = 0;
    //         if(this.divisa > 0 || this.wholesale_price > 0){
    //             result = (this.wholesale_price / this.divisa).toFixed(2);
    //         }
    //         return result;
    //     },
    //     wholesale_price: function(){
    //         var result = 0;
    //         if(this.data.wholesale_quantity > 0 || this.data.price > 0){
    //             result = (parseFloat(this.price_gain_w) + parseFloat(this.data.price)).toFixed(2);
    //         }
    //         return result;
    //     }
    // },
    // methods:{
    //     onAccept (value) {
    //         console.log(value)
    //         // const maskRef = e.detail;
    //         // this.value = maskRef.value;
    //         // console.log('accept', maskRef.value);
    //     },
    //     vremoved(file, xhr, error) {
    //         this.$refs.myVueDropzone.removeAllFiles();
    //         if(this.close == true && !this.photos){
    //             this.removeStorage();
    //             this.close = false;    
    //         }
    //         this.photos = [];
    //         // window.toastr.warning('', 'Event : vdropzone-removedFile')
    //     },
    //     removeStorage(){
    //         console.log(this.photos)
    //         var url = "api/fotos/url";
    //         axios.post(url,{
    //             'photos': this.photos, 
    //         }).then(response => {
    //             console.log(response.data)
    //         }).catch(error => {
    //             console.log(error);
    //             var errors = error.response.data.errors;
    //             this.errors = errors;
    //         });
    //     },
    //     eventError(file, message, xhr){
    //         var error = message.message;
    //         // console.log(message)
    //         $('.dz-error-message:last > span').text(error);
    //     },
    //     eventSuccess(file, response){
    //         this.image = response;  
    //         this.photos.push(this.image);
    //         // console.log(this.photos)  
    //     },
    //     actionModal(action){
    //         if(action == "store"){
    //             this.storeProduct();
    //         }else{
    //             this.updateProduct();
    //         }
    //     },
    //     // storeProduct(){
    //     //     var url = this.url;
    //     //     axios.post(url,{
    //     //         'name': this.data.name, 
    //     //         'description': this.data.description 
    //     //     }).then(response => {
    //     //         console.log(response.data)
    //     //         this.$parent.reloadTable();
    //     //         toastr.success('El producto fue registrado.');
    //     //     }).catch(error => {
    //     //         console.log(error);
    //     //         var errors = error.response.data.errors;
    //     //         this.errors = errors;
    //     //     });
    //     // },
    //     updateProduct(){
    //         var url = `${this.url}/${this.data.id}`;
    //         axios.put(url,{
    //             'id': this.data.id,
    //             'name':this.data.name,
    //             'category_id':this.data.category_id,
    //             'code':this.data.code,
    //             'price':this.data.price,
    //             'stock':this.data.stock,
    //             'description': this.data.description,
    //             'margin_gain_u':this.data.margin_gain_u,
    //             'divisa_unit':this.divisa_unit,
    //             'wholesale_quantity':this.data.wholesale_quantity,
    //             'margin_gain_w':this.data.margin_gain_w,
    //             'wholesale_divisa':this.wholesale_divisa,
    //             'user_id':this.user.id,
    //             'photos':this.photos
    //         }).then(response => {
    //             this.$parent.reloadTable();
    //             this.vremoved();
    //             toastr.info('El producto fue actualizado.');
    //         }).catch(error => {
    //             console.log(error.response.data);
    //             var errors = error.response.data.errors;
    //             this.errors = errors;
    //         });
    //     },
    //     deleteImag(data){
    //         var url = `api/fotos/eliminar/${data}`;
    //         axios.delete(url,{
    //             'photo': this.photos
    //         }).then(response => {
    //             console.log(response.data)
    //             this.product_id = response.data.product_id;
    //             console.log(this.product_id);
    //             this.$parent.getImages(this.product_id);
    //             toastr.success('La foto del producto ha sido eliminada.');
    //         }).catch(error => {
    //             console.log(error);
    //             var errors = error.response.data.errors;
    //             this.errors = errors;
    //         });
    //     },
    //     closeModal(){
    //         this.close = true;
    //         this.selectedRow = {};
    //         this.errors = '';
    //         this.vremoved();
    //         this.$parent.reloadTable();
    //         this.data.price = '';
    //     },

    // }
}
</script>

<style>
.capitalize {
  text-transform: capitalize;
}
</style>