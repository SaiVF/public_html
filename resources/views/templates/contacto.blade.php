  <section class="page">
    <div class="page-banner banner-mini" @if($page->theImage()) style="background-image: url('{{ url('uploads/'.$page->theImage()->src) }}');" @else style="background-image: url('img/contacto.jpg');" @endif>
      <div class="container inner-page-banner">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h3>¿Tenés dudas o consultas?</h3>
            <h1>¡Contactanos!</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="page-body">
        <div class="container">
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
              <form action="{{ route('contacto') }}" method="post" class="form-rounded" id="form">
                {!! csrf_field() !!}
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <input type="text" name="nombre" class="form-control" placeholder="Nombre y Apellido" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8">
                    <div class="form-group">
                      <input type="text" name="email" class="form-control" placeholder="e-mail" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <textarea name="mensaje" class="form-control" placeholder="Su consulta"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LfMWlgUAAAAAPwwaDAzP-7RYW8Q6J-X6rO87IvL"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 text-right">
                    <div class="form-group">
                      <button class="btn btn-default btn-hallate-default">Enviar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- fin .page-body -->


      <div class="map separator-top">
        <div class="container-fluid">
          <div class="row">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.708705189874!2d-57.642020884452336!3d-25.280382683857578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x945da7f4c12aa7eb%3A0x9f96c87be8979b0!2sSecretaria+Nacional+de+la+Juventud!5e0!3m2!1ses-419!2spy!4v1517335840610" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

    </div><!-- fin .page-content -->
  </section>

<div class="overlay">
  <div class="message"></div>
</div>



  @section('footer')
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
</style>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".navbar-default .navbar-nav a").click(function(){
        //alert(this.hash);
        if (this.hash) {
          var hreff = '{{ url('') }}/' + this.hash;
          $(location).attr('href',hreff);
        }
      });
    })
  </script>
  <script type="text/javascript">
  $(function() {


  $('#form').on('submit', function() {
    $('.overlay').fadeIn(250);
    var $this = $(this);
    $this.find('button').text('Enviando...').attr('disabled', 'disabled');


    $.ajax({
        type: "POST",
        url: $this.attr('action'),
        data: $this.serialize(),
        dataType: "json",
        beforeSend: function(response){
       
          
        },
        ajaxSend: function(response){

        },
        error: function(response){
          $('.overlay .message').html(response.error).fadeIn(250, function(response) {
              setTimeout(function() {
                $('.overlay .message').html('').hide();
                $('.overlay').fadeOut(250, function() {
                  $this.find('button').text('Enviar').removeAttr('disabled');
                  //$this[0].reset();
                });
              }, 1500);
          });
        },
        success: function(response){
          console.log(response['text']);

          if (response.code == 1)
          {
            $('.overlay .message').html(response.text).fadeIn(250, function(response) {
                setTimeout(function() {
                  $('.overlay .message').html('').hide();
                  $('.overlay').fadeOut(450, function() {
                    $this.find('button').text('Enviar').removeAttr('disabled');
                  });
                }, 1500);
            });
          }else
          {                                      
            $('.overlay .message').html(response.text).fadeIn(250, function(response) {
                setTimeout(function() {
                  $('.overlay .message').html('').hide();
                  $('.overlay').fadeOut(250, function() {
                    $this.find('button').text('Enviar').removeAttr('disabled');
                    $this[0].reset();
                  });
                }, 1500);
            });
          }

        }
    });

    return false;
  });
})
</script>
  @endsection
