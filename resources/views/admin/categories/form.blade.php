<div class="modal-body">
    <div class="form-group row">
        <label class="col-md-3 form-control-label">Nombre</label>
        <div class="col-md-9">
        <input id="name-category" name="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Ingrese Nombre de la Categoria" value="{{ old('name')}}" autofocus>
        <span class="invalid-feedback text-white" role="alert">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-md-3 form-control-label">Descripción</label>
        <div class="col-md-9">
            <input name="description" type="text" class="form-control" placeholder="Ingrese la Descripción" value="{{ old('description')}}">
        </div>
    </div>
</div>