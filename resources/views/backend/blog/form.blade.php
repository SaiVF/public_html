@extends('layouts.backend')

@section('title', $post->exists ? 'Editando '.$post->title : 'Añadir entrada')

@section('header')
<link rel="stylesheet" href="{{ url('assets/plugins/fileuploader/fileuploader.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{ url('assets/plugins/select2/select2.min.css') }}">
<script src="{{ url('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
var contentsCss = ['{{ url('css/reset.css') }}', '{{ url('css/style.css') }}', '{{ url('css/font-awesome.min.css') }}'];
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
        {{ $post->id ? 'Editando '.$post->title : 'Añadir entrada' }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('blog.index') }}">Blog</a></li>
        <li class="active">{{ $post->id ? 'Editando '.$post->title : 'Añadir entrada' }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- form start -->
          {{ Form::model($post, [
            'method' => $post->exists ? 'put' : 'post',
            'route' => $post->exists ? ['blog.update', $post->id] : ['blog.store'],
            'files' => true
          ]) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $post->id ? 'Editando '.$post->title : 'Añadir entrada' }}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      {!! Form::label('title', 'Título') !!}
                      {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      {!! Form::label('published_at', 'Fecha de publicación') !!}
                      {!! Form::text('published_at', null, ['class' => 'form-control datetimepicker']) !!}
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          {!! Form::checkbox('featured', null, $post->featured ?: false) !!}
                          Destacado
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      {!! Form::label('excerpt', 'Texto') !!}
                      {!! Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                  </div>
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('category', 'Categoría') !!}
                      {!! Form::select('category[]', $categories, $post->exists ? $selected_categories : null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('author', 'Autor') !!}
                      {!! Form::select('author', ['' => ''] + $authors->toArray(), null, ['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('content', 'Contenido') !!}
                      {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                      <script>
                      CKEDITOR.replace('content', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height,
                        bodyClass: 'post-content'
                      });
                      </script>
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
                {{ Form::submit($post->exists ? 'Guardar entrada' : 'Añadir entrada', ['class' => 'btn btn-primary']) }}
                @if($post->id)
                <a href="{{ route('children.index', ['parent_id' => $post->id, 'type' => 2]) }}" class="btn btn-primary">
                  <span class="fa fa-picture-o"></span> Imágenes
                </a>
                @endif
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/es.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
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

  $('.datetimepicker').datetimepicker({
    format: 'DD/MM/YYYY HH:mm:ss',
    locale: 'es'
  });

  $('#blog-button').addClass('active').find('.treeview-menu').show();
  
  $('body').on('click', '.fileuploader-action-attributes', function() {
    var $this = $(this);
    $.post('{{ url('backend/children/attr') }}', {
      id: $this.attr('data-id'),
      attr: $this.attr('data-attr')
    }, function(response) {
      var className = $this.attr('data-attr') == 1 ? '.fileuploader-action-featured' : '.fileuploader-action-background';
      $(className).removeClass('active-' + $this.attr('data-attr'));
      $this.addClass('active-' + $this.attr('data-attr'));
    });
    return false;
  });
  // enable fileupload plugin
  $('input[name="files"]').fileuploader({
      upload: {
          url: '{{ url('backend/children/upload') }}',
          data: {
              '_token': $('meta[name="csrf-token"]').attr('content'),
              'type': 2,
              'parent_id': '{{ $post->id ?: null }}',
              'title': '{{ $post->title ?: null }}'
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