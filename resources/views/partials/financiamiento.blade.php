<option value="" readonly disabled selected>-----</option>
@if(count($financiamientos))
@foreach($financiamientos as $financiamiento)
<option value="{{ $financiamiento }}">{{ $financiamiento }}</option>
@endforeach
@endif
