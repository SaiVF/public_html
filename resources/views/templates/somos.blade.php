<section class="page somos">
    <div class="page-banner banner-mini"  @if($page->theImage()) style="background-image: url('{{ url('uploads/'.$page->theImage()->src) }}');" @else style="background-image: url('img/contacto.jpg');" @endif>
      <div class="container inner-page-banner">
        <div class="row">
          <div class="col-lg-12 text-center">
            {{--<h3>¿Qué buscás?</h3>--}}
            <h1>¿Quiénes somos?</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="page-body">

        <div class="somos-section section-1">
          <div class="container">
            <div class="row">
              <div class="col-lg-5">
                <h2>La mayor plataforma de oportunidades para los jóvenes de Paraguay.</h2>
                <p>Creemos profundamente en el enorme potencial de todos y cada uno de los jóvenes que habitan nuestro territorio y que sólo necesitan tener acceso a  la información  que los lleve hasta esa oportunidad para desarrollar su talento al máximo.</p>
              </div>
              <div class="col-lg-7">
                <img src="{{ url('img/hallate-white.png') }}" class="img-responsive center-block">
              </div>
            </div>
          </div>
        </div><!-- fin .somos-section -->

        <div class="somos-section section-2">
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <img src="{{ url('img/puente.png') }}" class="img-responsive">
              </div>
              <div class="col-lg-6 text-right">
                <p>Somos ese puente que<br>conecta el talento con la<br>oportunidad.</p>
              </div>
            </div>
          </div>
        </div><!-- fin .somos-section -->

        <div class="somos-section section-3">
          <div class="container">
            <div class="row">
              <div class="col-lg-4">
                <h2>DE<br>DONDE<br>VENIMOS</h2>
              </div>
              <div class="col-lg-4 text-justify">
                <p>Recorrimos el país hablando con jóvenes como vos, y  en cada una de las conversaciones escuchamos una misma palabra <b>oportunidad</b>.</p>
              </div>
            </div>
          </div>
        </div><!-- fin .somos-section -->

        <div class="somos-section section-4">
          <div class="container">
            <div class="row">
              <div class="col-lg-4">
                
              </div>
              <div class="col-lg-4 text-justify">
                <p>Escuchando ese pedido, en la <a href="http://www.snj.gov.py/">Secretaría Nacional de Juventud</a> decidimos crear Hallate, el Portal de Oportunidades para la juventud paraguaya que articula la oferta de servicios y acciones disponibles desde el sector público, privado y de la sociedad civil para jóvenes.</p>
              </div>
            </div>
          </div>
        </div><!-- fin .somos-section -->

        <div class="somos-section section-5">
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-lg-offset-3 text-left">
                <h2>Nuestra Misión</h2>
                <p>Ser  tu mayor referente de oportunidades:  académicas, formación técnica, profesional, personal, voluntariado y bienestar.</p>
              </div>
              
            </div>
            <div class="row">
              <div class="col-lg-8">
                
              </div>
              <div class="col-lg-4 text-right">
                <h2>Nuestra Visión</h2>
                <p>Que encuentres la oportunidad que<br>buscas y te halles.</p>
              </div>
            </div>
          </div>
        </div><!-- fin .somos-section -->

      </div><!-- fin .page-body -->
      <section class="section section-info bg-default">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
              <h2>Encontrá acá</h2>
              {{--
              <p>A un mes de haber iniciado este proyecto, nos comprometimos a acercarte un puntapié de todo lo que vas a poder encontrar en el Portal de Oportunidades.</p>

              <p>Por ello desarrollamos la primera versión de nuestro Portal y lo dotamos ya con las oportunidades de becas disponibles a nivel nacional e internacional, para que puedas ir preparándote y potenciar tus oportunidades de estudio para el 2018.</p>
              --}}
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <ul class="items-slider">
                @foreach($categories as $cate)
                @if($cate->content)
                <li>
                  <div class="item-categorie">
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="icon">
                         {!! $cate->theIcon() !!}
                        </div>

                        <h3 class="text-center">{{ $cate->name }}</h3>

                        {!! str_limit($cate->content, 500) !!}
                        
                      </div>
                    </div>
                  </div>
                </li>
                @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </section>
      {{--
      <section class="main-categories">
        <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <div class="row">
              @php $i = 1; @endphp
              @foreach($categories as $c)
              @if($c->content)
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                <a href="#!">
                  <img src="{{ url('uploads/'.$c->image) }}" class="img-responsive center-block">
                  
                </a>
              </div>
              @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
      </section>
      --}}
      {{--
      <div class="more-info">
        <div class="container">
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
              <h2>¿Cómo podés explorar?</h2>
              <p>Strong single origin strong, arabica, galão frappuccino breve spoon that. A saucer brewed skinny medium bar fair trade et plunger pot cinnamon. Siphon spoon, java breve a mug siphon affogato grinder.</p>

              <p>Affogato beans grounds, and, frappuccino est cream aftertaste to go blue mountain plunger pot single origin. Cream, roast kopi-luwak mug doppio, americano mocha macchiato filter kopi-luwak. Iced, ut, cup doppio macchiato to go, pumpkin spice froth medium to go kopi-luwak. Macchiato con panna sit aged in grounds rich et sit medium. Dripper ristretto con panna, lungo arabica steamed cortado foam.</p>

              <img src="{{ url('img/pasos.png') }}" class="img-responsive center-block pasos">

            </div>
          </div>
        </div>
      </div>
      --}}
    </div><!-- fin .page-content -->
  </section>
  <div id="category" class="zoom-anim-dialog mfp-hide">
    
  </div>

@section('footer')
<script>
$(function() {
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

  $(".navbar-default .navbar-nav a").click(function(){
    //alert(this.hash);
    if (this.hash) {
      var hreff = '{{ url('') }}/' + this.hash;
      $(location).attr('href',hreff);
    }
  });

});
</script>
@endsection