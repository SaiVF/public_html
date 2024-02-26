<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@hasSection('title')
@yield('title') | {{ 'Panel de control' }}
@else {{ 'Panel de control' }}
@endif</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" href="{{ url('img/favicon.png') }}">
<link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@yield('header')
<link rel="stylesheet" href="{{ url('assets/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/skins/_all-skins.min.css') }}">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{{ options('title') }}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ options('title') }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ Auth::user()->theImage() }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ Auth::user()->theImage() }}" class="img-circle" alt="User Image">
                <p>
                    {{ Auth::user()->name }}
                    <small>{{ Auth::user()->theRole()->name }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-default btn-flat">
                    Perfil
                  </a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                    Cerrar sesión
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  @include('partials.backend-sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if($errors->any())
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger">
          <strong>Error</strong>
          <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    @endif
    @if(!empty($status))
    <div class="alert alert-info">
      {{ $status }}
    </div>
    @endif
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('cms.constants.url') }}" target="_blank">{{ config('cms.constants.vendor') }}</a>.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="{{ url('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('assets/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('assets/js/app.min.js') }}"></script>
@yield('footer')
</body>
</html>