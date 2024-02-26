@extends('layouts.frontend')

@section('title', $post->title)

@section('ogp')
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->title }}" />
<meta property="og:description" content="{{ $post->content ? $post->content : '' }}" />
<meta property="og:image" content="{{ $post->theChildren()->first->src ? $post->theChildren()->first->src : url('img/preview.jpg') }}" />
@endsection

@section('content')
  <section class="page post-page">
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 bc-page">
            <a href="#" class="btn btn-default btn-hallate-default btn-back" onclick="goBack()">Volver</a>
            @if($post->theCategory())
            <ol class="breadcrumb">
              <li><a href="{{ url('/') }}">Inicio</a></li>
              <li><a href="{{ url('buscar?categoria='.$post->theCategory()->id) }}">{{ $post->theCategory()->name }}</a></li>
              <li class="active">{{ $post->title }}</li>
            </ol>
            @else
            <ol class="breadcrumb">
              <li><a href="{{ url('/') }}">Inicio</a></li>
              <li class="active">{{ $post->title }}</li>
            </ol>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="panel panel-default panel-hallate">
            <div class="panel-heading">
              <h3><b>{{ $post->title }}</b></h3>
              <p>{{ $post->excerpt }}</p>
            </div>
            <div class="panel-body">
              <div class="panel-info">
                
                <div class="row">
                  @if($post->lugar_aplicar OR $post->owner)
                  <div class="col-lg-6">
                    <p class="title"><b>Institución oferente</b></p>
                    @if($post->lugar_aplicar)
                    <h3>{{ $post->lugar_aplicar }}</h3>
                    @else
                    @if($post->user)
                    @if($post->anonimo == 1)
                    <h3>Anónimo</h3>
                    @else
                    <h3>{{ $post->user->empresa }}</h3>
                    @endif
                    @endif
                    @endif
                  </div>
                  @endif
                  @if($post->nivel)
                  <div class="col-lg-6">
                    <p class="title"><b>Nivel</b></p>
                    <h3>{{ $post->nivel }}</h3>
                  </div>
                  @endif
                </div>
                <div class="row">
                  @if($post->tema)
                  <div class="col-lg-6">
                    <p class="title"><b>Tema</b></p>
                    <h3>{{ $post->tema }}</h3>
                  </div>
                  @endif
                  @if($post->tiempo)
                  <div class="col-lg-6">
                    <p class="title"><b>Tiempo</b></p>
                    <h3>{{ $post->tiempo }}</h3>
                  </div>
                  @endif
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <p class="title"><b>Financiamiento</b></p>
                    @if($post->precio)
                    <h3>{{ $post->precio }}</h3>
                    @else
                    <h3>Sin costo</h3>
                    @endif
                  </div>
                  @if($post->departamento OR $post->pais_id OR $post->ciudad )
                  <div class="col-lg-6">
                    <p class="title"><b>País/Departamento/Ciudad</b></p>
                    <h3>@if($post->pais){{ $post->pais->nombre }} - @endif{{ $post->departamento }}@if($post->ciudad), {{ $post->ciudad }} @endif</h3>
                  </div>
                  @endif
                 
                </div>
                <div class="row">                
                  @if($post->inicio_aplicacion)
                  <div class="col-lg-6">
                    <p class="title"><b>Fecha de inicio de proceso de aplicación</b></p>
                    <h3>{{ $post->theDateAplicacionInicio() }}</h3>
                  </div>
                  @endif
                  @if($post->cierre_aplicacion)
                  <div class="col-lg-6">
                    <p class="title"><b>Fecha de cierre de proceso de aplicación</b></p>
                    <h3>{{ $post->theDateAplicacionCierre() }}</h3>
                  </div>
                  @endif
                </div>

                <div class="row">
                  @if($post->fecha_inicio)
                  <div class="col-lg-6">
                    <p class="title"><b>Fecha de inicio</b></p>
                    @if($post->fecha_inicio)
                    <h3>{{ $post->theDateInicio() }}</h3>
                    @endif
                  </div>
                  @endif
                  <div class="col-lg-6">
                    <p class="title"><b>Fecha de cierre</b></p>
                    @if($post->fecha_limite)
                    <h3>{{ $post->theDate() }}</h3>
                    @else
                    <h3>Constante</h3>
                    @endif
                  </div>
                  @if($post->contacto)
                  <div class="col-lg-6">
                    <p class="title"><b>Contacto</b></p>
                    <h3>{{ $post->contacto }}</h3>
                  </div>
                  @endif
                </div>
                <div class="row">
                  @if($post->modalidad)
                  <div class="col-lg-6">
                    <p class="title"><b>Modalidad</b></p>
                    <h3>{{ $post->theModalidad() }}</h3>
                  </div>
                  @endif
                  @if($post->vacancias_disponibles)
                  <div class="col-lg-6">
                    <p class="title"><b>Vacancias disponibles</b></p>
                    <h3>{{ $post->vacancias_disponibles }}</h3>
                  </div>
                  @endif
                </div>
                <div class="row">
                  @if($post->contacto_con)
                  <div class="col-lg-6">
                    <p class="title"><b>Contacto</b></p>
                    <h3>{{ $post->contacto_con }}</h3>
                  </div>
                  @endif
                </div>
                
                <hr class="row">
                <div class="row">
                  <div class="col-lg-12 text-right">
                    <div class="post-action-buttons text-right">
                        @if($post->uri_aplicacion)
                    <a href="{{ $post->uri_aplicacion }}" class="btn btn-default btn-hallate-default" target="_blank">Ir al enlace oficial</a>
                    @endif
                    @if($post->url)
                    <a href="{{ $post->url }}" class="btn btn-default btn-hallate-default" target="_blank">Ver oferta</a>
                    @endif
                    @if(Auth::user())
                    @if(!empty($favorite))
                    <a href="#" class="btn btn-default btn-hallate-default meinteresa check" data-id="{{ $post->id }}" title="Ya no me interesa"><i class="fa fa-star" aria-hidden="true"></i> Me interesa</a>
                    @else
                    <a href="#" class="btn btn-default btn-hallate-default meinteresa" data-id="{{ $post->id }}" title="Me interesa"><i class="fa fa-star" aria-hidden="true"></i> Me interesa</a>
                    @endif
                    @else
                    <a href="#" class="btn btn-default btn-hallate-default meinteresa">Me interesa</a>
                    @endif
                  </div>
                  </div>
                </div>
                <hr class="row">
              </div>              
              <div class="panel-content">
              	<p class="title"><small><b>Descripción</b></small></p>
                {!! $post->descripcion !!}
                
                <p class="title"><small><b>Requisitos</b></small></p>
                @if($post->requisito)
                {!! $post->requisito !!}
                @else
                <p><em>No hay requisitos para esta oferta.</em></p>
                @endif
                
                @if($post->proceso_aplicacion)
                <p class="title"><small><b>Proceso de aplicación del programa</b></small></p>
                {!! $post->proceso_aplicacion !!}
                @endif
                @if($post->beneficios)
                <p class="title"><small><b>Beneficios</b></small></p>
                {!! $post->beneficios !!}
                @endif

                @if($post->obs)
                <p class="title"><small><b>Observaciones</b></small></p>
                {!! $post->obs !!}                
                @endif

               @if($post->vancancias_disponibles)
                
                <p class="title"><small>Cupos disponibles</small></p>
                <p>{{ $post->vancancias_disponibles }}</p>
                
                @endif
                
                
              </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="panel-alert">
                      <p>El contenido de este aviso es de propiedad del anunciante. Los requisitos de la posición son definidos y administrados por el anunciante sin que Hallate sea responsable por ello.</p>
                    </div>
                  </div>
                </div>
                
                <br>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="text-center">
                      <p style="color: #9d9fa2;">Compartir en:</p>
                      <div id="share"></div>
                    </div>
                  </div>
                </div>
                
            </div>
            {{--
            <div class="panel-footer text-right">
              <div class="text-right">
                @if($post->uri_aplicacion)
              	<a href="{{ $post->uri_aplicacion }}" class="btn btn-default btn-hallate-default" target="_blank">Ir al enlace oficial</a>
                @endif
              	@if($post->url)
              	<a href="{{ $post->url }}" class="btn btn-default btn-hallate-default" target="_blank">Ver oferta</a>
                @endif
                @if(Auth::user())
                @if(!empty($favorite))
                <a href="#" class="btn btn-default btn-hallate-default meinteresa check" data-id="{{ $post->id }}" disabled><i class="fa fa-star" aria-hidden="true"></i> Me interesa</a>
                @else
                <a href="#" class="btn btn-default btn-hallate-default meinteresa" data-id="{{ $post->id }}"><i class="fa fa-star" aria-hidden="true"></i> Me interesa</a>
                @endif
                @else
                <a href="#" class="btn btn-default btn-hallate-default meinteresa">Me interesa</a>
                @endif
              </div>
            </div>
            --}}
          </div><!-- fin .panel -->
          @if(count($posts))
          <div class="row">
            <div class="col-lg-12 related">
              <h3>Búsquedas relacionadas</h3>
              <ul class="">
                @foreach($posts as $oferta)
                <li><a href="{{ url('oferta/'.$oferta->id.'/'.str_slug($oferta->title)) }}">{{ $oferta->title }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif
        </div>
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12 company">
              <div class="">
                

                @if($post->user)
                @if($post->anonimo == 1)
                <img src="{{ url('img/secretaria-nacional.png') }}" class="img-responsive center-block">
                @else
                @if($post->user->logo)
                <img src="{{ url('uploads/company/'.$post->user->logo) }}" class="img-responsive center-block">
                @else
                <img src="{{ url('img/secretaria-nacional.png') }}" class="img-responsive center-block">
                @endif
                @endif
                @else
                <img src="{{ url('img/secretaria-nacional.png') }}" class="img-responsive center-block">
                @endif
                {{--
                  <img src="{{ url('img/secretaria-nacional.png') }}" class="img-responsive center-block">
                <hr>
                <div class="text-center">
                  <p>Breve info sobre la empresa empleadora.</p>
                </div>
                <div class="text-right">
                  <a href="#">Ver más empleos ofrecidos</a>
                </div>
                --}}
              </div>
            </div>
          </div>
          @if(count($posts))
          <div class="row">
            <div class="col-lg-12 other-content">
              <div class="">
                <h3 class="text-center">Ofertas relacionadas</h3>
                <ul class="other-list">
                  @foreach($posts as $oferta)
                  <li>
                    <div class="">
                      <a href="{{ url('oferta/'.$oferta->id.'/'.str_slug($oferta->title)) }}" class="card-link">
                        <div class="card">
                          <div class="image-container" @if($oferta->theCategory()) style="background-color: {{ $oferta->theColor('fondo') }};" @endif>
                            <div class="image-container-inner">
                            @if($oferta->theCategory())
                            @if($oferta->theCategory()->image)
                            {!! $oferta->theIcon() !!}
                            <p>{{ $oferta->theCategory()->name }}</p>
                            @else
                            
                            @endif
                            @endif
                            </div>
                          </div>
                          <div class="card-body text-center">
                            @if($oferta->theCategory())
                            <span class="category" style="background-color: {{ $oferta->theColor('fondo') }}; color: {{ $oferta->theColor('principal')}}">{{ $oferta->theCategory()->name }}</span>
                            @endif
                            <h4>{{ titleCase(str_limit($oferta->title, 45)) }}</h4>
                            <span class="info">{{ $oferta->lugar_aplicar }}</span>
                            <span class="date">
                            @if($oferta->pais)
                            @if($oferta->pais->icon)
                            <img src="{{ url('uploads/'.$oferta->pais->icon) }}" class="icon">
                            @endif
                            @endif 
                            {{ $oferta->pais ? $oferta->pais->nombre : '' }} @if($oferta->fecha_limite)- <i class="fa fa-hourglass-half" aria-hidden="true"></i> {{ $oferta->theDate() }} @else Constante @endif
                          </span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>

  </section>
@endsection
@section('footer')
<style type="text/css">
  .meinteresa.check, .meinteresa.check:hover, .meinteresa.check:focus {
    background-color: #96979b;
    border-color: #96979b;
  }
  .jssocials-share-link { border-radius: 50%; }
</style>
<script>
$(function() {
  $(".navbar-default .navbar-nav a").click(function(){
    //alert(this.hash);
    if (this.hash) {
      var hreff = '{{ url('') }}/' + this.hash;
      $(location).attr('href',hreff);
    }
  });
  
  $("#share").jsSocials({
      showLabel: false,
      showCount: true,
      shares: ["email", "twitter", "facebook", "whatsapp"]
  });

  $('.meinteresa').on('click', function(e) {
    e.preventDefault();
    $.post('{{ route('ajax.meinteresa') }}', { post: $(this).data('id') }, function(response) {
      if(response == 'null') {
        $('.meinteresa').addClass('check');
      } else if(response == 'login') {
      //  window.location.href = '{{ url('login/') }}';
          $.magnificPopup.open({
            items: {
              type: 'inline',
              src: '#login'
            },

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,
            
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
          });

        return false;
      } else if(response == 'guardado'){
        return false;
      }else if(response == 'delete'){
        $('.meinteresa').removeClass('check');
      }else {

      }

    });
  })
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".navbar-default .navbar-nav a").click(function(){
      //alert(this.hash);
      if (this.hash) {
        var hreff = '{{ url('') }}/' + this.hash;
        $(location).attr('href',hreff);
      }
    });

    
  })
  function goBack() {
        window.history.back();
    }
</script>
@endsection