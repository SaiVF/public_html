<div class="inner-form">
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Titulo de la Oportunidad <span class="required">*</span></label>
		</div>
		<div class="col-lg-9">			
			{!! Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Institución Oferente <span class="required">*</span></label>
		</div>
		<div class="col-lg-9">
			<input type="text" name="empresa" class="form-control" value="{{ Auth::user()->empresa }}" readonly>
		</div>
	</div>
	{{--
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Imagen</label>
		</div>
		<div class="col-lg-9">
			<input type="file" name="imagen" class="form-control">
		</div>
	</div>
	--}}
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Nivel <span class="required">*</span></label>
			<p><em>Seleccioná el nivel o puesto de la oferta según corresponda.</em></p>
			<p><em>En caso de no encontrar la opción que buscas, tipeala.</em></p>
		</div>
		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-12">
					
					@if($oferta)
					{!! Form::select('nivel', $niveles, $oferta ? $niveles : null, ['class' => 'form-control niveles selects']) !!}
					@else
					<select class="form-control niveles" name="nivel" disabled>
						<option value="" disabled selected>-----</option>
					</select>
					@endif
					
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Tema <span class="required">*</span></label>
			<p><em>Seleccioná el tema de la oferta (la materia o el departamento) según corresponda.</em></p>
			<p><em>En caso de no encontrar la opción que buscas, tipeala.</em></p>
		</div>
		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-12">
					
					@if($oferta)
					{!! Form::select('tema', $temas, $oferta->tema ? $oferta->tema : null, ['class' => 'form-control temas selects']) !!}
					@else
					<select class="form-control temas" name="tema" disabled>
						<option value="" disabled selected>-----</option>
					</select>
					@endif
				</div>
			</div>
			
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Tiempo <span class="required">*</span></label>
			<p><em>Marcá en qué tiempos se desarrolla la oferta.</em></p>
			<p><em>En caso de no encontrar la opción que buscas, tipeala.</em></p>
		</div>
		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-12">
					
					@if($oferta)
					{!! Form::select('tiempo', $tiempo, null, ['class' => 'form-control tiempo selects']) !!}
					@else
					<select class="form-control tiempo" name="tiempo" id="tiempo" disabled>
						<option value="" disabled selected>-----</option>
					</select>
					@endif
				</div>
			</div>
			
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Cupos disponibles <span class="required">*</span></label>
			<p><em>Contanos cuántas vacancias o espacios hay disponible. En caso de no contar con una cantidad específico puede tipear las opciones "ilimitado" o "no aplica".</em></p>
		</div>
		<div class="col-lg-9">
			{!! Form::text('vacancias_disponibles', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
		</div>
	</div>
	
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Descripción <span class="required">*</span></label>
			<p><em>Describí brevemente la oportunidad.</em></p>
		</div>
		<div class="col-lg-9">
			{!! Form::textarea('descripcion', null, ['class' => 'form-control text']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Beneficios</label>
			<p><em>Describí cómo se beneficiará el joven con esta oportunidad.</em></p>
		</div>
		<div class="col-lg-9">
			{!! Form::textarea('beneficios', null, ['class' => 'form-control beneficios']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Financiamiento <span class="required">*</span></label>
			<p><em>Contanos qué opción de financiamiento aplica a esta oportunidad.</em></p>
		</div>
		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-12">
					@if($oferta)
					{!! Form::select('precio', $financiamiento, $oferta ? $financiamiento : null, ['class' => 'form-control financiamiento selects']) !!}
					@else
					<select class="form-control financiamiento" name="precio" id="financiamiento" disabled>
						<option value="" disabled selected>-----</option>
						
					</select>
					@endif
				</div>
			</div>
			
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Fecha de inicio de la oportunidad</label>
			<p><em>Contanos cuando inicia la oportunidad en sí. NO es lo mismo que la fecha previa de aplicación en caso haya alguna.</em></p>
		</div>
		<div class="col-lg-9">
			{!! Form::date('fecha_inicio', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Fecha de cierre de la oportunidad</label>
			<p><em>Contanos cuando cierra la oportunidad en sí. NO es lo mismo que la fecha previa de aplicación en caso haya alguna.</em></p>
		</div>
		<div class="col-lg-9">
			{!! Form::date('fecha_limite', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>La oferta se desarrolla en <span class="required">*</span></label>
			<p><em>Si la oferta se desarolla en varios países o departamentos, favor tipear "varios".</em></p>
		</div>
		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-4">
					{!! Form::select('pais_id', $paises, $oferta ? $oferta->pais_id : null, ['class' => 'form-control', 'id' => 'pais', 'placeholder' => 'Selecciona un País']) !!}
				</div>
				<div class="col-lg-4">
					{!! Form::select('departamento', $departamentos, $oferta ? $oferta->departamento : null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Departamento o Estado', 'id' => 'departamento']) !!}
				</div>
				<div class="col-lg-4">
					
					{!! Form::select('ciudad', $ciudades, $oferta ? $oferta->ciudad : null, ['class' => 'form-control ciudades', 'autocomplete' => 'off', 'placeholder' => 'Ciudad']) !!}
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Enlace oficial del programa *</label>
			<p><em>Compartí la web oficial o las redes sociales.</em></p>
		</div>
		<div class="col-lg-9">
			
			{!! Form::text('url', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Proceso de aplicación del programa</label>
			<p><em>Contanos cómo un joven puede aplicar a esta oportunidad.</em></p>
		</div>
		<div class="col-lg-9">
			
			
			{!! Form::textarea('proceso_aplicacion', null, ['class' => 'form-control proceso_aplicacion']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Fecha de inicio de proceso de aplicación</label>
		</div>
		<div class="col-lg-9">
			
			{!! Form::date('inicio_aplicacion', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Fecha de cierre de proceso de aplicación</label>
		</div>
		<div class="col-lg-9">
			
			{!! Form::date('cierre_aplicacion', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Requisitos</label>
			<p><em>Describa los requisitos a cumplir para acceder a la oportunidad.</em></p>
		</div>
		<div class="col-lg-9">
			
			{!! Form::textarea('requisito', null, ['class' => 'form-control requisito']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Enlace oficial para aplicar</label>
			<p><em>Compartí la web oficial o las redes sociales donde la persona debe ingresar para aplicar a la oportunidad.</em></p>
		</div>
		<div class="col-lg-9">
			
			{!! Form::text('uri_aplicacion', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>En caso de consultas contactar con <span class="required">*</span></label>
			<p><em>Dejanos el nombre, teléfono  y mail de la persona con quien contactar en caso de dudas.</em></p>
		</div>
		<div class="col-lg-9">
			
			{!! Form::text('contacto_con', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Modalidad</label>
		</div>
		<div class="col-lg-9">
			<div class="form-group">
	          {!! Form::select('modalidad', $modalidades, $oferta ? $oferta->modalidad : null, ['placeholder' => 'Sin modalidad', 'class' => 'form-control selects']) !!}
	        </div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Tags <span class="required">*</span></label>
			<p><em>Lista las palabras que quieras asociar a tu oferta. Estas etiquetas posicionarán a tu oferta entre los resultados de búsqueda. Ej: trabajar, tigo, sin costo, encarnación, recursos humanos</em></p>
		</div>
		<div class="col-lg-9">
			@if($oferta)
			<input type="text" name="tags[]" id="tags" value="{{ $oferta->id ? $selected_tags : '' }}" class="form-control tags">
			@else
			<input type="text" name="tags[]" id="tags" value="" class="form-control tags">
			@endif
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Postear como anónimo</label>
		</div>
		<div class="col-lg-9">
			<div class="form-group">
			<div class="material-switch">
                <input id="someSwitchOptionWarning" name="anonimo" type="checkbox" {{ old('anonimo') ? 'checked' : '' }} @if($oferta) @if($oferta->anonimo == 1) checked @endif @endif/>
                <label for="someSwitchOptionWarning" class="label-warning"></label>
            </div>
            </div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3 text-left colum-left">
			<label>Mostrar en el portal</label>
		</div>
		<div class="col-lg-9">
			<select class="form-control" name="state">
				<option value="1" @if($oferta) {{ $oferta->state == 1 ? 'selected' : '' }} @endif>Sí</option>
				<option value="0" @if($oferta) {{ $oferta->state == 0 ? 'selected' : '' }} @endif>No</option>
			</select>
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-lg-12">
		<div class="g-recaptcha" data-sitekey="6LfMWlgUAAAAAPwwaDAzP-7RYW8Q6J-X6rO87IvL"></div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-lg-12 text-left">
		<div class="form-group">
			<button class="btn btn-default btn-hallate-default" id="form-send">Enviar oportunidad</button>
		</div>
	</div>
</div>
