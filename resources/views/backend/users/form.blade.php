@extends('layouts.backend')



@section('title', $user->exists ? 'Editando '.$user->name : 'Crear nuevo usuario')



@section('header')

  <!-- bootstrap datepicker -->

  <link rel="stylesheet" href="{{ url('assets/plugins/datepicker/datepicker3.css') }}">

  <!-- Select2 -->

  <link rel="stylesheet" href="{{ url('assets/plugins/select2/select2.min.css') }}">

@endsection



@section('content')

    <!-- Content Header (Page header) -->

    @if(!empty($errors))



    @endif

    <section class="content-header">

      <h1>

        {{ $user->id ? 'Editando '.$user->name : 'Añadir usuario' }}

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li><a href="{{ route('users.index') }}">Usuarios</a></li>

        <li class="active">{{ $user->id ? 'Editando '.$user->name : 'Añadir usuario' }}</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

        <!-- left column -->
        {{ Form::model($user, [

            'method' => $user->exists ? 'put' : 'post',

            'route' => $user->exists ? ['users.update', $user->id] : ['users.store'],

            'files' => true

          ]) }}
          <input type="hidden" name="id" value="{{ $user->exists ? $user->id : '' }}">
        @if($user->exists)
        @if($user->isEmpresa() OR $user->hasSolicitud())
        <div class="col-md-6">
        @else
        <div class="col-md-12">
        @endif
        @else
        <div class="col-md-12">
        @endif

          <!-- general form elements -->

            <!-- form start -->



          

          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Datos del Usuario</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <div class="row">

                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('name', 'Nombre')}}

                    {{ Form::text('name', null, ['class' => 'form-control' ])}}

                  </div>

                </div>

                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('email')}}

                    {{ Form::text('email', null, ['class' => 'form-control' ])}}

                   </div>

                </div>

                <div class="col-md-4">                

                  <div class="form-group">

                    {{ Form::label('sexo', 'Sexo')}}

                    {!! Form::select('sexo', $sexo, $user->sexo ? $user->sexo : null, ['class' => 'form-control', 'placeholder' => 'Selecciona un sexo']) !!}

                   </div>

                </div>
               
                <div class="col-md-4">                

                  <div class="form-group">

                    {{ Form::label('role', 'Rol')}}

                    {!! Form::select('role', $roles, $user->id ? $user->theRole()->id : null, ['class' => 'form-control']) !!}

                   </div>

                </div>
               

                <div class="col-md-4">                

                  <div class="form-group">

                    {{ Form::label('Teléfono')}}

                    {{ Form::text('telefono', null, ['class' => 'form-control' ])}}

                   </div>

                </div>
                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('departamento', 'Departamento')}}

                    {!! Form::select('departamento', $departamentos, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un departamento']) !!}

                   </div>

                </div>
                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('Ciudad')}}

                    {{ Form::text('ciudad', null, ['class' => 'form-control' ])}}

                   </div>

                </div>

                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('Dirección')}}

                    {{ Form::text('direccion', null, ['class' => 'form-control' ])}}

                   </div>

                </div>
                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('CI')}}

                    {{ Form::text('ci', null, ['class' => 'form-control' ])}}

                   </div>

                </div>


              </div>

              <div class="row">

                <div class="col-md-6">                

                  <div class="form-group">

                    {!! Form::label('image', 'Imagen') !!}

                    {!! Form::file('image') !!}

                  </div>

                </div>

                <div class="col-md-6">                

                  <div class="form-group">

                  @if($user->image)
                  @if($user->provider == 'facebook')

                    <label>Imagen actual</label>

                    <div class="thumbnail-small"><img src="{{ $user->image }}"></div>
                  @else
                    <label>Imagen actual</label>

                    <div class="thumbnail-small"><img src="{{ url('uploads/'.$user->image) }}"></div>
                  @endif
                  @endif

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('password', 'Contraseña')}}

                    {{ Form::password('password', ['class' => 'form-control' ])}}

                  </div>

                </div>

                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('password_confirmation', 'Confirmar contraseña')}}

                    {{ Form::password('password_confirmation', ['class' => 'form-control' ])}}

                  </div>

                </div>
                @if($user->exists)
                @if($user->role == 3)
                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('verify', 'Cuenta verificada')}}

                    {{ Form::checkbox('verify', 1, $user->verify) }}

                  </div>

                </div>
                @endif
                @endif
                <div class="col-md-6">                

                  <div class="form-group">

                    {{ Form::label('terminos', 'Terminos')}}

                    <p>Aceptó los terminos: {{ $user->terminos == 1 ? 'Sí' : 'No' }}</p>

                  </div>

                </div>

              </div>

            </div>

            <div class="box-footer">

              {{ Form::button($user->exists ? 'Guardar usuario' : 'Crear nuevo usuario', ['class' => 'btn btn-primary', 'type' => 'submit']) }}

            </div>

          </div>
          

          

        </div>
        @if($user->exists)
        @if($user->isEmpresa() OR $user->hasSolicitud())
        <div class="col-md-6">
          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Datos de la empresa</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('empresa', 'Empresa')}}
                    {!! Form::text('empresa', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre de la institución']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('descripcion_empresa', 'Descripción de la empresa')}}
                    {!! Form::text('descripcion_empresa',  null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Breve descripción de la institución']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('url', 'Enlace a página web o de redes sociales')}}
                    {!! Form::text('url', Auth::user()->url ? Auth::user()->url : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enlace a página web o de redes sociales. En caso de no tener una, poner no aplica.']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('trato_autoridad', 'Trato autoridad')}}
                    {!! Form::text('trato_autoridad', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Título de la autoridad. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva', 'title' => 'Título de la autoridad. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('nombre_autoridad', 'Nombre completo de la autoridad')}}
                    {!! Form::text('nombre_autoridad', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre completo de la autoridad principal']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('trato_nexo', 'Trato nexo')}}
                    {!! Form::text('trato_nexo', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva', 'title' => 'Título del referente o nexo con el portal. Ej: Señor, Señora, Ministro Secretario Ejecutivo, Ministro Secretario Ejecutiva, Director Ejecutivo, Directora Ejecutiva']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('nombre_nexo', 'Nombre nexo')}}
                    {!! Form::text('nombre_nexo', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre completo del referente o nexo con el portal']) !!}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{ Form::label('telefono_nexo', 'Teléfono nexo')}}
                    {!! Form::text('telefono_nexo', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Teléfono de contacto con el o la referente']) !!}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{ Form::label('correo_nexo', 'Correo nexo')}}
                    {!! Form::text('correo_nexo', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Correo electrónico de contacto con el o la referente']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('direccion_nexo', 'Dirección nexo')}}
                    {!! Form::text('direccion_nexo', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Dirección física de la institución']) !!}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{ Form::label('dias_atencion', 'Días de atención')}}
                    {!! Form::text('dias_atencion', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Días de atención']) !!}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{ Form::label('horario_atencion', 'Horario de atención')}}
                    {!! Form::text('horario_atencion', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Horario de atención']) !!}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{ Form::label('rubro_empresa', 'Rubro de la empresa')}}
                    {!! Form::text('rubro_empresa', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Rubro de la empresa']) !!}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    {{ Form::label('tipo_oportunidad', 'Tipo de oportunidad')}}
                    {!! Form::text('tipo_oportunidad', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Tipo de oportunidad. Ej: becas, oportunidad laboral, cursos, talleres, voluntariado, otros.']) !!}
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    {{ Form::label('logo_empresa', 'Logo de la empresa')}}
                    @if($user->logo)
                    <img src="{{ url('uploads/company/'.$user->logo) }}" class="img-responsive center-block">
                    @else
                    <p class="text-center"><em>No hay logo</em></p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        @endif
        {{ Form::close() }}
      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

@endsection



@section('footer')

<script>

$(function() {

    $('#users-button').addClass('active').find('.treeview-menu').show();

});

</script>

@endsection