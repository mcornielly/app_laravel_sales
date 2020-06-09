@extends('admin.layout')

@section('header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Categorías</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Categorías</li>
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
                <h3 class="card-title"><i class="fas fa-bars">&nbsp;</i> Lista de Categorías</h3>
                <a href="#" data-toggle="modal" data-target="#modal-category" data-backdrop="static" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i> Nueva Categoría</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nobre</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                   
                  <tbody> 
                      @foreach($categories as $category)     
                  <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                      @if($category->status == "ACTIVO")
                        <span class="badge badge-success">
                          {{ $category->status}}</td>
                        </span>  
                      @else 
                        <span class="badge badge-danger">
                          {{ $category->status}}</td>
                        </span>  
                      @endif
                    </td>
                    <td>
                        <a href="{{ route('categorias.edit', $category) }}" data-toggle="modal" data-target="#modal-category" data-backdrop="static"  class="btn btn-xs btn-primary" title="editar"><i class="fas fa-edit" aria-hidden="true"></i></a>
  
                        <form method="POST" action="{{ route('categorias.destroy', $category)}}" style="display: inline">
                          @csrf {{ method_field('DELETE') }}
                          <button href="#" class="btn btn-xs btn-danger"
                          onclick="return confirm('¿Está seguro que desea eliminar esta publicación. ?')"  
                          title="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </form>
                    </td>
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
    @include('admin.categories.create')
</section>
@stop
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush

@push('scripts')

<script>
// validación del modal categoiria
  if(window.location.hash === '#create'){
    $('#modal-category').modal('show');
  }

  $('#modal-category').on('shown.bs.modal', function(){
    $('#name-category').focus();
    window.location.hash = '#create';
  });

  $('#modal-category').on('hide.bs.modal', function(){
      window.location.hash = '#';
  });
</script>     

<!-- DataTables -->
<script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
      $('#example1').DataTable({
        "language":{
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