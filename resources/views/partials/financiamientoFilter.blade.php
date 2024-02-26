@if(count($financiamiento))
<option value="">Cualquier tipo de financiamiento</option>
@foreach($financiamiento as $finan)
<option value="{{ $finan->precio }}">{{ $finan->precio }}</option>
@endforeach
@else
<option value="">Cualquier tipo de financiamiento</option>
@endif