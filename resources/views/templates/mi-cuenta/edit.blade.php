@extends('layouts.frontend')



@section('content')

  <section class="page mi-cuenta">

    <div class="page-content">

      <div class="page-body">

        <div class="container">

          @if(session()->has('success'))

          <div class="row">

            <div class="col-lg-12">

              <div class="alert alert-warning">{{ session()->get('success') }}</div>

            </div>

          </div>

          @endif

          @if ($errors->any())

          <div class="row">

            <div class="col-lg-12">

                <h2>¡Atención!</h2>

                @foreach ($errors->all() as $error)

                <p>{{ $error }}</p>

                @endforeach

            </div>

          </div>

          @endif

          

          

          @if(Request::get('solicitud') == 'editar')
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-warning">
                Favor completar todos los datos para poder brindarte una mejor experiencia como Colaborador.
              </div>
            </div>
          </div>

          {!! Form::open([

                'route' => 'empresa',

                'class' => 'form-rounded',

                'files' => true

              ]) !!}

          @if(session()->has('editar'))

          <div class="row">

            <div class="col-lg-12">

              <div class="alert alert-warning"><p>{{ session()->get('success') }}</p></div>

            </div>

          </div>

          @endif

          <div class="row">

            <div class="col-lg-12 text-left">

              <h3 class="title"><i class="fa fa-user" aria-hidden="true"></i> Datos personales</h3>

              <div class="row">

                <div class="col-lg-12 text-center">

              

                  <div class="row">

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="name" class="form-control" placeholder="Nombre y Apellido" required value="{{ Auth::user()->name }}">

                      </div>

                    </div>

                    

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="ci" class="form-control" placeholder="CI" required value="{{ Auth::user()->ci }}">

                      </div>

                    </div>



                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="email" class="form-control" placeholder="e-mail" required value="{{ Auth::user()->email }}">

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::select('sexo', $sexo, Auth::user()->sexo ? Auth::user()->sexo : null, ['class' => 'form-control', 'placeholder' => 'Selecciona un sexo']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required value="{{ Auth::user()->telefono }}">

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::select('departamento', $departamentos, Auth::user()->departamento ? Auth::user()->departamento : null, ['class' => 'form-control', 'placeholder' => 'Selecciona una departamento']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="{{ Auth::user()->ciudad }}">

                      </div>

                    </div>



                    <div class="col-lg-12">

                      <div class="form-group">

                        <input type="text" name="direccion" class="form-control" placeholder="Dirección" required value="{{ Auth::user()->direccion ? Auth::user()->direccion : old('direccion') }}">

                      </div>

                    </div>

                  </div>

                  <div class="row">

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="password" name="password" class="form-control" placeholder="Contraseña">

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="password" name="password_confirmation" class="form-control" placeholder="Contraseña">

                      </div>

                    </div>

                  </div>

                  

                  

              </div>

              </div>

            </div>

            

          </div>

          <!-- Datos de la empresa -->

          <div class="row">

            <div class="col-lg-12">

              <h3 class="title"><i class="fa fa-briefcase" aria-hidden="true"></i> Datos de la empresa</h3>



              <div class="row">

                <div class="col-lg-4">

                  @if(Auth::user()->logo)

                  <img src="{{ url('uploads/company/'.Auth::user()->logo) }}" class="img-responsive center-block">

                  @else

                  <p>No hay logo</p>

                  @endif

                </div>

                <div class="col-lg-8">

                  <div class="row">

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('empresa', Auth::user()->empresa ? Auth::user()->empresa : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre de la institución *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('descripcion_empresa', Auth::user()->descripcion_empresa ? Auth::user()->descripcion_empresa : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Breve descripción de la institución *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('url', Auth::user()->url ? Auth::user()->url : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enlace a página web o de redes sociales. En caso de no tener una, poner no aplica. *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('trato_autoridad', Auth::user()->trato_autoridad ? Auth::user()->trato_autoridad : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Título de la autoridad. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva', 'title' => 'Título de la autoridad. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('nombre_autoridad', Auth::user()->nombre_autoridad ? Auth::user()->nombre_autoridad : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre completo de la autoridad principal *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        

                        {!! Form::text('trato_nexo', Auth::user()->trato_nexo ? Auth::user()->trato_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva', 'title' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('nombre_nexo', Auth::user()->nombre_nexo ? Auth::user()->nombre_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre completo del referente o nexo con el portal *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('telefono_nexo', Auth::user()->telefono_nexo ? Auth::user()->telefono_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Teléfono de contacto con el o la referente *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('correo_nexo', Auth::user()->correo_nexo ? Auth::user()->correo_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Correo electrónico de contacto con el o la referente *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('direccion_nexo', Auth::user()->direccion_nexo ? Auth::user()->direccion_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Dirección física de la institución *']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('dias_atencion', Auth::user()->dias_atencion ? Auth::user()->dias_atencion : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Días de atención']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('horario_atencion', Auth::user()->horario_atencion ? Auth::user()->horario_atencion : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Horario de atención']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('rubro_empresa', Auth::user()->rubro_empresa ? Auth::user()->rubro_empresa : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Rubro de la empresa']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('tipo_oportunidad', Auth::user()->tipo_oportunidad ? Auth::user()->tipo_oportunidad : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Contanos qué tipo de oportunidad queres ofrecer a los jóvenes (becas, oportunidades laborales, pasantías) *']) !!}

                      </div>

                    </div>



                    <div class="col-lg-12">

                      <div class="form-group">

                        <input type="file" name="logo" id="logo" class="form-control" placeholder="Seleccionar archivo de logotipo">
                        <span class="help-block">Seleccionar archivo de logotipo</span>

                        <span class="help-block">La extensión del archivo debe ser: jpg o png. El tamaño del archivo debe ser menor a 200KB</span>

                      </div>

                    </div>

                  </div>

                </div>

              

                

              </div>



            </div>

          </div><!-- fin datos de la empresa -->

          <div class="row">

            <div class="col-lg-12 text-left">

              <div class="form-group">

                <label for="terminos">

                  <input type="checkbox" name="terminos" id="terminos" {{ \Auth::user()->terminos == 1 ? 'checked' : '' }}>

                  Acepto las bases y condiciones <small>(<a href="{{ url('bases-y-condiciones') }}">Leer las bases y condiciones</a>)</small>

                </label>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-lg-12 text-right">

              <div class="form-group action">

                <button class="btn btn-default btn-hallate-default">Aceptar</button>

              </div>

            </div>

          </div>

          {!! Form::close() !!}

          @else
          
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-warning">
                Favor completar todos los datos para poder brindarte una mejor experiencia como Usuario.
              </div>
            </div>
          </div>

          {!! Form::open([

                'route' => 'preferencias',

                'class' => 'form-rounded',

                'files' => true

              ]) !!}

          <div class="row">

            <div class="col-lg-12 text-left">

              <h3 class="title"><i class="fa fa-user" aria-hidden="true"></i> Datos personales</h3>

              <div class="row">

                <div class="col-lg-12 text-center">

              

                  <div class="row">

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="name" class="form-control" placeholder="Nombre y Apellido" required value="{{ Auth::user()->name }}">

                      </div>

                    </div>



                    



                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="ci" class="form-control" placeholder="CI" required value="{{ Auth::user()->ci }}">

                      </div>

                    </div>



                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="email" class="form-control" placeholder="e-mail" required value="{{ Auth::user()->email }}" autocomplete="off">

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::select('sexo', $sexo, Auth::user()->sexo ? Auth::user()->sexo : null, ['class' => 'form-control', 'placeholder' => 'Selecciona un sexo']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required value="{{ Auth::user()->telefono }}">

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::select('departamento', $departamentos, Auth::user()->departamento ? Auth::user()->departamento : null, ['class' => 'form-control', 'placeholder' => 'Selecciona una departamento']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="{{ Auth::user()->ciudad }}">

                      </div>

                    </div>



                    <div class="col-lg-12">

                      <div class="form-group">

                        <input type="text" name="direccion" class="form-control" placeholder="Dirección" required value="{{ Auth::user()->direccion ? Auth::user()->direccion : old('direccion') }}">

                      </div>

                    </div>

                  </div>

                  <div class="row">

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="password" name="password" class="form-control" placeholder="Contraseña">

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        <input type="password" name="password_confirmation" class="form-control" placeholder="Contraseña">

                      </div>

                    </div>

                  </div>

                  {{--

                  <div class="row">

                    <div class="col-lg-12">

                      <div class="form-group text-left">

                        <label>Croquis de tu domicilio (arrastrá el marcador hasta la posición exacta)</label>

                        <input type="hidden" name="ubicacion" id="ubicacion" value="{{ \Auth::user()->ubicacion }}">

                        <div class="map-container">

                          <div id="mapa"></div>

                        </div>

                      </div>

                    </div>

                  </div>

                  --}}

                  <div class="row">

                    <div class="col-lg-12 text-left">

                      <div class="form-group">

                        <label for="terminos">

                          <input type="checkbox" name="terminos" id="terminos" {{ \Auth::user()->terminos == 1 ? 'checked' : '' }}>

                          Acepto las bases y condiciones <small>(<a href="{{ url('bases-y-condiciones') }}">Leer las bases y condiciones</a>)</small>

                        </label>

                      </div>

                    </div>

                  </div>

              </div>

              </div>

            </div>

            

          </div>

          @if(\Auth::user()->isEmpresa())

          <!-- Datos de la empresa -->

          <div class="row">

            <div class="col-lg-12">

              <h3 class="title"><i class="fa fa-briefcase" aria-hidden="true"></i> Datos de la empresa</h3>



              <div class="row">

                <div class="col-lg-4">

                  @if(Auth::user()->logo)

                  <img src="{{ url('uploads/company/'.Auth::user()->logo) }}" class="img-responsive center-block">

                  @else

                  <p>No hay logo</p>

                  @endif

                </div>

                <div class="col-lg-8">

                  <div class="row">

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('empresa', Auth::user()->empresa ? Auth::user()->empresa : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre de la institución']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        

                        {!! Form::text('descripcion_empresa', Auth::user()->descripcion_empresa ? Auth::user()->descripcion_empresa : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Breve descripción de la institución']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('url', Auth::user()->url ? Auth::user()->url : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enlace a página web o de redes sociales']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('trato_autoridad', Auth::user()->trato_autoridad ? Auth::user()->trato_autoridad : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva', 'title' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('nombre_autoridad', Auth::user()->nombre_autoridad ? Auth::user()->nombre_autoridad : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre completo de la autoridad principal']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        

                        {!! Form::text('trato_nexo', Auth::user()->trato_nexo ? Auth::user()->trato_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva', 'title' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('nombre_nexo', Auth::user()->nombre_nexo ? Auth::user()->nombre_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre completo del referente o nexo con el portal']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('telefono_nexo', Auth::user()->telefono_nexo ? Auth::user()->telefono_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Teléfono de contacto con el o la referente']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('correo_nexo', Auth::user()->correo_nexo ? Auth::user()->correo_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Correo electrónico de contacto con el o la referente']) !!}

                      </div>

                    </div>

                    <div class="col-lg-12">

                      <div class="form-group">

                        {!! Form::text('direccion_nexo', Auth::user()->direccion_nexo ? Auth::user()->direccion_nexo : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Dirección física de la institución']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('dias_atencion', Auth::user()->dias_atencion ? Auth::user()->dias_atencion : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Días de atención']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('horario_atencion', Auth::user()->horario_atencion ? Auth::user()->horario_atencion : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Horario de atención']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('rubro_empresa', Auth::user()->rubro_empresa ? Auth::user()->rubro_empresa : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Rubro de la empresa']) !!}

                      </div>

                    </div>

                    <div class="col-lg-6">

                      <div class="form-group">

                        {!! Form::text('tipo_oportunidad', Auth::user()->tipo_oportunidad ? Auth::user()->tipo_oportunidad : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Contanos qué tipo de oportunidad queres ofrecer a los jóvenes (becas, oportunidades laborales, pasantías)']) !!}

                      </div>

                    </div>



                    <div class="col-lg-12">

                      <div class="form-group">

                        <input type="file" name="logo" id="logo" class="form-control" placeholder="Seleccionar archivo de logotipo">
                        <span class="help-block">Seleccionar archivo de logotipo</span>

                        <span class="help-block">La extensión del archivo debe ser: jpg o png. El tamaño del archivo debe ser menor a 200KB</span>

                      </div>

                    </div>

                  </div>

                </div>

              

                

              </div>



            </div>

          </div><!-- fin datos de la empresa -->

          @endif

          <div class="row">

            <div class="col-lg-12 text-right">

              <div class="form-group action">

                

                <button class="btn btn-default btn-hallate-default">Actualizar datos</button>

              </div>

            </div>

          </div>

          {!! Form::close() !!}

          @endif

        </div>

      </div><!-- fin .page-body -->



    </div><!-- fin .page-content -->

  </section>



@endsection



@section('footer')

<script>

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



    map.addListener('click', function(e) {

      marker.setPosition(e.latLng);

      $('#ubicacion').val(e.latLng.lat() + ',' + e.latLng.lng());

    });



  }



  $(document).ready(function(){

    $(".navbar-default .navbar-nav a").click(function(){

      //alert(this.hash);

      if (this.hash) {

        var hreff = '{{ url('') }}/' + this.hash;

        $(location).attr('href',hreff);

      }

    });

  })

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBo7hE6mN0-8W7b9RbhOxiocwYYYvH3JLE&callback=initMap"></script>

@endsection