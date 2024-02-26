@if(count($lugares))
<option selected disabled></option>
@foreach($lugares as $lugar)
<option value="{{ $lugar }}">{{ $lugar }}</option>
@endforeach
@else
<option selected value="">Dale</option>
@endif