@extends('layouts.backend')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de páginas
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Páginas</li>
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
              <table id="table" class="table table-bordered table-condensed table-striped">
                <thead>
                  <tr>
                    <th>#</th>
  					<th>Título</th>
  					<th>URI</th>
  					<th>Plantilla</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
					@if($pages->isEmpty())
					<tr>
						<td colspan="5" align="center">No hay páginas</td>
					</tr>
					@else
					@foreach($pages as $page)
					<tr class="{{ $page->hidden ? 'info' : '' }}">
                        <td class="cell-stretch">{{ $i++ }}</td>
						<td>{!! $page->linkToPaddedTitle(route('pages.edit', $page->id)) !!}</td>
						<td><a href="{{ url($page->uri) }}">{{ $page->prettyUri }}</a></td>
						<td>{{ $page->template or 'Ninguno' }}</td>
						<td class="cell-stretch">
							<a href="{{ route('pages.edit', $page->id) }}" class="btn btn-success btn-xs">
								<span class="fa fa-edit"></span> Editar
							</a>
              <a href="{{ route('children.index', ['parent_id' => $page->id, 'type' => 1]) }}" class="btn btn-info btn-xs">
                  <span class="fa fa-picture-o"></span> Imágenes
              </a>
              <a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-title="{{ $page->title }}" data-route="{{ route('pages.destroy', $page->id) }}">
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
                <h4 class="modal-title">Eliminar página</h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar la página <span id="page_title"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                {!! Form::open(['method' => 'delete']) !!}
                    {!! Form::button('Sí, eliminar página', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
$(function() {
    $('#pages-button').addClass('active').find('.treeview-menu').show();

    $('.btn-delete').on('click', function() {
        $('.modal form').attr('action', $(this).data('route'));
        $('#page_title').text($(this).data('title'));
    });
});
</script>
@endsection