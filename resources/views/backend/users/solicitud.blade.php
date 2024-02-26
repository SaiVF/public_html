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

        {{ $user->id ? 'Solicitud de perfil de empresa de: '.$user->name : 'Añadir usuario' }}

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li><a href="{{ route('users.index') }}">Usuarios</a></li>

        <li class="active">{{ $user->id ? 'Solicitud de perfil de empresa de: '.$user->name : 'Añadir usuario' }}</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

        <!-- left column -->

        <div class="col-md-12">

          <!-- general form elements -->

            <!-- form start -->



          {{ Form::model($user, [

            'method' => $user->exists ? 'post' : 'post',

            'route' => $user->exists ? ['users.solicitud', $user->id] : ['users.solicitud'],

            'files' => true

          ]) }}

          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">{{ $user->id ? 'Solicitud de perfil de empresa de: '.$user->name : 'Añadir usuario' }}</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <div class="row">

                <div class="col-md-4">                

                  <div class="form-group">

                    {{ Form::label('name', 'Nombre')}}

                    {{ Form::text('name', null, ['class' => 'form-control' ])}}

                  </div>

                </div>

                <div class="col-md-4">                

                  <div class="form-group">

                    {{ Form::label('email')}}

                    {{ Form::text('email', null, ['class' => 'form-control' ])}}

                   </div>

                </div>

                <div class="col-md-4">
                  <label>Rol</label>
                  <select class="form-control" name="role">
                    <option selected="" value="3">Empresa</option>
                  </select>
                </div>


              </div>


            </div>

            <div class="box-footer">

              {{ Form::button($user->exists ? 'Aprobar solicitud' : 'Crear nuevo usuario', ['class' => 'btn btn-primary', 'type' => 'submit']) }}

            </div>

          </div>

          {{ Form::close() }}

        </div>

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