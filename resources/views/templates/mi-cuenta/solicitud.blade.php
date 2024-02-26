@extends('layouts.frontend')

@section('content')
<section class="page mi-cuenta">
    <div class="page-content">
      <div class="page-body">
        <div class="container">
        	@if(session()->has('success'))
	          <div class="row">
	            <div class="col-lg-12">
	              <div class="alert alert-warning">{{ session()->get('success') }}</div>
	            </div>
	          </div>
	          <div class="row">
	          	<div class="col-lg-12">
	          		<a href="{{ route('mi-cuenta.edit') }}" class="btn btn-default btn-hallate-default">Ir a mi cuenta</a>
	          	</div>
	          </div>
	          @else
        	<div class="row">
	            <div class="col-lg-12 text-center">
	              {!! Form::open([
	                'route' => 'empresa',
	                'class' => 'form-rounded'
	              ]) !!}

	                <div class="row">
	                  <div class="col-lg-12 text-center">
	                    <p>Confirma tu solitud para ser colaborador en <b>Hallate.</b></p>
	                  </div>
	                </div>
	                {{--
	                <div class="row">
	                  <div class="col-lg-12">
	                    <div class="form-group">
	                      <textarea class="form-control" name="mensaje" placeholder="Mensaje" rows="6"></textarea>
	                    </div>
	                  </div>
	                </div>
	                --}}

	                <div class="row">
	                  <div class="col-lg-12 text-center">
	                    <div class="form-group">
	                      <button class="btn btn-default btn-hallate-default">Solicitar</button>
	                    </div>
	                  </div>
	                </div>
	              {!! Form::close() !!}
	            </div>
	          </div>
	          @endif
        </div>
      </div>
    </div>
</section>
@endsection