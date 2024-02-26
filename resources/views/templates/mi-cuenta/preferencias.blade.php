@extends('layouts.frontend')

@section('content')
<section class="breadcrumb">
  <div class="container">
    <p>Hola {{ Auth::user()->name }}!</p>
    <p><a href="{{ url('/') }}">Inicio</a> / Preferencias</p>
  </div>
</section>
<section class="mi-cuenta">
  <div class="container">
    <div class="sidebar">
      @include('templates.mi-cuenta.sidebar')
    </div>
    <div class="main-content">
      <h2>Preferencias de la cuenta</h2>
      @if(session()->has('success'))
      <div class="alert" style="margin: 0 auto 20px">{{ session()->get('success') }}</div>
      @endif
      <h3>Datos de la cuenta</h3>
      {!! Form::open([
        'route' => 'preferencias'
      ]) !!}
        <ul class="grid grid-2">
          <li>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="* Nombre y apellido" required>
          </li>
          <li>
            <input type="text" name="ci" class="form-control" placeholder="* Cédula de identidad / Pasaporte" value="{{ Auth::user()->ci }}">
          </li>
          <li>
            <input type="text" name="empresa" class="form-control" placeholder="Empresa" value="{{ Auth::user()->empresa }}">
          </li>
          <li>
            <input type="text" name="ruc" class="form-control" placeholder="RUC" value="{{ Auth::user()->ruc }}">
          </li>
          <li>
            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="* Email" required>
          </li>
          <li>
            <input type="text" name="telefono" class="form-control" placeholder="* Teléfono" required value="{{ Auth::user()->telefono }}">
          </li>
          <li>
            <input type="text" name="direccion" class="form-control" placeholder="* Dirección" required value="{{ Auth::user()->direccion }}">
          </li>
          <li>
            <input type="text" name="ciudad" class="form-control" placeholder="* Ciudad" required value="{{ Auth::user()->ciudad }}">
          </li>
          <li>
            <input type="text" name="referencias" class="form-control" placeholder="* Referencias domicilio" value="{{ Auth::user()->referencias }}">
          </li>
        </ul>
        <ul class="grid grid-2">
          <li>
            <input type="password" name="password" class="form-control" placeholder="Contraseña">
          </li>
          <li>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Repetir contraseña">
          </li>
        </ul>
        <ul class="grid grid-2">
          <li>
            <input type="text" name="sucursal" class="form-control" placeholder="* Sucursal" required value="{{ Auth::user()->sucursal }}">
          </li>
          <li>
            <input type="text" name="vendedor" class="form-control" placeholder="* Vendedor" required value="{{ Auth::user()->vendedor }}">
          </li>
        </ul>
        <ul class="grid grid-2">
          <li>
            <input type="text" name="persona_1" class="form-control" placeholder="* Persona autorizada 1" required value="{{ Auth::user()->persona_1 }}">
          </li>
          <li>
            <input type="text" name="ci_1" class="form-control" placeholder="* C. I. Persona autorizada 1" required value="{{ Auth::user()->ci_1 }}">
          </li>
          <li>
            <input type="text" name="persona_2" class="form-control" placeholder="* Persona autorizada 2" required value="{{ Auth::user()->persona_2 }}">
          </li>
          <li>
            <input type="text" name="ci_2" class="form-control" placeholder="* C. I. Persona autorizada 2" required value="{{ Auth::user()->ci_2 }}">
          </li>
        </ul>
        <div class="form-group">
          <label>Croquis de tu domicilio (arrastrá el marcador hasta la posición exacta)</label>
          <input type="hidden" name="ubicacion" id="ubicacion">
          <div class="map-container">
            <div id="mapa"></div>
          </div>
        </div>
        <div class="form-group">
          <input type="checkbox" name="bases"> Acepto las bases y condiciones
        </div>
        <div class="form-group">
          <button type="submit" class="button">Actualizar datos</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
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
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBo7hE6mN0-8W7b9RbhOxiocwYYYvH3JLE&callback=initMap"></script>
@endsection