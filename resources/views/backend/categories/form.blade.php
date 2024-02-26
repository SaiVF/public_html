@extends('layouts.backend')

@section('title', $category->exists ? 'Editando '.$category->title : 'Añadir categoría')

@section('header')
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('assets/plugins/select2/select2.min.css') }}">
<script src="{{ url('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
var contentsCss = ['{{ url('css/bootstrap.css') }}', '{{ url('css/estilos.css') }}'];
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
    <section class="content-header">
      <h1>
        {{ $category->id ? 'Editando '.$category->name : 'Añadir categoría' }} en {{ $type->name }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('backend.categories.index', $type->id) }}">Categorías de {{ $type->name }}</a></li>
        <li class="active">{{ $category->id ? 'Editando '.$category->name : 'Añadir categoría' }}</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          {{ Form::model($category, [
            'route' => $category->exists ? ['backend.categories.update', $category->id] : ['backend.categories.store', $type->id],
            'files' => true
          ]) }}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">{{ $category->id ? 'Editando '.$category->name : 'Añadir categoría' }} en {{ $type->name }}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('name', 'Nombre') !!}
                      {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('parent', 'Categoría superior') !!}
                      {!! Form::select('parent', $parents, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar categoría...']) !!}
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('related_words', 'Palabras relacionadas (Entre comas, ej: Trabajar, estudiar, capacitarme)')}}
                      {{ Form::textarea('related_words', null, ['class' => 'form-control', 'rows' => 2]) }}
                     </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('excerpt', 'Texto')}}
                      {{ Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => 2]) }}
                     </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    {{ Form::label('svg', 'SVG')}}
                    {{ Form::textarea('svg', null, ['class' => 'form-control', 'rows' => 4]) }}
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {{ Form::label('color', 'Color de fondo')}}
                      {{ Form::input('text', 'color', null, array('class' => 'form-control','placeholder' => 'Color de fondo', 'id' => 'exampleInputTitle1')) }}

                     </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      {{ Form::label('color', 'Color principal')}}
                      {{ Form::input('text', 'color_principal', null, array('class' => 'form-control','placeholder' => 'Color principal','id' => 'exampleInputTitle1')) }}

                     </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('content', 'Contenido')}}
                      {{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 2]) }}
                      <script>
                      CKEDITOR.replace('content', {
                        contentsCss: contentsCss,
                        toolbar: toolbar,
                        allowedContent: true,
                        height: height
                      });
                      </script>
                     </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('image', 'Imagen') !!}
                      {!! Form::file('image') !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    @if($category->image)
                      <label>Imagen actual</label>
                      <div class="thumbnail" style="background-color: #f2f2f2;"><img src="{{ url('uploads/'.$category->image) }}"></div>
                      <a href="#" class="deleteImage" data-id="{{ $category->id }}">Eliminar imagen</a>
                    @endif
                    </div>
                  </div>
                </div>
              </div>
              @if(!empty($lang_content) && false)
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Idiomas</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          @php $i = 0 @endphp
                          @foreach($langs as $lang)
                          <li{!! ++$i == 1 ? ' class="active"' : '' !!}><a href="#content_tab_{{ $i }}" data-toggle="tab" class="text-uppercase">{{ $lang }}</a></li>
                          @endforeach
                        </ul>
                        <div class="tab-content">
                          @php $i = 0 @endphp
                          @foreach($langs as $lang)
                          <div class="tab-pane{!! ++$i == 1 ? ' active' : '' !!}" id="content_tab_{{ $i }}">
                            @foreach($lang_content as $key => $value)
                            @if($value->lang == $lang)
                            <div class="form-group">
                              {{ Form::label('lang_content['.$lang.']['.$value->name.']', $value->name == 'name' ? 'Nombre' : ($value->name == 'excerpt' ? 'Extracto' : 'Contenido')) }}
                              {{ Form::textarea('lang_content['.$lang.']['.$value->name.']', $value->value, ['class' => 'form-control', 'rows' => 2]) }}
                            </div>
                            @endif
                            @endforeach
                            <script>
                            CKEDITOR.replace('lang_content[{{ $lang }}][content]', {
                              contentsCss: contentsCss,
                              toolbar: toolbar,
                              allowedContent: true,
                              height: height
                            });
                            </script>
                          </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              <div class="box-footer">
                {{ Form::submit($category->exists ? 'Guardar categoría' : 'Añadir categoría', ['class' => 'btn btn-primary']) }}
              </div>
            </div>
          {{ Form::close() }}
        </div>
      </div>
    </section>
@endsection

@section('footer')
<script>
function triggerType() {
  var optgroup = $('#type').find('option:selected').text();
  $('#parent').find('optgroup').hide();
  $('#parent').find('[label="' + optgroup + '"]').show();
}
$(function () {
  $('#{{ $type->route }}-button').addClass('active').find('.treeview-menu').show();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#type').on('change', function() {
    triggerType();
    $('#parent').prop('selectedIndex', -1);
  });

  triggerType();

  $('.deleteImage').on('click', function() {
    var $this = $(this);
    $.post('{{ url('backend/pages/deleteImage') }}', { id: $this.attr('data-id') }, function(response) {
      $this.parents('.col-md-6').remove();  
    });
    return false;
  });
});
</script>
@endsection