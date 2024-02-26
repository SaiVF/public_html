<option value="" readonly disabled selected>-----</option>
@if(count($temas))
@foreach($temas as $tema)
<option value="{{ $tema }}">{{ $tema }}</option>
@endforeach
@endif

