@section('content')
<div class="home">
  <section class="main" data-src="@if($page->theImage())@if($page->theImage()->src){{ url('uploads/'.$page->theImage()->src) }}@endif @endif" @if($page->theImage())@if($page->theImage()->src)style="background-image: url('{{ url('uploads/'.$page->theImage()->src) }}');"@endif @endif>
    <div class="container panel-home">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel-content text-center">
            <div class="icon">
              <img src="{{ url('img/icon-home.png') }}" class="img-responsive center-block">
            </div>
            <h3>Mba'eteko?</h3>
            <h1>¿Qué querés encontrar?</h1>
            {{--
            @if ($errors->any())
              @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
              @endforeach
            @endif
            --}}
            {!! Form::open([
              'route' => 'buscar',
              'class' => 'form-panel form-inline',
              'method' => 'post'
            ]) !!}
              <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                  <div class="fields-content">
                  	
                    <input type="text" name="q" class="form-control search-field q" placeholder="Buscar..." autocomplete="off">
                    
                    {{--
                    <div class="form-group">
                      <label>Quiero</label>
                      
                      {!! Form::select('categoria', $categorias, null, ['class' => 'form-control select', 'id' => 'categoria', 'placeholder' => '']) !!}
                      
                      <select name="categoria" id="categoria" class="form-control categoria-select">
                        <option value="" disabled selected>Selecciona una categoría</option>
                        @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                        @foreach($category->theChildren() as $categorias)
                          <option value="{{ $categorias->id }}">{{ $categorias->name }}</option>
                        @endforeach
                        </optgroup>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>en</label>
                      {!! Form::select('lugar', [], null, ['class' => 'form-control col-lg-6', 'id' => 'lugar', 'disabled']) !!}
                    </div>
                    --}}
                    {{--
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="sin-costo" value="1">
                       <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                       Sin costo
                       </label>
                    </div>
                    --}}
                  </div>
                </div>
                <div class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-0 col-xs-4 col-xs-offset-4 button-content">
                  <button class="btn" type="submit">Dale!</button>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-10">
                  <div class="text-right see-all"><a href="{{ url('buscar?todo=todo') }}" style="display: block; color: #fff; text-decoration: none; margin-top: 10px; font-weight: bold;">Ver todas las ofertas</a></div>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">
          <section class="main-categories">
              <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
                  <div class="row">
                    <form method="post" action="{{ route('buscar') }}" class="form-parent">
                      {{ csrf_field() }}
                    @php $i = 1; @endphp
                    <input type="hidden" name="parent" class="input_parent">
                    @foreach($categories as $c)
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 {{ str_slug($c->name) }}">
                      <a href="#" class="parent_btn" data-parent="{{ $c->id }}">
                        
                        <img src="{{ url('uploads/'.$c->image) }}" class="img-responsive center-block">
                        
                        <p class="text-center">{{ $c->name }}</p>
                      </a>
                    </div>
                    @endforeach
                    <script type="text/javascript">
                      $('.parent_btn').on('click', function(e){
                        e.preventDefault();
                        var data = $(this).data('parent');
                        $('.input_parent').val(data);
                        $('.form-parent').submit();
                      })
                    </script>
                  </form>
                  </div>
                </div>
              </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</div>
  <section class="section welcome hidden-xs">
    <div class="container align-vertical">
      <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
          <h1>¡Bienvenidos al<br>portal Hallate!</h1>
          <div class="text-justify">
            <p>Buscamos acompañarte en tu proyecto de vida y brindarte herramientas que te ayuden a concretar tus metas. Por eso, desde la Secretaría Nacional de la Juventud, impulsamos el primer Portal de Oportunidades para jóvenes: <b>Hallate.</b></p>
          </div>
          <div class="action text-center">
            <a href="{{ url('somos') }}" class="btn btn-default btn-hallate-default">Leer más</a>
          </div>
        </div>
      </div>
    </div>
    <div class="image"></div>
  </section>
  
  <section class="section popular" id="destacados" data-load="false">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="title-section">
            <span class="ear">Dale un vistazo a lo más</span>
            Destacado
          </h2>
        </div>
      </div>
    </div>
    <div class="spacer"></div>
    
    <div class="container">
      <div class="row adjust data-render">
        <div class="loader adjust text-center">
          <p>Cargando...</p>
        </div>
        
        
      </div>
    </div>

  </section>
  
  <section class="section popular bg-default" id="lo-mas-nuevo" data-load="false">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="title-section">
            <span class="ear">Estas viendo</span>
            Lo más nuevo
          </h2>
        </div>
      </div>
    </div>
    <div class="spacer"></div>
    <div class="container">
      <div class="row adjust data-render">
        <div class="loader text-center">
          <p>Cargando...</p>
        </div>
      </div>
    </div>
  </section>
 
  <section class="section popular" id="por-vencer" data-load="false">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="title-section">
            <span class="ear">No lo dejes escapar</span>
            Por vencer
          </h2>
        </div>
      </div>
    </div>
    <div class="spacer"></div>
    <div class="container">
      <div class="row adjust data-render">
        <div class="loader text-center">
          <p>Cargando...</p>
        </div>
      </div>
    </div>
  </section>

  <section class="inspired hidden-xs">
    <div class="container align-vertical hidden-sm hidden-xs">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-6 col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-12 col-xs-offset-0">
          <div class="panel">
            <h1>¿Conoces de una oportunidad<br>de interés juvenil?</h1>

            <div class="text-justify">
              <p>¡Contanos y formá parte de esta red única de instituciones que trabajamos a favor de la juventud!</p>
            </div>
            <br>
            <div class="text-right">
              <a href="{{ url('postea-tu-oportunidad') }}" class="btn btn-default btn-hallate-default">¡Empezar!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section hidden-lg hidden-xs">
    <div class="container align-vertical">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-6">
          <div class="panel">
            <h1>¿Conoces de una oportunidad de interés juvenil?</h1>

            <div class="text-justify">
              <p>¡Contanos y formá parte de esta red única de instituciones que trabajamos a favor de la juventud!</p>
            </div>
            <br>
            <div class="text-right">
              <a href="{{ url('postea-tu-oportunidad') }}" class="btn btn-default btn-hallate-default">¡Empezar!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
{{--
  <section class="section publica">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <h1>¿Conoces de una oportunidad<br>de interés juvenil?</h1>
          <p>¡Contanos y formá parte de esta red única de instituciones que trabajamos a favor de la juventud!</p>
          <p><b>¡Suscribite y contanos!</b></p>
          <br>
          <a href="{{ url('postea-tu-oportunidad') }}" class="btn btn-default btn-hallate-default">¡Empezar!</a>
        </div>
        
        <div class="col-lg-5 align-vertical white-section">
          <form>
            <div class="row">
              <div class="col-lg-8 col-lg-offset-4">
                <div class="form-group">
                  <label><small>Paso 1</small></label>
                  <label class="radio-inline"><input type="radio" name="optradio">Cargar oportunidad</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8 col-lg-offset-4">
                <div class="form-group">
                  <label><small>Paso 2</small></label>
                  <label class="radio-inline"><input type="radio" name="optradio">Completar tus datos</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8 col-lg-offset-4 text-right">
                <a href="{{ url('postea-tu-oportunidad') }}" class="btn btn-default btn-hallate-default">¡Empezar!</a>
              </div>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </section>
  --}}



  <div id="category" class="zoom-anim-dialog mfp-hide">
    
  </div>
  <div class="overlay">
  <div class="message"></div>
</div>


@endsection

@section('footer')
  <script src="{{ url('js/waypoints.js') }}"></script>
  <style type="text/css"> 
  .overlay {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      opacity: 1;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, .5);
  }
  .overlay .message {
      position: absolute;
      left: 0;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 200px;
      background-color: #ffcc32;
      padding: 1em;
      margin: auto;
      display: inline-block;
      color: #fff;
      display: none;
  }
  {{--
  .fields-content {
    padding: 0;
  }
  input.search-field {
    background-color: #f1f2f2;
      color: #999;
      border: 1px solid #e8e8e8!important;
      border-radius: 31px !important;
      box-shadow: none!important;
      width: 100% !important;
      min-height: 58px;
          font-size: 18px;
    font-weight: bold;
    }
    input.search-field:focus {
      border-color: #999!important;
    }
    --}}
</style>
<script>
$(function() {
  $('.loader').hide();
  
  var waypoint = new Waypoint({
    element: document.getElementById('destacados'),
    handler: function() {
      if($('#destacados').attr('data-load') == 'false') {
        $('#destacados .loader').fadeIn();
        $.post('{{ route('oferta.destacados') }}', function(response) {
          $('#destacados .data-render').html('');
          $('#destacados .data-render').html(response);
        });
        setTimeout(function(){ adjust(); }, 2000);
        
      }
      $('#destacados').attr('data-load', 'true');
    }
  })
  var waypoint = new Waypoint({
    element: document.getElementById('lo-mas-nuevo'),
    handler: function() {
      if($('#lo-mas-nuevo').attr('data-load') == 'false') {
        $('#lo-mas-nuevo .loader').fadeIn();
        $.post('{{ route('oferta.news') }}', function(response) {
          $('#lo-mas-nuevo .data-render').html('');
          $('#lo-mas-nuevo .data-render').html(response);
        });
        setTimeout(function(){ adjust(); }, 2000);
      }
      $('#lo-mas-nuevo').attr('data-load', 'true');
    }
  })
  var waypoint = new Waypoint({
    element: document.getElementById('por-vencer'),
    handler: function() {
      if($('#por-vencer').attr('data-load') == 'false') {
        $('#por-vencer .loader').fadeIn();
        $.post('{{ route('oferta.vencer') }}', function(response) {
          $('#por-vencer .data-render').html('');
          $('#por-vencer .data-render').html(response);
        });
        setTimeout(function(){ adjust(); }, 2000);
      }
      $('#por-vencer').attr('data-load', 'true');
    }
  })
  /*
  $.post('{{ route('oferta.destacados') }}', function(response) {
    $('#destacados .data-render').html('');
  });*/


  $('.search-field').focus();
  if ($(window).width() >= 768) {

    $('#lugar').select2({
      placeholder: "Selecciona un lugar",
    });
    $('#categoria').select2({
      placeholder: "Selecciona una categoría",
    });
    $('.categoria-select').on('change', function() {
      /*$.post('{{ route('ajax.lugar') }}', { categoria: $(this).val() }, function(response) {
        $('#lugar').html(response).removeAttr('disabled').select2();
      });*/
      $.ajax({
          type: "POST",
          url: '{{ route('ajax.lugar') }}',
          data: { categoria: $(this).val() },
          dataType: "html",
          beforeSend: function(response){
            $('.overlay').fadeIn(250);
            $('.overlay .message').html('Cargando...').fadeIn(250);
            console.log('beforeSend');
          },
          ajaxSend: function(response){
            $('.overlay').fadeIn(250);
            $('.overlay .message').html('Cargando...').fadeIn(250, function(response) {
                setTimeout(function() {
                  $('.overlay .message').html('').hide();
                  $('.overlay').fadeOut(250);
                }, 1500);
            });
            console.log('ajaxSend');
          },
          error: function(response){
            /*$('.overlay .message').html(response.error).fadeIn(250, function(response) {
                setTimeout(function() {
                  $('.overlay .message').html('').hide();
                  $('.overlay').fadeOut(250);
                }, 1500);
            });*/
            console.log('error');
          },
          success: function(response){

            /*$('.overlay .message').html(response.text).fadeIn(250, function(response) {
                setTimeout(function() {
                  $('.overlay .message').html('').hide();
                  $('.overlay').fadeOut(450);
                }, 1500);
            });*/
            setTimeout(function() {
              $('.overlay .message').html('').hide();
              $('.overlay').hide();
            }, 100);
            $('#lugar').html(response).removeAttr('disabled').select2();
          }
      });//fin ajax send
    })
  }else {
    $('.categoria-select').change(function() {
      $.post('{{ route('ajax.lugar') }}', { categoria: $(this).val() }, function(response) {
        $('#lugar').html(response).removeAttr('disabled');
      });
    })
    $('.main').css('background-image', 'url(img/banner.jpg)');
  }


  


  $('.categoria-item').on('click', function(e) {
    e.preventDefault();
    $.post('{{ route('ajax.content') }}', { categoria: $(this).data('id') }, function(response) {
      $('#category').html(response);
      
      $.magnificPopup.open({
          items: {
              src: '#category',
          },
          type: 'inline',
          fixedContentPos: false,
          fixedBgPos: true,

          overflowY: 'auto',

          closeBtnInside: true,
          preloader: false,
          
          midClick: true,
          removalDelay: 300,
          mainClass: 'my-mfp-zoom-in'
      });
    });
  })
});
</script>


@endsection