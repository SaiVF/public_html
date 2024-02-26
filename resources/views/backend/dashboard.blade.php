@extends('layouts.backend')



@section('title', 'Inicio')



@section('content')

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Panel de control

        <small>Version 1.0</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('backend/dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li class="active">Panel de control</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Info boxes -->

      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $user }}</h3>

              <p>Usuarios registrados</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{ url('backend/users') }}" class="small-box-footer">
              Ver todos <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $oferta }}</h3>

              <p>Ofertas activas</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $inactivas }}</h3>

              <p>Ofertas inactivas</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas/vencidas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $featured }}</h3>

              <p>Ofertas destacadas</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $snpp }}</h3>

              <p>Ofertas del SNPP</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $stp }}</h3>

              <p>Ofertas de STP</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $sfp }}</h3>

              <p>Ofertas de SFP</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $pivot }}</h3>

              <p>Ofertas de PIVOT</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $hallate }}</h3>

              <p>Ofertas de HALLATE</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $empresas }}</h3>

              <p>Ofertas de empresas</p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>
            <a href="{{ url('backend/ofertas') }}" class="small-box-footer">
              Ver todas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $vacancias }}</h3>

              <p>Oportunidades <em>(Total de vacancias disponibles)</em></p>
            </div>
            <div class="icon">
              <i class="fa fa-star-o"></i>
            </div>

          </div>
        </div>
      </div>
      <div class="row">
        	<div class="col-lg-6">
	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Categorías</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body" style="">
	              <div class="table-responsive">
	                <table class="table no-margin table-hover">
	                  <thead>
	                  <tr>
	                    <th>Categoría ID</th>
	                    <th>Nombre</th>
	                    <th>Enlaces</th>
                      <th>Oportunidades</th>
	                  </tr>
	                  </thead>
	                  <tbody>
	                  @foreach($categories as $category)
	                  <tr>
	                    <td><a href="#">{{ $category->id }}</a></td>
	                    <td>{{ $category->name }}</td>
	                    <td><span class="label label-success" style="background-color: {{ $category->color_principal }} !important;">{{ $category->ofertas->count() }}</span></td>
	                  </tr>
	                  @foreach($category->theChildren() as $categorias)
	                  <tr>
	                    <td><a href="#">{{ $categorias->id }}</a></td>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $categorias->name }}</td>
	                    <td><span class="label label-success" data-color="{{ $categorias->theColor() }}" style="background-color: {{ $categorias->theColor() }} !important;">{{ $categorias->ofertas->count() }}</span></td>
                      <td><span class="label label-success" data-color="{{ $categorias->theColor() }}" style="background-color: {{ $categorias->theColor() }} !important;">
                        {{ $categorias->ofertas->sum('vacancias_disponibles') }}
                      </span></td>
	                  </tr>
	                  @endforeach
	                  @endforeach

	                  </tbody>
	                </table>
	              </div>
	              <!-- /.table-responsive -->
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer clearfix" style="">
	              <a href="{{ route('backend.categories.index', ['type' => 3]) }}" class="btn btn-sm btn-default btn-flat pull-right">Ver todas las categorías</a>
	            </div>
	            <!-- /.box-footer -->
	          </div>
	        </div>
        </div>

  	</section>

    <!-- /.content -->

@endsection



@section('footer')

@endsection