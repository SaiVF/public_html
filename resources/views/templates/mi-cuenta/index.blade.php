@extends('layouts.frontend')

@section('content')
  <section class="page post-page">
    <div class="section container">
      <div class="row">
        <div class="col-lg-8">
          <div class="panel panel-default panel-hallate">
            <div class="panel-heading">
              <div class="avatar"></div>
              <h3>¡Hola, {{ Auth::user()->name }}! @if(Auth::user()->verify == 1)<i class="fa fa-star" aria-hidden="true" title="Cuenta verificada"></i>@endif</h3>
              <p><em>Sos miembro desde {{ Auth::user()->created_at }}</em></p>
            </div>
            <div class="panel-body">
              <div class="panel-info">
                <div class="row">
                  <div class="col-lg-6">
                    <p class="title">Nombre y Apellido</p>
                    <h3>{{ Auth::user()->name }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Cédula de Identidad</p>
                    <h3>{{ Auth::user()->ci }}</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <p class="title">Email</p>
                    <h3>{{ Auth::user()->email }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Teléfono</p>
                    <h3>{{ Auth::user()->telefono }}</h3>
                  </div>
                </div>
                <div class="row">
                  @if(Auth::user()->departamento)
                  <div class="col-lg-6">
                    <p class="title">Departamento</p>
                    <h3>{{ Auth::user()->departamentoUser()->nombre }}</h3>
                  </div>
                  @endif
                  <div class="col-lg-6">
                    <p class="title">Ciudad</p>
                    <h3>{{ Auth::user()->ciudad }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Dirección</p>
                    <h3>{{ Auth::user()->direccion }}</h3>
                  </div>
                </div>
                @if(\Auth::user()->isEmpresa())
                <div class="row">
                  <div class="col-lg-12">
                    <hr>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <p class="title">Nombre de la empresa</p>
                    <h3>{{ Auth::user()->empresa }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Descripción</p>
                    <h3>{{ Auth::user()->descripcion_empresa }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Nombre de la autoridad</p>
                    <h3>{{ Auth::user()->trato_autoridad . ' ' . Auth::user()->nombre_autoridad }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Referente</p>
                    <h3>{{ Auth::user()->trato_nexo . ' ' . Auth::user()->nombre_nexo }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title">Telefóno del referente</p>
                    <h3>{{ Auth::user()->telefono_nexo }}</h3>
                  </div>
                  @if(Auth::user()->correo_nexo)
                  <div class="col-lg-6">
                    <p class="title">Correo del referente</p>
                    <h3>{{ Auth::user()->correo_nexo }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->direccion_nexo)
                  <div class="col-lg-6">
                    <p class="title">Dirección física</p>
                    <h3>{{ Auth::user()->direccion_nexo }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->horario_atencion)
                  <div class="col-lg-6">
                    <p class="title">Horario de atención</p>
                    <h3>{{ Auth::user()->horario_atencion }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->dias_atencion)
                  <div class="col-lg-6">
                    <p class="title">Días de atención</p>
                    <h3>{{ Auth::user()->dias_atencion }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->rubro_empresa)
                  <div class="col-lg-6">
                    <p class="title">Rubro de la empresa</p>
                    <h3>{{ Auth::user()->rubro_empresa }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->tipo_oportunidad)
                  <div class="col-lg-6">
                    <p class="title">Tipo de oportunidad</p>
                    <h3>{{ Auth::user()->tipo_oportunidad }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->url)
                  <div class="col-lg-6">
                    <p class="title">Enlace a web o Redes Sociales</p>
                    <h3>{{ Auth::user()->url }}</h3>
                  </div>
                  @endif
                  @if(Auth::user()->logo)
                  <div class="col-lg-12">
                    <p class="title">Logo de la empresa</p>
                    <img src="{{ url('uploads/company/'.Auth::user()->logo) }}" class="img-responsive thumbnail">
                  </div>
                  @endif
                </div>
                @endif

              </div>

                

              <div class="panel-content">
                
              </div>
              
            </div>
            <div class="panel-footer text-right">
              @if(Auth::user()->isEmpresa())
              <a href="{{ route('mi-cuenta.ofertas') }}" class="btn btn-default btn-hallate-default">Ver mis ofertas</a>
              @endif
              <a href="{{ url('mi-cuenta/editar') }}" class="btn btn-default btn-hallate-default">Editar info</a>
            </div>
          </div><!-- fin .panel -->
          <div class="row">
            <div class="col-lg-12 related">
              <h3><i class="fa fa-star" aria-hidden="true"></i> Mis favoritos</h3>
              @if(count($favorites))
              <ul class="">
                @foreach($favorites as $favorite)
                <li><a href="{{ url('oferta/'.$favorite->oferta->id.'/'.str_slug($favorite->oferta->title)) }}">{{ $favorite->oferta->title }}</a></li>
                @endforeach
              </ul>
              @else
              <p>Aún no tienes favoritos</p>
              @endif
            </div>
          </div>
        </div>
        @if(count($ofertas))
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12 other-content" style="margin-top: 0;">
              <div class="">
                <h3 class="text-center">Te puede interesar</h3>
                <ul class="other-list">
                  @foreach($ofertas as $oferta)
                  <li>
                    <div class="">
                      <a href="{{ url('oferta/'.$oferta->id.'/'.str_slug($oferta->title)) }}" class="card-link">
                        <div class="card">
                          <div class="image-container" @if($oferta->theCategory()) style="background-color: {{ $oferta->theColor('fondo') }};" @endif>
                            <div class="image-container-inner">
                            @if($oferta->theCategory())
                            {!! $oferta->theIcon() !!}
                            <p>{{ $oferta->theCategory()->name }}</p>
                            @else
                            
                            @endif
                            </div>
                          </div>
                          <div class="card-body text-center">
                            @if($oferta->theCategory())
                            <span class="category" style="background-color: {{ $oferta->theColor('fondo') }}; color: {{ $oferta->theColor('principal')}}">{{ $oferta->theCategory()->name }}</span>
                            @endif
                            <h4>{{ titleCase(str_limit($oferta->title, 45)) }}</h4>
                            <span class="info">{{ $oferta->excerpt }}</span>
                            <span class="date">
                            @if($oferta->pais)
                            @if($oferta->pais->icon)
                            <img src="{{ url('uploads/'.$oferta->pais->icon) }}" class="icon">
                            @endif
                            @endif 
                            {{ $oferta->lugar }} @if($oferta->fecha_limite)- <i class="fa fa-hourglass-half" aria-hidden="true"></i> {{ $oferta->theDate() }}@endif
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
        </div>
        @endif
      </div>
    </div>

  </section>

@endsection


@section('footer')
<script>
  adjust();
  function initMap() {
  var myLatlng = {
    @if(\Auth::user()->ubicacion)
    lat: {{ \Auth::user()->lat() }},
    lng: {{ \Auth::user()->lng() }}
    @else
    lat: -25.293211,
    lng: -57.550173
    @endif
  };

    var map = new google.maps.Map(document.getElementById('mapa'), {
      zoom: 13,
      center: myLatlng
    });

    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
    });

  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBo7hE6mN0-8W7b9RbhOxiocwYYYvH3JLE&callback=initMap"></script>
@endsection