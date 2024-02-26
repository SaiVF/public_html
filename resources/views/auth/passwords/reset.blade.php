@extends('layouts.frontend')



@section('content')

@if (session('status'))

    <div class="alert alert-success">

        {{ session('status') }}

    </div>

@endif



@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


<div class="container login-page">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
          <div id="login">
            <div class="panel panel-default panel-hallate">
              <div class="panel-heading text-left">
                <h3><b>Restablecer contraseña</b></h3>
              </div>
              <div class="panel-body">
                @if($errors->has('email'))
                <p class="alert alert-danger">{{ $errors->first('email') }}</p>
                @endif
                @if(session()->has('status'))
                <p class="alert alert-success">{{ session()->get('status') }}</p>
                @endif
                <form method="POST" action="{{ route('password.request') }}" class="form-rounded">
                    <input type="hidden" name="token" value="{{ $token }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <input name="email" type="text" placeholder="Email" class="form-control">
                  </div>
                  <div class="form-group">
                    <input name="password" type="password" placeholder="Password" class="form-control">
                  </div>
                  <div class="form-group">
                    <input name="password_confirmation" type="password" placeholder="Repetir" class="form-control">
                  </div>
                  

                  <div class="form-group text-right">
                    <button class="btn btn-default btn-hallate-default">Restablecer</button>
                  </div>
                </form>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

