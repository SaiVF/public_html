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
  <h3 class="title">Solicitud denegada</h3>
  <p>Su solicitud ha sido denegada. Favor contactar con el equipo de Hallate para conocer los detalles sobre dicha decisión.</p>

</div>
<div class="footer">
  	<p>{{ options('title') }} &copy; {{ date('Y') }}. Todos los derechos reservados</p>
  	<p>(021) 453-212</p>
	<p>hola@hallate.gov.py</p>
</div>
</body>
</html>
