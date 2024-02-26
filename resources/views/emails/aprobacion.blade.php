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
  <h3 class="title">Solicitud aprobada</h3>
  <p>Su solicitud de perfil de colaborador ha sido aprobada. Ahora puedes empezar a postear oportunidades en el portal. ¡Bienvenido a Hallate!</p>


  <div style="text-align: center;">
  	<a href="{{ url('mi-cuenta/editar') }}">Editar mi cuenta</a>
  	<a href="{{ url('postea-tu-oportunidad') }}" class="btn">Postear mi primera oportunidad</a>
  </div>

</div>
<div class="footer">
  	<p>{{ options('title') }} &copy; {{ date('Y') }}. Todos los derechos reservados</p>
  	<p>(021) 453-212</p>
	<p>hola@hallate.gov.py</p>
</div>
</body>
</html>
