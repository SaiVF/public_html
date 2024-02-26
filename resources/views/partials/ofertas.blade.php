@if(count($ofertas))
@foreach($ofertas as $o)
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
  <a href="{{ url('oferta/'.$o->id.'/'.str_slug($o->title)) }}" class="card-link">
    <div class="card adjust-height">
      <div class="image-container" @if($o->theCategory()) style="background-color:{{ $o->theColor('fondo')}};" @endif>
        <div class="image-container-inner">
        @if($o->theCategory())
        {!! $o->theIcon() !!}
        <p>{{ $o->theCategory()->name }}</p>
        @else
        
        @endif
        </div>
      </div>
      <div class="card-body text-center">
        @if($o->theCategory())
        <div class="text-center">
          <span class="category" style="background-color:{{ $o->theColor('fondo')}}; color: {{ $o->theColor('principal')}};">{{ $o->theCategory()->name }}</span>
        </div>
        @endif
        <div class="text-left">
          <h4>{{ titleCase(str_limit($o->title, 35)) }}</h4>
          <span class="info">{{ $o->lugar_aplicar }}</span>
          <span class="date">
            @if($o->pais)
            @if($o->pais->icon)
            <img src="{{ url('uploads/'.$o->pais->icon) }}" class="icon">
            @endif
            @endif 
            {{ $o->pais ? $o->pais->nombre : '' }} @if($o->fecha_limite) - <i class="fa fa-hourglass-half" aria-hidden="true"></i> {{ $o->theDate() }} @else - Constante @endif  
          </span>
        </div>
      </div>
    </div>
  </a>
</div>
@endforeach
@endif