@extends('layouts.backend')

@section('title', 'Eliminar '.$child->title)

@section('content')
    <section class="content-header">
      <h1>
        Eliminar elemento
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('children.index', ['parent_id' => $child->parent_id, 'type' => $child->type]) }}">Elementos</a></li>
        <li class="active">Eliminar elemento</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar elemento: {{ $child->title }}</h3>
            </div>
            <div class="box-body">
      			{{ Form::open(['method' => 'delete', 'route' => ['children.destroy', $child->id]]) }}
                <div class="alert alert-danger">
                  <strong>¡Atención!</strong> Esta acción no se puede deshacer
                </div>
				  {{ Form::submit('Sí, eliminar este elemento', ['class' => 'btn btn-danger']) }}
				  <a href="{{ route('children.index', ['type' => $child->type, 'key' => $child->key]) }}" class="btn btn-success">
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
  $('#children-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection