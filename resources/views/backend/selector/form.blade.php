@extends('layouts.backend')

@section('title', $selector->exists ? 'Editando '.$selector->title : 'Añadir entrada')

@section('header')
<link rel="stylesheet" href="{{ url('assets/plugins/select2/select2.min.css') }}">

@endsection
@section('content')
    <!-- Content Header (Page header) -->
    @if(!empty($errors))
    @endif
    <section class="content-header">
      <h1>
        {{ $selector->id ? 'Editando '.$selector->title : 'Añadir selector' }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('paises.index') }}">Selectores</a></li>
        <li class="active">{{ $selector->id ? 'Editando '.$selector->title : 'Añadir pais' }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- form start -->
          {{ Form::model($selector, [
            'method' => $selector->exists ? 'put' : 'post',
            'route' => $selector->exists ? ['selector.update', $selector->id] : ['selector.store'],
            'files' => true
          ]) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $selector->id ? 'Editando '.$selector->title : 'Añadir pais' }}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('title', 'Nombre') !!}
                      {!! Form::text('title', null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('type', 'Tipo') !!}
                      {!! Form::select('type', $selectores, $selector->exists ? $selector->type : null, ['class' => 'form-control select2', 'placeholder' => 'Selecciona un tipo']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('category_id', 'Categoría') !!}
                      {!! Form::select('category_id', $categories, $selector->exists ? $selector->category_id : null, ['class' => 'form-control select2', 'placeholder' => 'Selecciona una categoría']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                {{ Form::submit($selector->exists ? 'Guardar opción' : 'Añadir selector', ['class' => 'btn btn-primary']) }}
              </div>
            </div>
          {{ Form::close() }}
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
@section('footer')
<script src="{{ url('assets/plugins/select2/select2.full.min.js') }}"></script>
<!-- Page script -->
<script>
$(function() {
  $('.select2').select2();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#selector-button').addClass('active').find('.treeview-menu').show();
  


});
</script>
@endsection