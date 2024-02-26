@extends('layouts.backend')

@section('title', $child->exists ? 'Editando '.$child->title : 'Crear nuevo elemento')

@section('content')
    <!-- Content Header (Page header) -->
    @if(!empty($errors))
    @endif
    <section class="content-header">
      <h1>
        {{ $child->exists ? 'Editando '.$child->title : 'Añadir elemento' }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('children.index', ['parent_id' => $child->parent_id, 'type' => $child->type]) }}">Elementos</a></li>
        <li class="active">{{ $child->exists ? 'Editando '.$child->title : 'Añadir elemento' }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- form start -->
          {!! Form::model($child, [
            'method' => $child->exists ? 'put' : 'post',
            'route' => $child->exists ? ['children.update', $child->id] : ['children.store'],
            'files' => true
          ]) !!}
            {{ Form::hidden('parent_id', $request->parent_id) }}
            {{ Form::hidden('type', $request->type) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $child->exists ? 'Editando '.$child->title : 'Añadir elemento' }}</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">                
                    <div class="form-group">
                      {!! Form::label('title', 'Título') !!}
                      {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          {!! Form::checkbox('featured', null, $child->attr ?: false) !!}
                          Establecer como imagen principal
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('url', 'Enlace') !!}
                      {!! Form::text('url', null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('url_text', 'Texto de botón') !!}
                      {!! Form::text('url_text', null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                  @if(!empty($categories))
                  <div class="col-md-4">                
                    <div class="form-group">
                      {{ Form::label('category', 'Categoría')}}
                      {!! Form::select('category', $categories, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar categoría']) !!}
                     </div>
                  </div>
                  @endif
                </div>
                <div class="row">
                  <div class="col-md-12">                
                    <div class="form-group">
                      {!! Form::label('excerpt', 'Extracto') !!}
                      {!! Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => 2]) !!}
                     </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">                
                    <div class="form-group">
                      {!! Form::label('content', 'Contenido') !!}
                      {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 2]) !!}
                     </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">                
                    <div class="form-group">
                      {!! Form::label('src', 'Imagen') !!}
                      {!! Form::file('src') !!}
                    </div>
                  </div>
                  <div class="col-md-6">                
                    <div class="form-group">
                      @if($child->src)
                      <label>Imagen actual</label>
                      <div class="thumbnail"><img src="{{ url('uploads/'.$child->src) }}"></div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                {{ Form::submit($child->exists ? 'Guardar elemento' : 'Crear nuevo elemento', ['class' => 'btn btn-primary']) }}
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
<script src="{{ url('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
var contentsCss = ['{{ url('css/reset.css') }}', '{{ url('css/style.css') }}', '{{ url('assets/css/AdminLTE.min.css') }}', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'];
CKEDITOR.replace('content', {
  contentsCss: contentsCss,
  allowedContent: true,
  bodyClass: 'content'
});
$(function() {
  $('#children-button').addClass('active').find('.treeview-menu').show();
});
</script>
@endsection