@extends('layouts.backend')

@section('header')
  <link rel="stylesheet" href="{{ url('assets/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de entradas
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Blog</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Fecha</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @if($posts->isEmpty())
                <tr>
                  <td colspan="5" align="center">No hay entradas</td>
                </tr>
                @else
                  @foreach($posts as $post)
                <tr class="{{ $post->published_highlight }}">
                  <td><a href="{{ route('blog.edit', $post->id) }}">{{ $post->title }}</a> {!! $post->featured ? '<span class="label label-success"><i class="fa fa-star"></i> Destacado</span>' : '' !!}</td>
                  <td>{{ $post->theCategories() }}</td>
                  <td>
                    @if($post->theChildren()->first())
                    <img class="thumbnail-small" src="{{ url('uploads/thumbs/'.$post->theChildren()->first()->src) }}">
                    @endif
                  </td>
                  <td><span class="hidden">{{ $post->published_at }}</span>{{ $post->theDate() }}</td>
                  <td class="last">
                    <a href="{{ route('blog.edit', $post->id) }}" class="btn btn-success btn-xs">
                      <span class="fa fa-edit"></span> Editar
                    </a>
                    <a href="{{ route('children.index', ['parent_id' => $post->id, 'type' => 2]) }}" class="btn btn-primary btn-xs">
                      <span class="fa fa-picture-o"></span> Imágenes
                    </a>
                    <a href="{{ route('backend.blog.confirm', $post->id) }}" class="btn btn-danger btn-xs">
                      <span class="fa fa-close"></span> Eliminar
                    </a>
                  </td>
                </tr>
                  @endforeach     
                @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
<!-- DataTables -->
<script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- page script -->
<script>
$(function() {
  if($('#table tbody tr').length > 1) $('#table').DataTable({
    'order': [[ 3, 'desc' ]],
    'pageLength': 50,
    'language': {
      'lengthMenu': 'Mostrando _MENU_ registros por página',
      'zeroRecords': 'No hay registros',
      'info': 'Mostrando página _PAGE_ de _PAGES_',
      'infoEmpty': 'No hay registros',
      'infoFiltered': '(de un total de _MAX_ registros)',
      'search': 'Buscar',
      'paginate': {
        'first':      'Inicio',
        'last':       'Fin',
        'next':       'Siguiente',
        'previous':   'Anterior'
      }
    },
    'columnDefs': [
      {
        'orderable': false,
        'targets': [3]
      }
    ]
  });
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });
  $('#blog-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection