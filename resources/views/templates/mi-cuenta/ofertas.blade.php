@extends('layouts.frontend')

@section('content')
  <section class="page buscar">

    <div class="page-body">
      @if($ofertas->count())
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            
            <h2 class="page-title">@if ($ofertas->total()){{ $ofertas->total() }}@else @endif @if($ofertas->total() > 1 ) ofertas @else oferta @endif</h2>
          </div>
        </div>
      </div>
      <div class="spacer"></div>
      
      @endif
      @if($ofertas->isEmpty() AND $ocultas->isEmpty())
      <div class="container align-vertical">
        <div class="row">
          <div class="col-lg-4 col-lg-offset-4">
            <div class="result-empty wow fadeIn" style="visibility: hidden;">
              <img src="{{ url('img/icon-home-gray.png') }}" class="img-responsive center-block">
              <p class="text-center"><b>Aún no tienes ofertas</p>
              <br>
              <a href="{{ url('postea-tu-oportunidad') }}" class="btn btn-default btn-hallate-default center-block">Postear una oportunidad</a>
            </div>

          </div>
        </div>
      </div>
      @endif

      @if(session()->has('success'))
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="alert alert-warning">{{ session()->get('success') }}</div>
          </div>
        </div>
      </div>
      @endif
      
      <div class="container">
        <div class="row adjust">          
          @foreach($ofertas as $oferta)
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" data-inicio="{{ $oferta->fecha_inicio }}" data-limite="{{ $oferta->fecha_limite }}">
            <a href="{{ url('oferta/'.$oferta->id.'/'.str_slug($oferta->title)) }}" class="card-link">
              <div class="card adjust-height">
                <div class="image-container" @if($oferta->theCategory()) style="background-color: {{ $oferta->theColor('fondo') }};" @endif>
                  <div class="image-container-inner">
                  @if($oferta->theCategory())
                  @if($oferta->theCategory()->image)
                  {!! $oferta->theIcon() !!}
                  <p>{{ $oferta->theCategory()->name }}</p>
                  @else
                  
                  @endif
                  @endif
                  </div>
                </div>
                <div class="card-body">
                  <div class="text-center">
                  	<span class="category">
                  		@if($oferta->borrador == 1)
                  	Aprobado
                  	@else
                  	No aprobado
                  	@endif
                    -
                    @if($oferta->state == 1)
                    Visible
                    @else
                    Oculto
                    @endif
                  	</span>
                    @if($oferta->theCategory())
                  <span class="category" style="background-color: {{ $oferta->theColor('fondo') }}; color: {{ $oferta->theColor('principal')}}">
                  	{{ $oferta->theCategory()->name }}
                  </span>
                  @endif
                  </div>
                  <div class="text-left">
                    <h4>{{ titleCase(str_limit($oferta->title, 45)) }}</h4>
                    <span class="info">{{ $oferta->lugar_aplicar }}</span>
                    <span class="date">
                      @if($oferta->pais)
                      @if($oferta->pais->icon)
                      <img src="{{ url('uploads/'.$oferta->pais->icon) }}" class="icon">
                      @endif
                      @endif 
                      {{ $oferta->lugar }} @if($oferta->fecha_limite) - <i class="fa fa-hourglass-half" aria-hidden="true"></i> {{ $oferta->theDate() }} @else - Constante @endif
                    </span>
                  </div>
                  <div>
                  	<a href="{{ route('mi-cuenta.ofertas.edit', ['id' => $oferta->id]) }}">Editar</a> <span> - </span>
                	<a href="#" data-toggle="modal" data-target="#modal-default" data-title="{{ $oferta->title }}" data-route="{{ route('mi-cuenta.ofertas.delete', ['id' => $oferta->id]) }}" class="btn-delete">Eliminar</a> <span> - </span>
                	<a href="{{ url('oferta/'.$oferta->id.'/'.str_slug($oferta->title)) }}">Vista previa</a>
                  </div>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      
      {{--
      @if($ofertas->links())
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            {!! $ofertas->appends(Request::except('page'))->links() !!}
          </div>
        </div>
      </div>
      @endif
      --}}
      
      <div class="spacer"></div>
      @if($ocultas->count())
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            
            <h2 class="page-title">@if ($ocultas->total()){{ $ocultas->total() }}@else @endif @if($ocultas->total() > 1 ) ofertas ocultas @else oferta oculta @endif</h2>
          </div>
        </div>
      </div>
      <div class="spacer"></div>
      <div class="container">
        <div class="row adjust">          
          @foreach($ocultas as $oculta)
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" data-inicio="{{ $oculta->fecha_inicio }}" data-limite="{{ $oculta->fecha_limite }}">
            <a href="{{ url('oferta/'.$oculta->id.'/'.str_slug($oculta->title)) }}" class="card-link">
              <div class="card adjust-height">
                <div class="image-container" @if($oculta->theCategory()) style="background-color: {{ $oculta->theColor('fondo') }};" @endif>
                  <div class="image-container-inner">
                  @if($oculta->theCategory())
                  @if($oculta->theCategory()->image)
                  {!! $oculta->theIcon() !!}
                  <p>{{ $oculta->theCategory()->name }}</p>
                  @else
                  
                  @endif
                  @endif
                  </div>
                </div>
                <div class="card-body">
                  <div class="text-center">
                  	<span class="category">
                  		@if($oculta->borrador == 1)
                  	Aprobado
                  	@else
                  	No aprobado
                  	@endif
                    -
                    @if($oculta->state == 1)
                    Visible
                    @else
                    Oculto
                    @endif
                  	</span>
                    @if($oculta->theCategory())
                  <span class="category" style="background-color: {{ $oculta->theColor('fondo') }}; color: {{ $oculta->theColor('principal')}}">
                  	{{ $oculta->theCategory()->name }}
                  </span>
                  @endif
                  </div>
                  <div class="text-left">
                    <h4>{{ titleCase(str_limit($oculta->title, 45)) }}</h4>
                    <span class="info">{{ $oculta->lugar_aplicar }}</span>
                    <span class="date">
                      @if($oculta->pais)
                      @if($oculta->pais->icon)
                      <img src="{{ url('uploads/'.$oculta->pais->icon) }}" class="icon">
                      @endif
                      @endif 
                      {{ $oculta->lugar }} @if($oculta->fecha_limite) - <i class="fa fa-hourglass-half" aria-hidden="true"></i> {{ $oculta->theDate() }} @else - Constante @endif
                    </span>
                  </div>
                  <div>
                  	<a href="{{ route('mi-cuenta.ofertas.edit', ['id' => $oculta->id]) }}">Editar</a> <span> - </span>
                	<a href="#" data-toggle="modal" data-target="#modal-default" data-title="{{ $oculta->title }}" data-route="{{ route('mi-cuenta.ofertas.delete', ['id' => $oculta->id]) }}" class="btn-delete">Eliminar</a> <span> - </span>
                	<a href="{{ url('oferta/'.$oculta->id.'/'.str_slug($oculta->title)) }}">Vista previa</a>
                  </div>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      
      @endif
    </div>
  </section>
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar oferta</h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar el oferta <span id="oferta_title"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              {!! Form::open(['method' => 'post']) !!}
                    {!! Form::button('Sí, eliminar oferta', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('footer')
  <script type="text/javascript">
    $(document).ready(function(){
      adjust();
      $(".navbar-default .navbar-nav a").click(function(){
        //alert(this.hash);
        if (this.hash) {
          var hreff = '{{ url('') }}/' + this.hash;
          $(location).attr('href',hreff);
        }
      });

      $('#categorias').change(function() {
        $('.temas').attr('disabled', 'disabled');
        $('.financiamiento').attr('disabled', 'disabled');
        $.post('{{ route('filter.temas') }}', { categoria: $(this).val() }, function(response) {
          $('.temas').html(response).removeAttr('disabled');
        });

        $.post('{{ route('filter.financiamiento') }}', { categoria: $(this).val() }, function(response) {
          $('.financiamiento').html(response).removeAttr('disabled');
        });
        
      })

      $(document).on('click', '.btn-delete', function(){
        $('.modal form').attr('action', $(this).data('route'));
        
        $('#oferta_title').text($(this).data('title'));
      });

    })
  </script>
  <style type="text/css">
  .result-empty {
    position: initial!important;
    transform: initial!important;
  }
    .filter-search {
      padding: 0 0 30px 0;
    }
    select {
      color: #999;
      border: 1px solid #e8e8e8!important;
      min-height: 45px;
      border-radius: 31px !important;
      -webkit-box-shadow: 0px 5px 2px -1px rgba(229,230,230,1);
      -moz-box-shadow: 0px 5px 2px -1px rgba(229,230,230,1);
      box-shadow: 0px 5px 2px -1px rgba(229,230,230,1)!important;
    }
    select:focus {
      border-color: #999!important;
    }
  </style>
  @endsection