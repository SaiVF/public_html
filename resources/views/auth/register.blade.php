@extends('layouts.frontend')

@section('content')

  <div class="container register">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-default panel-hallate">
          <div class="panel-heading">
            <h3><b>Completá tus datos</b></h3>
          </div>
          <div class="panel-body">
            @if($errors->any())
            <div class="alert">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            {{ Form::open([
              'route' => 'register',
              'class' => 'form-rounded'
            ]) }}
              <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre de usuario" autofocus>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="email" id="email" placeholder="Correo electrónico">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirmar contraseña">
              </div>
              
              <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6LfMWlgUAAAAAPwwaDAzP-7RYW8Q6J-X6rO87IvL"></div>
              </div>
              
              <div class="form-group text-right">
                <button class="btn btn-default btn-hallate-default" type="submit">Continuar</button>
              </div>
            {!! Form::close() !!}
            <p class="text-center">¿Ya estás registrado? Iniciá sesión <a href="{{ url('/login') }}" class="button">aquí</a></p>
            
            <p class="text-center">Al ingresar aceptás las <a href="{{ url('bases-y-condiciones') }}" class="button">Bases y condiciones.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
