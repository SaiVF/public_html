@extends('layouts.backend')

@section('header')
<link rel="stylesheet" href="{{ url('assets/plugins/fileuploader/fileuploader.min.css') }}">
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
        {{ $page->id ? 'Editando '.$page->title : 'Añadir página' }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Páginas</a></li>
        <li class="active">{{ $page->id ? 'Editando '.$page->title : 'Añadir página' }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          {{ Form::model($page, [
            'method' => $page->exists ? 'put' : 'post',
            'route' => $page->exists ? ['pages.update', $page->id] : ['pages.store'],
            'files' => true
          ]) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $page->id ? 'Editando '.$page->title : 'Añadir página' }}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('title', 'Título en menú') !!}
                      {{ Form::text('title', null, ['class' => 'form-control', 'required']) }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          {!! Form::hidden('hidden', 0) !!}
                          {!! Form::checkbox('hidden', null, $page->hidden ?: false) !!}
                          Ocultar del menú
                          <span class="help-block">
                            Sólo se puede ocultar páginas sin páginas inferiores
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('excerpt', 'Texto') !!}
                      {{ Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => 2]) }}
                    </div>
                  </div>
                </div>
                @if($pages_content)
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('contenido', 'Contenido')}}
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" style="display: block;">
                          @php $i = 0 @endphp
                          @foreach($pages_content as $content)
                          <li{!! ++$i == 1 ? ' class="active"' : '' !!}><a href="#content_tab_{{ $i }}" data-toggle="tab">{{ $content->title }}</a></li>
                          @endforeach
                        </ul>
                        <div class="tab-content">
                          @php $i = 0 @endphp
                          @foreach($pages_content as $content)
                          <div class="tab-pane{!! ++$i == 1 ? ' active' : '' !!}" id="content_tab_{{ $i }}">
                            <div class="form-group">
                              {{ Form::label('content['.$content->id.'][0]', 'Título') }}
                              {{ Form::text('content['.$content->id.'][0]', $content->title, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                              {{ Form::label('content['.$content->id.'][1]', 'Contenido') }}
                              {{ Form::textarea('content['.$content->id.'][1]', $content->content, ['class' => 'form-control']) }}
                            </div>
                          </div>
                          <script>
                          CKEDITOR.replace('content[{{ $content->id }}][1]', {
                            contentsCss: contentsCss,
                            toolbar: toolbar,
                            allowedContent: true,
                            height: height,
                            bodyClass: '{{ $page->uri }} {{ str_replace('-', '_', $page->uri) }}'
                          });
                          </script>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {{ Form::label('uri', 'URL')}}
                      {{ Form::text('uri', null, ['class' => 'form-control', 'required']) }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('name', 'Ruta') !!}
                      {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      {{ Form::label('template', 'Plantilla')}}
                      {{ Form::select('template', $templates, $page->template ?: null, ['class' => 'form-control'])}}
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      {{ Form::label('attr', 'Atributos')}}
                      {{ Form::text('attr', null, ['class' => 'form-control']) }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    {{ Form::label('order', 'Orden') }}
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      {!! Form::select('order', [
                        '' => '',
                        'before' => 'Antes de',
                        'after' => 'Después de',
                        'childOf' => 'Debajo de'
                      ], null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::select('orderPage',
                      ['' => '']
                      + $orderPages->pluck('paddedTitle', 'id')->toArray(), null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('files', 'Imágenes') !!}
                      {!! Form::file('files', ['data-fileuploader-files' => $files]) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                {!! Form::button($page->exists ? 'Guardar página' : 'Añadir página', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                @if($page->id)
                <a href="{{ route('children.index', ['parent_id' => $page->id, 'type' => 1]) }}" class="btn btn-primary">
                  <span class="fa fa-picture-o"></span> Imágenes
                </a>
                @endif
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
<script src="{{ url('assets/plugins/fileuploader/jquery.fileuploader.min.js') }}"></script>
<script>
$(function () {
  $('#pages-button').addClass('active').find('.treeview-menu').show();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('input[name="files"]').fileuploader({
      upload: {
          url: '{{ url('backend/children/upload') }}',
          data: {
              '_token': $('meta[name="csrf-token"]').attr('content'),
              'type': 1,
              'parent_id': '{{ $page->id ?: null }}',
              'title': '{{ $page->title ?: null }}'
          },
          type: 'POST',
          enctype: 'multipart/form-data',
          start: true,
          synchron: false,
          beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
              return true;
          },
          onSuccess: function(data, item, listEl, parentEl, newInputEl, inputEl, textStatus, jqXHR) {
              item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Eliminar"><i></i></a>');
              item.data.id = data;
              setTimeout(function() {
                  item.html.find('.progress-bar2').fadeOut(400);
              }, 400);
          },
          onError: function(item, listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus, errorThrown) {
              var progressBar = item.html.find('.progress-bar2');

              if (progressBar.length > 0) {
                  progressBar.find('span').html(0 + "%");
                  progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                  item.html.find('.progress-bar2').fadeOut(400);
              }

              item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                  '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
              ) : null;
          },
          onProgress: function(data, item, listEl, parentEl, newInputEl, inputEl) {
              var progressBar = item.html.find('.progress-bar2');

              if (progressBar.length > 0) {
                  progressBar.show();
                  progressBar.find('span').html(data.percentage + "%");
                  progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
              }
          },
          onComplete: function(listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
              // your callback here
          },
      },
      onRemove: function(item, listEl, parentEl, newInputEl, inputEl) {
        $.post('{{ url('backend/children/remove') }}', { id: item.data.id });
        return true;
      },
      captions: {
          button: function(options) {
              return 'Selecciona ' + (options.limit == 1 ? 'archivo' : 'archivos');
          },
          feedback: function(options) {
              return 'Selecciona ' + (options.limit == 1 ? 'archivo' : 'archivos') + ' para cargar';
          },
          feedback2: function(options) {
              return options.length + ' ' + (options.length > 1 ? ' archivos han sido seleccionados' : ' archivo ha sido seleccionado');
          },
          confirm: 'Confirmar',
          cancel: 'Cancelar',
          name: 'Nombre',
          type: 'Tipo',
          size: 'Tamaño',
          dimensions: 'Dimensiones',
          duration: 'Duración',
          crop: 'Crop',
          rotate: 'Rotate',
          download: 'Descargar',
          featured: 'Establecer como imagen principal',
          background: 'Establecer como imagen de portada',
          remove: 'Remove',
          drop: 'Drop the files here to Upload',
          paste: '<div class="fileuploader-pending-loader"><div class="left-half" style="animation-duration: ${ms}s"></div><div class="spinner" style="animation-duration: ${ms}s"></div><div class="right-half" style="animation-duration: ${ms}s"></div></div> Pasting a file, click here to cancel.',
          removeConfirmation: 'Está seguro de eliminar esta imagen?',
          errors: {
              filesLimit: 'Only ${limit} files are allowed to be uploaded.',
              filesType: 'Only ${extensions} files are allowed to be uploaded.',
              fileSize: '${name} is too large! Please choose a file up to ${fileMaxSize}MB.',
              filesSizeAll: 'Files that you choosed are too large! Please upload files up to ${maxSize} MB.',
              fileName: 'File with the name ${name} is already selected.',
              folderUpload: 'You are not allowed to upload folders.'
          }
      }
  });
});
</script>
@endsection