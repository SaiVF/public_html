@extends('layouts.frontend')

@section('content')
  <section class="page post-page">
    <div class="section container">
      <div class="row">
        <div class="col-lg-12">
          <a href="index.php" class="btn btn-default btn-hallate-default">Volver</a>
        </div>
      </div>
    </div>
    <div class="section container">
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
                  <div class="col-lg-6">
                    <p class="title"><b>Lugar de trabajo</b></p>
                    <h3>{{ $post->lugar }}</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title"><b>Publicado</b></p>
                    <h3>{{ $post->theDate() }}</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <p class="title"><b>Salario</b></p>
                    <h3>No especificado</h3>
                  </div>
                  <div class="col-lg-6">
                    <p class="title"><b>Tipo de puesto</b></p>
                    <h3>Full-time</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <p class="title"><b>Área</b></p>
                    <h3>Comercial</h3>
                  </div>
                </div>
                <hr class="row">

                <p class="title"><small><b>Descripción</b></small></p>
              </div>

                

              <div class="panel-content">
                {!! $post->content !!}
              </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="panel-alert">
                      <p>El contenido de este aviso es de propiedad del anunciante. Los requisitos de la posición son definidos y administrados por el anunciante sin que Hallate sea responsable por ello.</p>
                    </div>
                  </div>
                </div>
              
            </div>
            <div class="panel-footer text-right">
              <a href="#" class="btn btn-default btn-hallate-default">Me interesa</a>
            </div>
          </div><!-- fin .panel -->
          <div class="row">
            <div class="col-lg-12 related">
              <h3>Búsqueda relacionadas</h3>
              <ul class="">
                @if($posts)
                @foreach($posts as $oferta)
                <li><a href="#">{{ $oferta->title }}</a></li>
                @endforeach
                @endif
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12 company">
              <div class="">
                <img src="img/secretaria-nacional.png" class="img-responsive center-block">
                <hr>
                <div class="text-center">
                  <p>Breve info sobre la empresa empleadora.</p>
                </div>
                <div class="text-right">
                  <a href="#">Ver más empleos ofrecidos</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 other-content">
              <div class="">
                <h2 class="text-center">Empleos relacionados</h2>
                <ul class="other-list">
                  <li>
                    <div class="">
                      <a href="#!" class="card-link">
                        <div class="card">
                          <div class="image-container">
                            <img src="img/capacitarme.png">
                            <p>CURSOS DISPONIBLES</p>
                          </div>
                          <div class="card-body text-center">
                            <span class="category">Capacitarme</span>
                            <h4>COCINERO</h4>
                            <span class="info">MTESS - SERVICIO NACIONAL DE PROMOCION PROFESIONAL</span>
                            <span class="date">CAPITAN &nbsp; &nbsp; EN EL PAÍS - 10/02/2018</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </li>
                  <li>
                    <div class="">
                      <a href="#!" class="card-link">
                        <div class="card">
                          <div class="image-container">
                            <img src="img/capacitarme.png">
                            <p>CURSOS DISPONIBLES</p>
                          </div>
                          <div class="card-body text-center">
                            <span class="category">Capacitarme</span>
                            <h4>COCINERO</h4>
                            <span class="info">MTESS - SERVICIO NACIONAL DE PROMOCION PROFESIONAL</span>
                            <span class="date">CAPITAN &nbsp; &nbsp; EN EL PAÍS - 10/02/2018</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </li>
                  <li>
                    <div class="">
                      <a href="#!" class="card-link">
                        <div class="card">
                          <div class="image-container">
                            <img src="img/capacitarme.png">
                            <p>CURSOS DISPONIBLES</p>
                          </div>
                          <div class="card-body text-center">
                            <span class="category">Capacitarme</span>
                            <h4>COCINERO</h4>
                            <span class="info">MTESS - SERVICIO NACIONAL DE PROMOCION PROFESIONAL</span>
                            <span class="date">CAPITAN &nbsp; &nbsp; EN EL PAÍS - 10/02/2018</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </li>
                  <li>
                    <div class="">
                      <a href="#!" class="card-link">
                        <div class="card">
                          <div class="image-container">
                            <img src="img/capacitarme.png">
                            <p>CURSOS DISPONIBLES</p>
                          </div>
                          <div class="card-body text-center">
                            <span class="category">Capacitarme</span>
                            <h4>COCINERO</h4>
                            <span class="info">MTESS - SERVICIO NACIONAL DE PROMOCION PROFESIONAL</span>
                            <span class="date">CAPITAN &nbsp; &nbsp; EN EL PAÍS - 10/02/2018</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection