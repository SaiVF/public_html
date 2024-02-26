@extends('layouts.backend')

@section('title', 'Opciones')

@section('header')
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
var height = 200;
</script>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    @if(!empty($errors))

    @endif
    <section class="content-header">
      <h1>
        Opciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Opciones</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- form start -->
          {!! Form::open([
            'files' => true
          ]) !!}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Opciones</h3>
            </div>
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  @foreach($object as $group)
                  <li class="{{ $group->key == 1 ? 'active' : '' }}"><a href="#tab-{{ $group->key }}" data-toggle="tab">{{ $group->name }}</a></li>
                  @endforeach
                </ul>
                <div class="tab-content">
                  @foreach($object as $group)
                  <div id="tab-{{ $group->key }}" class="tab-pane fade {{ $group->key == 1 ? 'in active' : '' }}">
                    @foreach($group->options as $option)
                    @if($option->input == 'text')
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label($option->name, $option->title) !!}
                          {!! Form::text($option->name, $option->value, ['class' => 'form-control']) !!}
                        </div>
                      </div>
                    </div>
                    @elseif($option->input == 'image')
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label($option->name, $option->title) !!}
                          {!! Form::file($option->name) !!}
                        </div>
                      </div>
                      @if($option->value)
                      <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label($option->name, 'Imagen actual') !!}
                          <div class="thumbnail">
                            <img src="{{ url('uploads/'.$option->value) }}">
                          </div>
                        </div>
                      </div>
                      @endif
                    </div>
                    @elseif($option->input == 'html')
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label($option->name, $option->title) !!}
                          {!! Form::textarea($option->name, $option->value, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                      </div>
                    </div>
                    <script>
                    CKEDITOR.replace('{{ $option->name }}', {
                      contentsCss: contentsCss,
                      toolbar: toolbar,
                      allowedContent: true,
                      height: height,
                      bodyClass: '{{ $option->name }}'
                    });
                    </script>
                    @elseif($option->input == 'textarea')
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label($option->name, $option->title) !!}
                          {!! Form::textarea($option->name, $option->value, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                      </div>
                    </div>
                    @endif
                    @endforeach
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="box-footer">
              {{ Form::submit('Guardar configuración', ['class' => 'btn btn-primary']) }}
            </div>
          </div>
        {{ Form::close() }}
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
<!-- Page script -->
<script>
$(function() {
  $('#options-button').addClass('active');
});
</script>
@endsection