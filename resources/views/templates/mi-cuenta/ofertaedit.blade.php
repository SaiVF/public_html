@extends('layouts.frontend')
@section('content')
  <section class="page">
    {{--
    <div class="page-banner banner-mini" style="background-image: url('img/contacto.jpg');">
      <div class="container inner-page-banner">
        <div class="row">
          <div class="col-lg-12 text-center">
            
            <h3>¿Tenés dudas o consultas?</h3>
            <h1>¡Contactanos!</h1>
            
          </div>
        </div>
      </div>
    </div>
    --}}
    
    <div class="page-content">
      <div class="page-body">
        @if(Auth::check())
        @if(Auth::user()->isEmpresa() OR Auth::user()->isAdmin())

        @if(session()->has('success'))
        <div class="container">
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
              <div class="alert alert-success">{{ session()->get('success') }}</div>
            </div>
          </div>
        </div>
        @endif

        

        <div class="container">
          {{--
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-left">
              <p>¿Conoces de una oportunidad de interés juvenil? ¡Completá el formulario a continuación y se parte de esta red única de instituciones que trabjamos a favor de la juventud!</p>
              <p>Al completar este formulario, estas aceptando los términos en las bases y condiciones del Portal.</p>
              <p>Para iniciar, seleccioná el eje al que corresponde la oportunidad que queres compartir:</p>
            </div>
          </div>
          --}}
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-left">
              <h2>Editando: {{ $oferta->title }}</h2>
            </div>
          </div>
          @if ($errors->any())
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
                <h2>¡Atención!</h2>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
          </div>
          @endif

          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
              
                {!! Form::open([
                'route' => ['mi-cuenta.ofertas.editar', 'id' => $oferta->id],
                'class' => 'form-rounded postea-form',
                'files' => true
              ]) !!}
              
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group text-left">
                      <label>Ejes</label>
                      <select class="form-control ejes-select" data-eje='{{ $oferta->theCategory()->parent }}'>
                        <option value="" selected disabled>Selecciona un eje</option>
                        @foreach($ejes as $eje)
                        <option value="{{ $eje->id }}" {{ $eje->id == $oferta->theCategory()->parent ? 'selected' : '' }}>{{ $eje->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group text-left">
                      <label>Categorías</label>
                      <select class="form-control" class="categoria" id="categorias" name="category">
                        <option value="" selected disabled>Selecciona una categoría</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $oferta->theCategory()->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="fields">
                  <div class="inner-form">
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Titulo de la Oportunidad <span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="title" class="form-control" value="{{ old('title') ? old('title') : $oferta->title }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Institución Oferente <span class="required">*</span></label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="empresa" class="form-control" value="{{ Auth::user()->name }}" readonly>
                      </div>
                    </div>
                    {{--
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Imagen</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="file" name="imagen" class="form-control">
                      </div>
                    </div>
                    --}}
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Nivel</label>
                      </div>
                      <div class="col-lg-9">
                        <div class="row">
                          <div class="col-lg-6">
                            <select class="form-control niveles" name="nivel" disabled>
                              <option value="" disabled selected>-----</option>
                            </select>
                            
                          </div>
                          <div class="col-lg-6">
                            <input type="text" name="nivel_alt" placeholder="Otro:" class="form-control" value="{{ old('nivel_alt') ? old('nivel_alt') : $oferta->nivel }}">
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Tema</label>
                      </div>
                      <div class="col-lg-9">
                        <div class="row">
                          <div class="col-lg-6">
                            <select class="form-control temas" name="tema" disabled>
                              <option value="" disabled selected>-----</option>
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <div class="">
                              <input type="text" name="tema_alt" class="form-control" placeholder="Otro:" value="{{ old('tema_alt') ? old('tema_alt') : $oferta->tema }}">
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Tiempo<label>
                      </div>
                      <div class="col-lg-9">
                        <div class="row">
                          <div class="col-lg-6">
                            <select class="form-control tiempo" name="tiempo" id="tiempo" disabled>
                              <option value="" disabled selected>-----</option>
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <div class="">
                              <input type="text" name="tiempo_alt" class="form-control" placeholder="Otro:" value="{{ old('tempo_alt') ? old('tempo_alt') : $oferta->tiempo }}">
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Cupos disponibles</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="vacancias" class="form-control" value="{{ old('vacancias') ? old('vacancias') : $oferta->vacancias_disponibles }}">
                      </div>
                    </div>
                    
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Descripción</label>
                        <p><em>Breve descripción de la oportunidad</em></p>
                      </div>
                      <div class="col-lg-9">
                        <textarea name="descripcion" class="form-control text" rows="4">
                          {{ old('descripcion') ? old('descripcion') : $oferta->descripcion }}
                        </textarea>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Beneficios</label>
                        <p><em>Favor describa cómo se beneficiará un joven con esta oportunidad</em></p>
                      </div>
                      <div class="col-lg-9">
                        <textarea name="beneficios" id="beneficios" class="form-control beneficios" rows="4">
                          {{ old('beneficios') ? old('beneficios') : $oferta->beneficios }}
                        </textarea>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Financiamiento</label>
                      </div>
                      <div class="col-lg-9">
                        <div class="row">
                          <div class="col-lg-6">
                            <select class="form-control financiamiento" name="financiamiento" id="financiamiento" disabled>
                              <option value="" disabled selected>-----</option>
                              
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <div class="">
                              <input type="text" name="financiamiento_alt" class="form-control" placeholder="Otro:" value="{{ old('financiamiento_alt') ? old('financiamiento_alt') : $oferta->precio }}">
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Fecha de inicio de la oportunidad</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') ? old('fecha_inicio') : $oferta->fecha_inicio }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Fecha de cierre de la oportunidad</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="date" name="fecha_cierre" class="form-control" value="{{ old('fecha_cierre') ? old('fecha_cierre') : $oferta->fecha_limite }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>La oferta se desarrolla en</label>
                      </div>
                      <div class="col-lg-9">
                        <div class="row">
                          <div class="col-lg-4">
                            <select class="form-control" name="pais">
                              @foreach($paises as $pais)
                              <option value="{{ $pais->id }}" {{ $pais->id == $oferta->pais_id ? 'selected' : '' }}>{{ $pais->nombre }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-lg-4">
                            <input type="text" name="departamento" placeholder="Departamento o Estado" class="form-control" value="{{ old('departamento') ? old('departamento') : $oferta->departamento }}">
                          </div>
                          <div class="col-lg-4">
                            <input type="text" name="ciudad" placeholder="Ciudad" class="form-control" value="{{ old('ciudad') ? old('ciudad') : $oferta->ciudad }}">
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Enlace oficial del programa</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="url" class="form-control" value="{{ old('url') ? old('url') : $oferta->url }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Proceso de aplicación del programa <span class="required">*</span></label>
                        <p><em>Favor describa cómo aplicar a esta oportunidad</em></p>
                      </div>
                      <div class="col-lg-9">
                        <textarea name="proceso_aplicacion" id="proceso_aplicacion" class="form-control proceso_aplicacion">
                          {{ old('proceso_aplicacion') ? old('proceso_aplicacion') : $oferta->proceso_aplicacion }}
                        </textarea>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Fecha de inicio de proceso de aplicación</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="date" name="inicio_aplicacion" class="form-control" value="{{ old('inicio_aplicacion') ? old('inicio_aplicacion') : $oferta->inicio_aplicacion }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Fecha de cierre de proceso de aplicación</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="date" name="cierre_aplicacion" class="form-control" value="{{ old('cierre_aplicacion') ? old('cierre_aplicacion') : $oferta->cierre_aplicacion }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Requisitos</label>
                        <p><em>Favor describir los requisitos a cumplir para acceder a la oportunidad</em></p>
                      </div>
                      <div class="col-lg-9">
                        <textarea name="requisitos" id="requisitos" class="form-control requisitos" rows="4">
                          {{ old('requisitos') ? old('requisitos') : $oferta->requisito }}
                        </textarea>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Enlace oficial para aplicar</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="uri_aplicacion" class="form-control" value="{{ old('uri_aplicacion') ? old('uri_aplicacion') : $oferta->uri_aplicacion }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>En caso de consultas contactar con</label>
                      </div>
                      <div class="col-lg-9">
                        <input type="text" name="contacto" class="form-control" value="{{ old('contacto') ? old('contacto') : $oferta->contacto_con }}">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-3 text-left colum-left">
                        <label>Postear como anónimo</label>
                      </div>
                      <div class="col-lg-9">
                        
                        {{ Form::checkbox('anonimo', $oferta->anonimo, $oferta->anonimo, ['class' => 'form-control']) }}
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-lg-12 text-left">
                      <a href="{{ url('bases-y-condiciones') }}">Bases y condiciones</a>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-lg-12 text-left">
                      <div class="form-group">
                        <button class="btn btn-default btn-hallate-default" id="form-send" type="submit">Actualizar oportunidad</button>
                      </div>
                    </div>
                  </div>

                </div>
                
              {!! Form::close() !!}
            </div>
          </div>
        </div>
        @else
        <p class="text-center">¿Conoces de una oportunidad de interés juvenil? ¡Contanos y formá parte de esta red única de instituciones que trabajamos a favor de la juventud!</p>
        <p class="text-center">Hacé click <a href="{{ route('micuenta.solicitud') }}" style="text-decoration: underline;">acá</a> para solicitar.</p>
        @endif
        @else
        
        
        @endif
      </div><!-- fin .page-body -->

    </div><!-- fin .page-content -->
  </section>
  <div class="overlay">
  <div class="message"></div>
</div>
@endsection
  @section('footer')

  <script src="{{ url('ckeditor/ckeditor.js') }}"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('.select2').select2({
        placeholder: "",
      });
      $('select').focus(function(){
        $(this).css('color', '#555');
      })
      CKEDITOR.replace( 'proceso_aplicacion', {
        width: '100%',
        height: 150
      } );
      CKEDITOR.replace( 'requisitos', {
        width: '100%',
        height: 150
      } );
      CKEDITOR.replace( 'descripcion', {
        width: '100%',
        height: 150
      } );
      CKEDITOR.replace( 'beneficios', {
        width: '100%',
        height: 150
      } );

      
      $('.ejes-select').change(function() {
        $('.overlay').fadeIn(250);
        $('.overlay .message').html('Cargando...').fadeIn(250);
        $('.niveles').attr('disabled', 'disabled');
        $('.temas').attr('disabled', 'disabled');
        $('.tiempo').attr('disabled', 'disabled');
        $('.financiamiento').attr('disabled', 'disabled');
        $.post('{{ route('ajax.categoria') }}', { eje: $(this).val() }, function(response) {
          $('#categorias').html(response).removeAttr('disabled');
          setTimeout(function() {
            $('.overlay .message').html('').hide();
            $('.overlay').fadeOut(250);
          }, 400);
        });
      })

      $('#categorias').change(function() {
        $('.overlay').fadeIn(250);
        $('.overlay .message').html('Cargando...').fadeIn(250);
        $.post('{{ route('ajax.temas') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          setTimeout(function() {
            $('.overlay .message').html('').hide();
            $('.overlay').fadeOut(250);
            $('.temas').html(response).removeAttr('disabled');
          }, 400);
        });

        $.post('{{ route('ajax.niveles') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          $('.niveles').html(response).removeAttr('disabled');
        });

        $.post('{{ route('ajax.tiempo') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          $('.tiempo').html(response).removeAttr('disabled');
        });
        $.post('{{ route('ajax.financiamiento') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          $('.financiamiento').html(response).removeAttr('disabled');
        });
        
      })
      

      $(document).on('submit', 'df', function(){
        console.log($(this).attr('action'));
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "html",
            beforeSend: function(response){
              $('.overlay').fadeIn(250);
              $('.overlay .message').html('Cargando...').fadeIn(250);
              console.log('beforeSend');
            },
            ajaxSend: function(response){
              $('.overlay').fadeIn(250);
              $('.overlay .message').html('Cargando...').fadeIn(250, function(response) {
                  setTimeout(function() {
                    $('.overlay .message').html('').hide();
                    $('.overlay').fadeOut(250);
                  }, 1500);
              });
              console.log('ajaxSend');
            },
            error: function(response){
              $('.overlay .message').html(response.errors).fadeIn(250, function(response) {
                  
              });

              console.log(response.errors);
            },
            success: function(response){

              /*$('.overlay .message').html(response.text).fadeIn(250, function(response) {
                  setTimeout(function() {
                    $('.overlay .message').html('').hide();
                    $('.overlay').fadeOut(450);
                  }, 1500);
              });*/
              setTimeout(function() {

                $('.overlay .message').html('<p>¡Hemos registrado tu oferta!</p>').hide();
                $('.overlay').hide();
              }, 600);
              $this[0].reset();
            }
        });//fin ajax send
        return false;
      })

    })
  </script>
  <style type="text/css">
  
    .select2-container--default .select2-selection--multiple {
        background-color: #dcddde;
        border: 1px solid #aaa;
        border-radius: 30px;
        cursor: text;
    }
    .select2-container--default .select2-selection--multiple {
        background-color: #dcddde;
        border: 1px solid #dcddde;
        border-radius: 30px;
        cursor: text;
    }
    .select2-container .select2-selection--multiple {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        min-height: 34px;
        user-select: none;
        -webkit-user-select: none;
    }
    .select2-container .select2-search--inline .select2-search__field {
        box-sizing: border-box;
        border: none;
        font-size: 100%;
        margin-top: 7px;
        padding: 0;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        box-sizing: border-box;
        list-style: none;
        margin: 0;
        padding: 6px 12px;
        width: 100%;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: solid #dcddde 1px;
        outline: 0;
    }
    .select2-container .select2-search--inline .select2-search__field {
      padding-left: 7px;
    }
    form {
      margin-top: 30px;
    }
    .inner-form {
      position: relative;
    }
    .colum-left {
      padding-left: 40px;
    }
    .inner-form:after {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      right: 75%;
      bottom: 0;
      background-color: #f2f2f2;
      z-index: -1;
    }
    input.form-control, select.form-control {
      background-color: #fff !important;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: #eee!important;
        opacity: 1;
    }
  </style>
  <style type="text/css"> 
.overlay {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1000;
    opacity: 1;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .5);
}
.overlay .message {
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 200px;
    background-color: #ffcc32;
    padding: 1em;
    margin: auto;
    display: inline-block;
    color: #fff;
    display: none;
    border-radius: 30px;
}
</style>
  @endsection
