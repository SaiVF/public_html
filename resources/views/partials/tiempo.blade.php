<option value="" readonly disabled selected>-----</option>
@if(count($tiempos))
@foreach($tiempos as $tiempo)
<option value="{{ $tiempo }}">{{ $tiempo }}</option>
@endforeach
@endif

