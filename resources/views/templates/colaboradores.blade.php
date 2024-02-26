<section class="page colaboradores">
    <div class="page-banner banner-mini" @if($page->theImage()) style="background-image: url('{{ url('uploads/'.$page->theImage()->src) }}');" @else style="background-image: url('img/contacto.jpg');" @endif>
      @if($page->title)
      <div class="container inner-page-banner">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h1>{{ $page->title }}</h1>
          </div>
        </div>
      </div>
      @endif
    </div>
    <div class="page-content">
      <div class="page-body">
        <div class="container">
          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center">
              @if($logos)
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h2 class="page-title"></h2>
                  
                </div>
              </div>
              <div class="row">
                @foreach($logos as $logo)
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" data-id="{{ $logo->id }}">
                  <div class="img-container">
                    <a href="{{ $logo->url ? $logo->url : '#' }}">
                    <img src="{{ url('uploads/'.$logo->src) }}" class="img">
                    </a>
                  </div>
                </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>
        </div>
      </div><!-- fin .page-body -->
    </div><!-- fin .page-content -->
  </section>

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
    })
  </script>
  @endsection