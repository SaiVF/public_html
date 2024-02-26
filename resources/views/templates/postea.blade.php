@extends('layouts.frontend')
@section('head')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="{{ url('css/jquery.tagsinput.css') }}">
<link rel="stylesheet" href="{{ url('assets/plugins/select2/select2.min.css') }}">

@endsection
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
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-left">
              
              <p>¿Conoces de una oportunidad de interés juvenil? ¡Completá el formulario a continuación y se parte de esta red única de instituciones que trabjamos a favor de la juventud!</p>
              <p>Al completar este formulario, estas aceptando los términos en las <a href="{{ url('bases-y-condiciones') }}">bases y condiciones</a> del Portal.</p>
              
              <p>Para iniciar, seleccioná el eje al que corresponde la oportunidad que queres compartir y completá todos los datos.</p>
              <p>Si no estas segur@ de bajo qué categoría incluir la oportunidad o tenes alguna consulta, escribinos a hola@hallate.gov.py</p>
            </div>
          </div>
          @if ($errors->any() OR session()->has('validator'))
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
              <h2>¡Atención!</h2>
          @endif
          
            @if ($errors->any())
              @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
              @endforeach
            @endif
            @if(session()->has('validator'))
            <p>{{ session()->get('validator') }}</p>
            @endif
          @if ($errors->any() OR session()->has('validator'))
            </div>
          </div>
          @endif

          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
              
                {!! Form::model($oferta,[
                'route' => $oferta ? ['oferta.update', $oferta->id] : ['oferta.postear'],
                'class' => 'form-rounded postea-form',
                'files' => true
              ]) !!}
              
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group text-left">
                      <label>Ejes *</label>
                      
                      {!! Form::select('ejes', $ejes, $oferta ? $selected_eje : null, ['class' => 'form-control ejes-select', 'placeholder' => 'Selecciona un eje']) !!}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group text-left">
                      <label>Categorías *</label>
                      @if($oferta)
                      {!! Form::select('category', $categories, $oferta ? $selected_categories : null, ['class' => 'form-control categoria',  'id' => 'categorias', 'disabled' => false, 'placeholder' => 'Selecciona una categoría']) !!}
                      @else
                      {!! Form::select('category', $categories, $oferta ? $selected_categories : null, ['class' => 'form-control categoria',  'id' => 'categorias', 'disabled' => true, 'placeholder' => 'Selecciona una categoría']) !!}
                      @endif
                    </div>
                  </div>
                </div>
                <div class="fields">
                  @include('forms.form')
                </div>
                
              {!! Form::close() !!}
            </div>
          </div>
        </div>
        @else
        <p class="text-center">¿Conoces de una oportunidad de interés juvenil? ¡Contanos y formá parte de esta red única de instituciones que trabajamos a favor de la juventud!</p>
        <p class="text-center">Hacé click <a href="{{ route('micuenta.solicitud') }}" style="text-decoration: underline;">acá</a> para solicitar.</p>
        <p class="text-center">Al ingresar aceptás los <a href="{{ url('bases-y-condiciones') }}" class="button">Bases y Condiciones</a> del Servicio.</p>
        @endif
        @else
        
        <div class="container login-panel">
          <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
              <div class="panel panel-default panel-hallate">
                <div class="panel-heading">
                  <h3><b>Ingresá a Hallate</b></h3>
                  <p>¡Hacelo con tus cuentas de redes sociales<br>y accedé a todos tus servicios!</p>
                </div>
                <div class="panel-body">
                  <a href="{{ url('login/facebook') }}" class="continue-login facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Continuar con Facebook</a>

                  <img src="{{ url('img/line.png') }}" class="line">

                  <a href="{{ url('login') }}" class="continue-login correo">Continuar con mi correo electrónico</a>

                  <a href="{{ url('register') }}" class="button text-center">¿No tenes cuenta?</a>
                  <p>Al ingresar aceptás las <a href="{{ url('bases-y-condiciones') }}" class="button">Bases y condiciones.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div><!-- fin .page-body -->

    </div><!-- fin .page-content -->
  </section>
  <div class="overlay">
  <div class="message"></div>
</div>
@endsection
@section('footer')
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="{{ url('ckeditor/ckeditor.js') }}"></script>
  <script src="{{ url('js/jquery.tagsinput.js') }}"></script>
  <script src="{{ url('assets/plugins/select2/select2.full.min.js') }}"></script>
  <script type="text/javascript">

    $(document).ready(function(){
    	$('form').on('keyup keypress', function(e) {
		  var keyCode = e.keyCode || e.which;
		  if (keyCode === 13) { 
		    e.preventDefault();
		    return false;
		  }
		});
      {{--
        var departamentos = [
          "Varios"
          @foreach($departamentos as $departamento)
          "{{ $departamento->nombre }}",
          @endforeach
          
        ];
        var ciudades = [
          @foreach($ciudades as $ciudad)
          "{{ $ciudad->nombre }}",
          @endforeach
        ]
        --}}
        @if(old('category'))
        $('.tiempo').removeAttr('disabled').select2({tags: true});
        $('.niveles').removeAttr('disabled').select2({tags: true});
        $('.temas').removeAttr('disabled').select2({tags: true});
        $('.financiamiento').removeAttr('disabled').select2({tags: true});
        $('#categorias').removeAttr('disabled');
        $.post('{{ route('ajax.temas') }}', { categoria: '{{ old('category') }}', parent: $('.ejes-select').val() }, function(response) {
          setTimeout(function() {
            $('.overlay .message').html('').hide();
            $('.overlay').fadeOut(250);
            $('.temas').html(response).removeAttr('disabled').val("{{ old('tema') }}").change().select2({tags: true});
          }, 400);
        });
        $.post('{{ route('ajax.niveles') }}', { categoria: '{{ old('category') }}', parent: $('.ejes-select').val() }, function(response) {
          $('.niveles').html(response).removeAttr('disabled').val("{{ old('nivel') }}").change().select2({tags: true});
        });
        $.post('https://www.hallate.gov.py/ajax/tiempo', { categoria: '{{ old('category') }}', parent: $('.ejes-select').val() }, function(response) {
          $('.tiempo').html(response).removeAttr('disabled').val("{{ old('tiempo') }}").change().select2({tags: true});
        });
        $.post('https://www.hallate.gov.py/ajax/financiamiento', { categoria: '{{ old('category') }}', parent: $('.ejes-select').val() }, function(response) {
          $('.financiamiento').html(response).removeAttr('disabled').val("{{ old('financiamiento') }}").change().select2({tags: true});
        });
        @endif
      
      @if($oferta)
      $('.selects').select2({tags:true});
      @endif

      $('#tags').tagsInput({
        'defaultText':''
      });

      $('#pais').change(function(){
        var val = $(this).val();
        console.log(val);
        if (val == 179) {
          $( "#departamento" ).autocomplete({
            source: departamentos
          });
          $( ".ciudades" ).autocomplete({
            source: ciudades
          });
        }
      })
      if ($('#pais').val() == 179) {
        $( "#departamento" ).autocomplete({
          source: departamentos
        });
        $( ".ciudades" ).autocomplete({
          source: ciudades
        });
      }
      $('#departamento').select2({tags: true});
      $('.ciudades').select2({tags: true});


      
      CKEDITOR.replace( 'proceso_aplicacion', {
        width: '100%',
        height: 150
      } );
      CKEDITOR.replace( 'requisito', {
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
      CKEDITOR.editorConfig = function( config ) {
        config.removeButtons = 'image';
      };


      
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
            $('.temas').html(response).removeAttr('disabled').select2({tags: true});
          }, 400);
        });

        $.post('{{ route('ajax.niveles') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          $('.niveles').html(response).removeAttr('disabled').select2({tags: true});
        });

        $.post('{{ route('ajax.tiempo') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          $('.tiempo').html(response).removeAttr('disabled').select2({tags: true});
        });
        $.post('{{ route('ajax.financiamiento') }}', { categoria: $(this).val(), parent: $('.ejes-select').val() }, function(response) {
          $('.financiamiento').html(response).removeAttr('disabled').select2();
        });
        
      })
      

      $(document).on('submit', 'gg', function(){
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
    #tags_tagsinput {
      border-radius: 31px;
      box-shadow: none;
      height: 46px!important;
      min-height: 46px!important;
      padding-left: 20px;
      padding-right: 20px;
      width: 100%!important;
    }
    .bootstrap-tagsinput input {
      width: 100%;
    }
    
    form {
      margin-top: 30px;
    }
    .inner-form {
      position: relative;
    }
    .inner-form .colum-left p {
      font-size: 14px!important;
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
    .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    border-radius: 31px;
    box-shadow: none;
    border-color: #dcddde;
    min-height: 46px;
    padding-left: 20px;
    padding-right: 20px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 44px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}
div.tagsinput span.tag {
    border: 1px solid #f0ad4e;
    background: #f0ad4e;
    color: #fff;
}
div.tagsinput span.tag a {
    font-weight: bold;
    color: #fff;
    text-decoration: none;
    font-size: 11px;
}
.material-switch > input[type="checkbox"] {
    display: none;   
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 0;  
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
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
