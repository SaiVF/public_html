@extends('layouts.backend')

@section('title', $pais->exists ? 'Editando '.$pais->title : 'Añadir entrada')

@section('header')
<link rel="stylesheet" href="{{ url('assets/plugins/fileuploader/fileuploader.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{ url('assets/plugins/select2/select2.min.css') }}">
<script src="{{ url('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
var contentsCss = ['{{ url('css/reset.css') }}', '{{ url('css/style.css') }}', '{{ url('assets/css/AdminLTE.min.css') }}', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'];
var toolbar = [
  { name: 'styles', items: [ 'Source', 'Styles', 'Format' ] },
  { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
  { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
  { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'Youtube' ] },
  { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
];
var height = 400;
</script>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    @if(!empty($errors))
    @endif
    <section class="content-header">
      <h1>
        {{ $pais->id ? 'Editando '.$pais->title : 'Añadir pais' }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('paises.index') }}">Productos</a></li>
        <li class="active">{{ $pais->id ? 'Editando '.$pais->title : 'Añadir pais' }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- form start -->
          {{ Form::model($pais, [
            'method' => $pais->exists ? 'put' : 'post',
            'route' => $pais->exists ? ['paises.update', $pais->id] : ['paises.store'],
            'files' => true
          ]) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $pais->id ? 'Editando '.$pais->title : 'Añadir pais' }}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('nombre', 'Nombre') !!}
                      {!! Form::text('nombre', null, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('name', 'Name') !!}
                      {!! Form::text('name', null, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('nom', 'Nom') !!}
                      {!! Form::text('nom', null, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('file', 'Icono') !!}
                      {!! Form::file('file') !!}
                    </div>
                  </div>
                  @if($pais->id)
                  @if($pais->icon)
                  <div class="col-md-6">
                    <div class="form-group">
                      <img src="{{ url('uploads/'.$pais->icon) }}" class="img-responsive">
                    </div>
                  </div>
                  @endif
                  @endif
                </div>
              </div>
              <div class="box-footer">
                {{ Form::submit($pais->exists ? 'Guardar pais' : 'Añadir pais', ['class' => 'btn btn-primary']) }}
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
<script src="{{ url('assets/plugins/fileuploader/jquery.fileuploader.min.js') }}"></script>
<script src="{{ url('assets/plugins/number/jquery.number.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/es.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ url('assets/plugins/select2/select2.full.min.js') }}"></script>
<!-- Page script -->
<script>
$(function() {
  $('.select2').select2();
  $('.number').number(true, 0, ',', '.');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'es',
    ignoreReadonly: true,
  });

  $('#paises-button').addClass('active').find('.treeview-menu').show();
  


});
</script>
@endsection