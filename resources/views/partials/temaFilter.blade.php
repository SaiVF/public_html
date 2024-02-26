@if(count($temas))
<option value="">Cualquier tema</option>
@foreach($temas as $temas)
<option value="{{ $temas->tema }}">{{ $temas->tema }}</option>
@endforeach
@else
<option value="">Cualquier tema</option>
@endif
