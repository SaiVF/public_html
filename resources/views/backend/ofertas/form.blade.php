@extends('layouts.backend')

@section('title', $oferta->exists ? 'Editando '.$oferta->title : 'Añadir entrada')

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
        {{ $oferta->id ? 'Editando '.$oferta->title : 'Añadir oferta' }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('ofertas.index') }}">Ofertas</a></li>
        <li class="active">{{ $oferta->id ? 'Editando '.$oferta->title : 'Añadir oferta' }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- form start -->
          {{ Form::model($oferta, [
            'method' => $oferta->exists ? 'put' : 'post',
            'route' => $oferta->exists ? ['ofertas.update', $oferta->id] : ['ofertas.store'],
            'files' => true
          ]) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $oferta->id ? 'Editando '.$oferta->title : 'Añadir oferta' }}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('title', 'Título') !!}
                      {!! Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('fecha_inicio', 'Fecha de inicio') !!}
                      {!! Form::text('fecha_inicio', null, ['class' => 'form-control datetimepicker', 'readonly']) !!}
                      <span class="badge label label-success clear-fecha">Borrar</span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('fecha_limite', 'Fecha límite') !!}
                      {!! Form::text('fecha_limite', null, ['class' => 'form-control datetimepicker', 'readonly']) !!}
                      <span class="badge label label-success clear-fecha">Borrar</span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('inicio_aplicacion', 'Fecha de inicio de proceso de aplicación') !!}
                      {!! Form::text('inicio_aplicacion', null, ['class' => 'form-control datetimepicker', 'readonly']) !!}
                      <span class="badge label label-success clear-fecha">Borrar</span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('cierre_aplicacion', 'Fecha de cierre de proceso de aplicación') !!}
                      {!! Form::text('cierre_aplicacion', null, ['class' => 'form-control datetimepicker', 'readonly']) !!}
                      <span class="badge label label-success clear-fecha">Borrar</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('category', 'Categoría') !!}
                      {!! Form::select('category[]', $categories, $oferta->exists ? $selected_categories : null, ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('lugar', 'Lugar') !!}
                      {!! Form::text('lugar', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('lugar_aplicar', 'Institución oferente') !!}
                      {!! Form::text('lugar_aplicar', $oferta->exist ? $oferta->user->lugar_aplicar : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      
                      {!! Form::label('uri_aplicacion', 'Enlace oficial para aplicar') !!}
                      {!! Form::text('uri_aplicacion', null, ['class' => 'form-control']) !!}
                      {{--
                      <label for="precio">Precio</label>
                      <select class="form-control" name="precio">
                        <option value="">----</option>
                        <option value="Sin costo">Sin costo</option>
                        <option value="Con financiamiento parcial">Con financiamiento parcial</option>
                        <option value="Con financiamiento total">Con financiamiento total</option>
                      </select>
                      <span class="help-block">
                        Si es gratuito dejar en blanco
                      </span>
                      --}}
                    </div>
                  </div>
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('url', 'Enlace de la oferta') !!}
                      {!! Form::text('url', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('modalidad', 'Modalidad') !!}
                      {!! Form::select('modalidad', $modalidades, $oferta->exist ? $oferta->modalidad : null, ['placeholder' => 'Sin modalidad', 'class' => 'form-control select2']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">                
                    <div class="form-group">
                      {!! Form::label('pais_id', 'País') !!}
                      {!! Form::select('pais_id', $paises, $oferta->exist ? $oferta->pais_id : null, ['placeholder' => 'Selecciona una País', 'class' => 'form-control selects']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('Departamento', 'Departamento') !!}
                      
                      {!! Form::select('departamento', $departamentos, $oferta->exist ? $oferta->nivel : null, ['placeholder' => 'Selecciona un departamento', 'class' => 'form-control selects', 'id' => 'departamento']) !!}
                      
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('ciudad', 'Ciudad') !!}
                      {!! Form::text('ciudad', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('vacancias_disponibles', 'Vacancias disponibles') !!}
                      {!! Form::text('vacancias_disponibles', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('contacto_con', 'Contacto') !!}
                      {!! Form::text('contacto_con', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="checkbox-inline">
                        {{ Form::checkbox('featured', null, $oferta->exists ? $oferta->featured : false) }}
                        Destacar oferta
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('nivel', 'Nivel') !!}
                      {!! Form::select('nivel', $niveles, $oferta->exist ? $oferta->nivel : null, ['placeholder' => 'Selecciona un nivel', 'class' => 'form-control selects', 'id' => 'nivel']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('tema', 'Tema') !!}
                      {!! Form::select('tema', $temas, $oferta->exist ? $oferta->tema : null, ['placeholder' => 'Selecciona un tema', 'class' => 'form-control selects', 'id' => 'tema']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('tiempo', 'Tiempo') !!}
                      {!! Form::select('tiempo', $tiempo, $oferta->exist ? $oferta->tema : null, ['placeholder' => 'Selecciona un tiempo', 'class' => 'form-control selects', 'id' => 'tiempo']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      {!! Form::label('financiamiento', 'Financiemiento') !!}
                      {!! Form::select('precio', $financiamiento, $oferta->exist ? $oferta->precio : null, ['placeholder' => 'Selecciona un financiamiento', 'class' => 'form-control selects', 'id' => 'financiamiento']) !!}
                    </div>
                  </div>
                  <div class="col-md-12">                
                    <div class="form-group">
                      {!! Form::label('tags', 'Tags') !!}
                      {!! Form::select('tags[]', $tagss, $oferta->exists ? $selected_tags : null, ['class' => 'form-control tags', 'multiple' => 'multiple']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('descripcion', 'Descripción') !!}
                      {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
                      <script>
                      CKEDITOR.replace('descripcion', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height,
                        bodyClass: 'oferta'
                      });
                      </script>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('requisito', 'Requisito') !!}
                      {!! Form::textarea('requisito', null, ['class' => 'form-control']) !!}
                      <script>
                      CKEDITOR.replace('requisito', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height,
                        bodyClass: 'oferta'
                      });
                      </script>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('beneficios', 'Beneficios') !!}
                      {!! Form::textarea('beneficios', null, ['class' => 'form-control']) !!}
                      <script>
                      CKEDITOR.replace('beneficios', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height,
                        bodyClass: 'oferta'
                      });
                      </script>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('proceso_aplicacion', 'Proceso de aplicación') !!}
                      {!! Form::textarea('proceso_aplicacion', null, ['class' => 'form-control']) !!}
                      <script>
                      CKEDITOR.replace('proceso_aplicacion', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height,
                        bodyClass: 'oferta'
                      });
                      </script>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('obs', 'Observaciones') !!}
                      {!! Form::textarea('obs', null, ['class' => 'form-control']) !!}
                      <script>
                      CKEDITOR.replace('obs', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height,
                        bodyClass: 'oferta'
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
                {{ Form::submit($oferta->exists ? 'Guardar oferta' : 'Añadir oferta', ['class' => 'btn btn-primary']) }}
                @if($oferta->id)
                <a href="{{ route('children.index', ['parent_id' => $oferta->id, 'type' => 3]) }}" class="btn btn-primary">
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
<script src="{{ url('assets/plugins/number/jquery.number.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/es.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ url('assets/plugins/select2/select2.full.min.js') }}"></script>
<!-- Page script -->
<style type="text/css">
  .clear-fecha {
    cursor: pointer;
  }
</style>
<script>
$(function() {
  $('.clear-fecha').click(function(){
    $(this).parent('.form-group').find('input').val('');
  })

  $('.select2').select2();

  $('.tags').select2({
    tags: true
  });

  $(".selects").select2({
    tags: true
  });

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

  $('#ofertas-button').addClass('active').find('.treeview-menu').show();
  
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
              'type': 3,
              'parent_id': '{{ $oferta->id ?: null }}',
              'title': '{{ $oferta->title ?: null }}'
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
                  '<a class="fileuploader-action fileuploader-action-retry" title="Reintentar"><i></i></a>'
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