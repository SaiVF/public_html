@extends('layouts.backend')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Elementos de {{ !empty($parent->title) ? $parent->title : $parent->name }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Elementos</li>
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
              <a href="#" class="btn btn-primary multiple">Añadir elementos</a>
              {{ Form::open([
                'files' => true,
                'route' => ['backend.children.multiple', $request->parent_id]
              ]) }}
                {{ Form::hidden('title', !empty($parent->title) ? $parent->title : $parent->name) }}
                {{ Form::hidden('parent_id', $request->parent_id) }}
                {{ Form::hidden('type', $request->type) }}
                {{ Form::file('files[]', [
                  'multiple' => 'multiple',
                  'class' => 'hidden',
                  'id' => 'files',
                  'accept' => 'image/*'
                ]) }}
              {{ Form::close() }}
            </div>
          </div>
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if($children->isEmpty())
                  <tr>
                    <td colspan="3" align="center">No hay elementos</td>
                  </tr>
                  @else
                  @foreach($children as $child)
                  <tr id="post_{{ $child->id }}">
                    <td><a href="{{ route('children.edit', $child->id) }}">{{ $child->title }}</a></td>
                    <td>
                      <a href="{{ route('children.edit', $child->id) }}" class="thumbnail thumbnail-small"><img src="{{ url('uploads/thumbs/'.$child->src) }}"></a>
                    </td>
                    <td class="last">
                      <a href="{{ route('children.edit', $child->id) }}" class="btn btn-success btn-xs">
                        <span class="fa fa-edit"></span> Editar
                      </a>
                      <a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-title="{{ $child->title }}" data-route="{{ route('children.destroy', $child->id) }}">
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
                <h4 class="modal-title">Eliminar imagen</h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar la imagen <span id="child_title"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                {!! Form::open(['method' => 'delete']) !!}
                    {!! Form::button('Sí, eliminar imagen', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script src="{{ url('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script>
$(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });
  $('#table tbody').sortable({
    update: function (event, ui) {
      var data = $(this).sortable('serialize');
        $.post('{{ url('backend/children/ajax') }}', data, function(response) {
        });
    }
  });

  $('.btn-delete').on('click', function() {
    $('.modal form').attr('action', $(this).data('route'));
    $('#child_title').text($(this).data('title'));
  });

  $('.multiple').on('click', function() {
    $('#files').trigger('click');
    return false;
  });

  $('#files').on('change', function() {
    if($('#files').get(0).files.length !== 0) {
      $(this).parents('form').submit();
      return false;
    }
  });
});
$(function() {
  $('#children-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection