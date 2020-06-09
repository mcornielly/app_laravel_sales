<div class="modal fade" id="modal-divisas">
    <div class="modal-dialog modal-lg">
      <div class="modal-content  bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Cotización la Divisa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" action="{{ route('divisa.store') }}" method="POST">
        @csrf
          <div class="modal-body">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Precio Divisa</label>
                <div class="col-md-9">
                <input id="name-price" name="price" type="text" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" placeholder="Ingrese Cotización" value="{{ old('price')}}" autofocus>
                <span class="invalid-feedback text-white" role="alert">{{ $errors->first('price') }}</span>
                </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

