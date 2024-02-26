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
      @if($ofertas->isEmpty())
      <div class="container align-vertical">
        <div class="row">
          <div class="col-lg-4 col-lg-offset-4">
            <div class="result-empty">
              <img src="{{ url('img/icon-home-gray.png') }}" class="img-responsive center-block">
              <p class="text-center"><b>Aún no tienes ofertas</b></p>
            </div>
          </div>
        </div>
      </div>
      @else
      {{--
      <div class="filter-search">
        {!! Form::open([
          'route' => 'buscar',
          'class' => '',
          'method' => 'get'
        ]) !!}
          <div class="container">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <select class="form-control" name="categoria" id="categorias">
                    <option value="">Todas las oportunidades</option>
                    @if(count($allcategories))
                    @foreach($allcategories as $category)
                    <optgroup label="{{ $category->name }}">
                    @foreach($category->theChildren() as $categorias)
                      <option value="{{ $categorias->id }}">{{ $categorias->name }}</option>
                    @endforeach
                    </optgroup>
                    @endforeach
                    @endif
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <select class="form-control financiamiento" name="financiamiento" disabled>
                    <option value="">Cualquier tipo de financiación</option>
                    
                  </select>
                </div>  
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <select class="form-control temas" name="tema" disabled>
                    <option value="sdfsd">Cualquier tema</option>
                    
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <button class="btn btn-default btn-hallate-default">Explorar</button>
                  <button class="btn btn-default btn-hallate-default" type="reset">Borrar filtros</button>
                </div>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
      --}}
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
                	<a href="#">Eliminar</a> <span> - </span>
                	<a href="{{ url('oferta/'.$oferta->id.'/'.str_slug($oferta->title)) }}">Vista previa</a>
                  </div>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @endif
      @if($ofertas->links())
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            {!! $ofertas->appends(Request::except('page'))->links() !!}
          </div>
        </div>
      </div>
      @endif
    </div>
  </section>
@endsection

@section('footer')
  <script type="text/javascript">
    $(document).ready(function(){
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

    })
  </script>
  <style type="text/css">
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