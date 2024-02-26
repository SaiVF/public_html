@extends('layouts.backend')

@section('title', 'Eliminar '.$page->title)

@section('content')
    <section class="content-header">
      <h1>
        Eliminar página
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('pages.index') }}">Páginas</a></li>
        <li class="active">Eliminar página</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar página: {{ $page->title }}</h3>
            </div>
            <div class="box-body">
              {{ Form::open(['method' => 'delete', 'route' => ['pages.destroy', $page->id]]) }}
                <div class="alert alert-danger">
                  <strong>¡Atención!</strong> Esta acción no se puede deshacer
                </div>
                {{ Form::submit('Sí, eliminar página', ['class' => 'btn btn-danger']) }}
                <a href="{{ route('pages.index') }}" class="btn btn-success">
                  <strong>No, volver atrás</strong>
                </a>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('footer')
<script>
$(function() {
    $('#pages-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection