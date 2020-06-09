@extends('admin.layout')

@section('header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Proveedores</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Proveedores</li>
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
                <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Lista Proveedores</h3>
                <a href="#create" data-toggle="modal" data-target="#modal-divisa" data-backdrop="static" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nuevo Ingreso</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo Documento</th>
                    <th>N° Documento</th>
                    <th>Dirección</th>
                    <th>N° Teléfono</th>
                    <th>Email</th>
                    <th>Contacto</th>
                    <th>N° Tlf. Contacto</th>
                  </tr>
                  </thead>
                  <tbody> 
                        @foreach($providers as $provider)     
                            <tr>
                                <td>{{ $provider->id }}</td>
                                <td>{{ $provider->customer->name }}</td>
                                <td>{{ $provider->customer->type_document }}</td>
                                <td>{{ $provider->customer->num_document }}</td>
                                <td>{{ $provider->customer->address }}</td>
                                <td>{{ $provider->customer->num_phone }}</td>
                                <td>{{ $provider->customer->email }}</td>
                                <td>{{ $provider->name }}</td>
                                <td>{{ $provider->contact_phone }}</td>
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
@push('style')
<!-- DataTables -->
<link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endpush

@push('script')
<!-- DataTables -->
<script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
      $('#example1').DataTable({
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