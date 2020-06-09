@extends('admin.layout')

@section('header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Divissa</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Divisa</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<section class="content">
  <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Cotización de la Divisa</h3>
              <a href="#" data-toggle="modal" data-target="#modal-divisas" data-backdrop="static" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Actualizar Divisa</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tb_divisas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Precio</th>
                  <th>Usuario</th>
                  <th>Fecha</th>
                </tr>
                </thead>
                <tbody> 
                      @foreach($divisas as $divisa)     
                          <tr>
                              <td>{{ $divisa->id }}</td>
                              <td>{{ $divisa->price }}</td>
                              <td>Aministrador{{ $divisa->user }}</td>
                              <td>{{ $divisa->created_at }}</td>
                          </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
  </div>
      <!-- /.row -->
    {{-- Modal  --}}
    @include('admin.divisas.create')
</section>
@stop
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush

@push('scripts')

<script>
  // console.log(window.location.hash)
  // validación del modal divisa
  if(window.location.hash === '#create'){
    $('#modal-divisas').modal('show');
  }
  
  $('#modal-divisas').on('hide.bs.modal', function(){
    window.location.hash = '#';
  });

  $('#modal-divisas').on('shown.bs.modal', function(){
    $('#name-price').focus();
    window.location.hash = '#create';
  });
</script>  

<!-- DataTables -->
<script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
      $('#tb_divisas').DataTable({
        "order": [[ 0, "desc" ]],
        "language":{
            "decimal": "-",
            "thousands": ".",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
        "order": [[ 0, "desc" ]]  
        // "paging": true,
        // "lengthChange": true,
        // "searching": true,
        // "ordering": true,
        // "info": true,
        // "autoWidth": true,
      });
    });
</script>
@endpush