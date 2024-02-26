<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>
  @hasSection('title')
  {{ options('title') }} - @yield('title')
  @else
  {{ options('title') }}
  @endif
</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

@hasSection('ogp')
@yield('ogp')
@else
<meta property="og:description" content="Buscamos acompañarte en tu proyecto de vida y brindarte herramientas que te ayuden a concretar tus metas. Por eso, desde la Secretaría Nacional de la Juventud, impulsamos el primer Portal de Oportunidades para jóvenes: Hallate.">
<meta property="og:image" content="{{ url('img/preview.jpg') }}"/>
<meta property="og:site_name" content="Hallate">
<meta property="og:title" content="{{ options('meta_facebook_title') }}"/>
<meta property="og:type" content="website">
<meta property="og:url" content="{{ options('meta_facebook_url') }}">
@endif

<!-- Fuentes del sitio -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ url('favicon/favicon.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ url('favicon/favicon.ico') }}" type="image/x-icon">

<!-- Estilos del sitio -->
<link rel="stylesheet" href="{{ url('css/font.css') }}">
<link rel="stylesheet" href="{{ url('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

{{--
<link rel="stylesheet" type="text/css" href="css/slidebars.css">
--}}

<link rel="stylesheet" type="text/css" href="{{ url('css/jssocials.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/jssocials-theme-flat.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/magnific-popup.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/kumanda.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/owl.transitions.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />


<!--  jQuery  -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ url('js/owl.carousel.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script src="{{ url('js/jquery.magnific-popup.js') }}"></script>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

{{--
<script src="js/slidebars.js"></script>
--}}
<script src="{{ url('js/jquery.smooth-scroll.min.js') }}"></script>
<script src="{{ url('js/wow.min.js') }}"></script>

<script type="text/javascript" src="{{ url('livechat/php/app.php?widget-init.js') }}"></script>
@hasSection('head')
@yield('head')
@endif

<script type="text/javascript">
  $(document).ready(function(){
   
    $('.popup-with-zoom-anim').click(function(e){
      e.preventDefault();
      e.stopPropagation();
    })
  })
</script>

{!! options('analytics') !!}
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.11&appId=1896127373960673';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<nav class="navbar navbar-default navbar-fixed-top" id="nav-nav">
	<div class="top-nav">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-right">
          @if(!empty(options('instagram')) AND !empty(options('facebook')) AND !empty(options('twitter')))
					<ul class="social text-right nav navbar-nav navbar-icon navbar-right">
						<li><p>Seguinos en:</p></li>
            @if(options('facebook'))
						<li><a href="{{ options('facebook') }}"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
            @endif
            @if(options('instagram'))
						<li><a href="{{ options('instagram') }}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            @endif
            @if(options('twitter'))
						<li><a href="{{ options('twitter') }}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            @endif
					</ul>
          @endif
					<ul class="nav navbar-nav navbar-icon navbar-right toggle-nav in">
					@if(Auth::check())
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle profile-button" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					    <img src="{{ Auth::user()->provider_id ? Auth::user()->image : url(Auth::user()->image ? 'uploads/'.Auth::user()->image : 'img/user-default.png')  }}" class="avatar"> {{ Auth::user()->name }} <span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu">
					@if(Auth::user()->isAdmin() OR Auth::user()->isModerador())
					<li>
					  <a href="{{ route('backend.dashboard') }}"><i class="fa fa-cogs"></i> Panel de control</a>
					</li>
					@endif
					<li>
					  <a href="{{ route('mi-cuenta.index') }}"><i class="fa fa-user"></i> Mi cuenta</a>
					</li>
					<li>
					  <a href="{{ route('logout') }}"
					    onclick="event.preventDefault();
					       document.getElementById('logout-form').submit();" class="">
					    <i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar sesión
					  </a>
					  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					    {{ csrf_field() }}
					  </form>
					</li>
					</ul>
					</li>
					@else
					<li><a class="popup-with-zoom-anim" href="#login"><i class="fa fa-user" aria-hidden="true"></i> Iniciar sesión</a></li>
					@endif
					</ul>
					<div class="separator"></div>

				</div>
			</div>
		</div>
	</div>
	<div class="container">
	
	<div class="navbar-header">
	  <a class="navbar-brand logo smoothScroll" href="{{ route('home') }}">
	    <img src="{{ url('img/brand-header.png') }}">
	  </a>
	  <img src="{{ url('img/secretaria-nacional-small.png') }}" class="brand-secretaria">
    <img src="{{ url('img/presidencia.png') }}" class="brand-secretaria" style="float: left;">
	</div>

	
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">		
		<ul class="nav navbar-nav navbar-icon navbar-right toggle-nav">
		@include('partials.navigation')
    {{--
		<li class="buscar-button">
			<a href="#" class=""><i class="fa fa-search" aria-hidden="true"></i></a>
			{!! Form::open([
			'route' => 'buscar',
			'class' => 'navbar-form',
			'method' => 'get'
			]) !!}
			<div class="form-group">
			  <input type="text" name="q" class="form-control" placeholder="Búsqueda rápida">
			</div>
			<button type="submit" class="btn btn-default"></button>
			{!! Form::close() !!}
		</li>
    --}}
		</ul> 
    
	</div><!-- /.navbar-collapse -->
  <a href="#" class="menu-button"><i class="fa fa-bars" aria-hidden="true"></i></a>
	</div><!-- /.container-fluid -->
</nav>

<div class="menu-content">
  <a href="#" class="menu-close">
    <i class="fa fa-times" aria-hidden="true"></i>
  </a>
  <a class="logo" href="{{ route('home') }}">
    <img src="{{ url('img/brand-header.png') }}">
  </a>
  <div class="">
    <div class="spacer"></div>
    <div class="">
      <div class="">
        <ul class="menu-nav">
          @include('partials.navigation')
        </ul>
        <ul class="">
        @if(Auth::check())
        <li class="dropdown">
          <a href="#" class="dropdown-toggle profile-button" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <img src="{{ url('img/user-default.png') }}" class="avatar"> {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
        @if(Auth::user()->isAdmin() OR Auth::user()->isModerador())
        <li>
          <a href="{{ route('backend.dashboard') }}"><i class="fa fa-cogs"></i> Panel de control</a>
        </li>
        @endif
        <li>
          <a href="{{ route('mi-cuenta.index') }}"><i class="fa fa-user"></i> Mi cuenta</a>
        </li>
        <li>
          <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
               document.getElementById('logout-form').submit();" class="">
            <i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>
        </ul>
        </li>
        @else
        <li><a class="" href="{{ url('/login') }}"><i class="fa fa-user" aria-hidden="true"></i> Iniciar sesión</a></li>
        <li><a href="{{ url('/register') }}">¿No tenes cuenta?</a></li>
        @endif
        {{--
        <li class="buscar-mobile">
          {!! Form::open([
          'route' => 'buscar',
          'class' => 'navbar-form',
          'method' => 'get'
          ]) !!}
          <div class="form-group">
            <input type="search" name="q" class="form-control" placeholder="Búsqueda rápida">
          </div>
          {!! Form::close() !!}
        </li>
        --}}
      </ul>
      </div>
    </div>
    <div class="spacer"></div>
  </div>
</div>

<div  id="wrapper">
  @yield('content')
</div>
<footer class="footer">
  <div class="container" style="display: none;">
    <div class="row flex">
      <div class="flex-item">
        <img src="{{ url('img/gobierno.png') }}" class="img-responsive center-block logos-footer">
        <img src="{{ url('img/secretaria-nacional.png') }}" class="img-responsive center-block logos-footer" style="width: 210px;">
      </div>
      <div class="flex-item text-center">
        <p><b>hola@hallate.gov.py</b></p>
      </div>
      <div class="flex-item text-center">
        <p><a href="{{ url('bases-y-condiciones') }}" class="link">Bases y condiciones</a></p>
      </div>
      {{--
      <div class="flex-item">
        <ul class="social text-right">
          <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
        </ul>
      </div>
      --}}
    </div>
    <div class="row">
      <div class="col-lg-12 text-center">
        
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        
        <img src="{{ url('img/secretaria-nacional.png') }}" class="img-responsive center-block logos-footer" style="width: 210px; margin-left: 15px; margin-top: 15px;">
        <img src="{{ url('img/gobierno.png') }}" class="img-responsive center-block logos-footer">
        <br>
        <br>
        <p><b>hola@hallate.gov.py</b> - <a href="{{ url('bases-y-condiciones') }}" class="link"><b>Bases y condiciones</b></a></p>
      </div>
    </div>
  </div>
</footer>
<!-- pop-up inicio de sesion -->
<div id="login" class="zoom-anim-dialog mfp-hide">
  <div class="panel panel-default panel-hallate">
    <div class="panel-heading">
      <h3><b>Ingresá a Hallate</b></h3>
      <p>¡Hacelo con tus cuentas de redes sociales<br>
      y accedé a todos tus servicios! </p>
    </div>
    <div class="panel-body">
      <a href="{{ url('login/facebook') }}" class="continue-login facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Continuar con Facebook</a>

      <img src="{{ url('img/line.png') }}" class="line">

      <a href="{{ url('login') }}" class="continue-login correo">Continuar con mi correo electrónico</a>

      <a href="{{ url('register') }}" class="button text-center">¿No tenes cuenta?</a>
      <p>Al ingresar aceptás los <a href="{{ url('bases-y-condiciones') }}" class="button">Bases y Condiciones</a> del Servicio.</p>
    </div>
  </div>
</div>
@if(!Cookie::get('popup') AND !\Auth::user())
<div id="register" class="zoom-anim-dialog mfp-hide">
  <a href="{{ url('register') }}">
    <img src="{{ url('img/pop-up.png') }}" class="img-responsive center-block">
  </a>
</div>
@endif
</div><!-- fin cavnas="container" -->

<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ url('js/jssocials.min.js') }}"></script>
<script src="{{ url('js/kumanda.js') }}"></script>
@if(!Cookie::get('popup') AND !\Auth::user())
<script type="text/javascript">
  $(document).ready(function() {
    if ($(window).width() >= 800) {
      $(window).load(function () {
          $.magnificPopup.open({
              items: {
                  src: '#register'
              },
              type: 'inline'

          }, 0);
      });
    }


  });
</script>
<style type="text/css">
  #register {
    
    position: relative;
    max-width: 600px;
    margin: auto;
  }
  #register img {
    border-radius: 31px;
  }
  .mfp-close-btn-in .mfp-close {
    color: #fff;
  }
</style>
@endif

@yield('footer')

</body>
</html>