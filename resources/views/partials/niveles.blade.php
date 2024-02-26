<option value="" readonly disabled selected>-----</option>
@if(count($niveles))
@foreach($niveles as $nivel)
<option value="{{ $nivel }}">{{ $nivel }}</option>
@endforeach
@endif
