@extends('layouts.backend')

@section('content')
    <section class="content-header">
      <h1>
        Categorías de {{ $type->name }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Categorías de {{ $type->name }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <a href="{{ route('backend.categories.create', $type->id) }}" class="btn btn-primary">Añadir categoría</a>
            </div>
          </div>
          <div class="box">
            <div class="box-body">
              <table id="table" class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Categoría superior</th>
                    <th>Imagen</th>
                    <th>SVG</th>
                    <th>Color de fondo</th>
                    <th>Color de principal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @if($categories->isEmpty())
                <tr>
                  <td colspan="4" align="center">No hay categorías</td>
                </tr>
                @else
                @foreach($categories as $category)
                <tr id="post_{{ $category->id }}">
                  <td class="first"><a href="{{ route('backend.categories.edit', $category->id) }}">{{ $category->name }}</a></td>
                  <td>
                    {{ $category->parent ? $category->theParent() : '-' }}
                  </td>
                  <td>
                    @if($category->image)
                    <img class="thumbnail-small" src="{{ url('uploads/'.$category->image) }}">
                    @endif
                  </td>
                  <td>
                    @if($category->svg)
                    Si
                    @else
                    No
                    @endif
                  </td>
                  <td>
                    @if($category->color)
                    <span class="label label-default" style="background-color: {{ $category->color }};">
                      {{ $category->color }}
                    </span>
                    @endif
                  </td>
                  <td>
                    @if($category->color_principal)
                    <span class="label label-default" style="background-color: {{ $category->color_principal }};">
                      {{ $category->color_principal }}
                    </span>
                    @endif
                  </td>
                  <td class="last">
                    <a href="{{ route('backend.categories.edit', $category->id) }}" class="btn btn-success btn-xs">
                      <span class="fa fa-edit"></span> Editar
                    </a>
                    <a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-name="{{ $category->name }}" data-route="{{ route('backend.categories.destroy', $category->id) }}">
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
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar categoría</h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar la categoría <span id="category_name"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                {!! Form::open() !!}
                    {!! Form::button('Sí, eliminar categoría', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Sortable -->
<script src="{{ url('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script>
$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });

  $('.btn-delete').on('click', function() {
    $('.modal form').attr('action', $(this).data('route'));
    $('#category_name').text($(this).data('name'));
  });

  $('#table tbody').sortable({
    update: function (event, ui) {
      var data = $(this).sortable('serialize');
        $.post('{{ url('backend/categories/ajax') }}', data, function(response) {
      });
    }
  });

  $('#{{ $type->route }}-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection