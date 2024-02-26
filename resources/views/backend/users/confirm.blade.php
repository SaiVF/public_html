@extends('layouts.backend')

@section('title', 'Eliminar '.$user->name)

@section('content')
    <section class="content-header">
      <h1>
        Eliminar ubicación
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="active">Eliminar usuario</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar usuario: {{ $user->name }}</h3>
            </div>
            <div class="box-body">
              <div class="alert alert-danger">
                <strong>¡Atención!</strong> Esta acción no se puede deshacer
              </div>
              {{ Form::open(['method' => 'delete', 'route' => ['users.destroy', $user->id]]) }}
                {{ Form::submit('Sí, eliminar este usuario', ['class' => 'btn btn-danger']) }}
                <a href="{{ route('users.index') }}" class="btn btn-success">
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
    $('#users-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection