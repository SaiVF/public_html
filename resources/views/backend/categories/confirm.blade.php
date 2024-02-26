@extends('layouts.backend')

@section('title', 'Eliminar '.$category->name)

@section('content')
    <section class="content-header">
      <h1>
        Eliminar categoría
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('categories.index') }}">Categorías</a></li>
        <li class="active">Eliminar categoría</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar categoría: {{ $category->name }}</h3>
            </div>
            <div class="box-body">
              <div class="alert alert-danger">
                <strong>¡Atención!</strong> Esta acción no se puede deshacer
              </div>
    		      {{ Form::open(['method' => 'delete', 'route' => ['categories.destroy', $category->id]]) }}
        				{{ Form::submit('Sí, eliminar esta categoría', ['class' => 'btn btn-danger']) }}
        				<a href="{{ route('categories.index') }}" class="btn btn-success">
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
  $('#categorias-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection