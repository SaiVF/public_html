@extends('layouts.frontend')

@section('content')

    <div class="container login-page">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
          <div id="login">
            <div class="panel panel-default panel-hallate">
              <div class="panel-heading text-left">
                <h3><b>Completá tus datos</b></h3>
              </div>
              <div class="panel-body">
                @if($errors->has('email'))
                <p class="alert alert-danger">{{ $errors->first('email') }}</p>
                @endif
                @if(session()->has('status'))
                <p class="alert alert-danger">{{ session()->get('status') }}</p>
                @endif
                <form method="POST" action="{{ route('login') }}" class="form-rounded">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <input name="email" type="text" placeholder="Email" class="form-control" value="{{ old('email') ? old('email') : '' }}">
                  </div>
                  <div class="form-group">
                    <input name="password" type="password" placeholder="Contraseña" class="form-control">
                  </div>
                  <div class="form-group text-right">
                    <button class="btn btn-default btn-hallate-default">Ingresar</button>
                  </div>
                </form>

                <img src="{{ url('img/line.png') }}" class="line">
                <a href="{{ url('login/facebook') }}" class="continue-login facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Continuar con Facebook</a>


                

                <a href="{{ url('register') }}" class="button text-center">¿No tenes cuenta?</a>
               
                
                
                <a href="{{ url('password/reset') }}" class="button text-center">¿Haz olvidado tu contraseña?</a>
                
                
                <p>Al ingresar aceptás los <a href="{{ url('bases-y-condiciones') }}" class="button">Bases y Condiciones</a> del Servicio.</p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
