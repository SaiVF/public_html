@if(count($categorias))
<option value="" disabled selected>Selecciona una categoría</option>
@foreach($categorias as $categoria)
<option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
@endforeach
@endif