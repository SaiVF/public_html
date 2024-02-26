<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="{{ url('css/correos.css') }}">
</head>
<body>
<div class="header">
  <img src="{{ url('img/brand-header.png') }}">
</div>
<div class="content solicitud">
  <h3 class="title">Nueva solicitud de perfil de colaborador de</h3>
  <p>{{ $input['name'] }}</p>
  <p>{{ $input['email'] }}</p>
  <p>{{ $input['telefono'] }}</p>


  <div style="text-align: center;">
  	<a href="{{ url('backend/users/'.Auth::user()->id.'/solicitud') }}" class="btn">Aprobar esta solicitud</a>
  </div>

  <br>
  <p>Si el enlace no le redirige a la página, por favor, copie y pegue la siguiente dirección URL en una nueva ventana.</p>
  <a href="{{ url('backend/users/'.Auth::user()->id.'/solicitud') }}" class="link">{{ url('backend/users/'.Auth::user()->id.'/solicitud') }}</a>
</div>
<div class="footer">
  	<p>{{ options('title') }} &copy; {{ date('Y') }}. Todos los derechos reservados</p>
  	<p>(021) 453-212</p>
	<p>hola@hallate.gov.py</p>
</div>
</body>
</html>
