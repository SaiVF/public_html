@extends('layouts.frontend')

@section('content')
  <section class="page terminos-page">
    <div class="section container">
      <div class="text-center">
        <h2>{{ $page->title }}</h2>
        <p>{{ $page->excerpt }}</p>
      </div>
      <hr>
      {!! $page->content()->first()->content !!}
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
    })
  </script>
  @endsection