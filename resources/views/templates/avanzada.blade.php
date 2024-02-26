  <section class="page">
    <div class="page-banner" style="background-image: url('img/busqueda.jpg');">
      <div class="container inner-page-banner">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h3>¡No esperes más!</h3>
            <h1>Las oportunidades están a un click de distancia</h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <form action="" method="post" class="form-rounded advanced-form">
    <section class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <input type="text" name="q" class="form-control" placeholder="Oportunidad/palabra clave">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <input type="date" name="fecha_publicacion" class="form-control" placeholder="Fecha de publicación">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section bg-default uncheck_group">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 text-left">
            <h2>Ejes</h2>
            <a href="#" class="uncheck_btn inline">Deshacer seleccion</a>

            @php $i = 1; @endphp
            @foreach($categories as $category)
            @php $i++ @endphp
            <div class="">
              <label for="categoria{{ $i }}">
                <input type="checkbox" name="categoria" id="categoria{{ $i }}" value="{{ $category->name }}" class="uncheck_input">
                {{ $category->name }}
              </label>
            </div>
            @endforeach
          </div>
          <div class="col-lg-6 text-left">
            <h2>Ofertantes</h2>
            <a href="#" class="uncheck_btn inline">Deshacer seleccion</a>
            @php $i = 1; @endphp
            @foreach($ofertante as $ofer)
            @php $i++ @endphp
            <div class="">
              <label for="ofertante{{ $i }}">
                <input type="checkbox" name="ofertante" id="ofertante{{ $i }}" value="{{ $ofer->lugar_aplicar }}" class="uncheck_input">
                {{ $ofer->lugar_aplicar }}
              </label>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>

    <section class="section uncheck_group">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-left">
            <h2>Departamento</h2>
            <a href="#" class="uncheck_btn inline">Deshacer seleccion</a>

            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento0">
                  <input type="checkbox" name="departamento" id="departamento0" class="uncheck_input" value="Concepción">
                  Concepción
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento1">
                  <input type="checkbox" name="departamento" id="departamento1" class="uncheck_input" value="Itapúa">
                  Itapúa
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento2">
                  <input type="checkbox" name="departamento" id="departamento2" class="uncheck_input" value="Amambay">
                  Amambay
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento3">
                  <input type="checkbox" name="departamento" id="departamento3" class="uncheck_input" value="San Pedro">
                  San Pedro
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento4">
                  <input type="checkbox" name="departamento" id="departamento4" class="uncheck_input" value="Misiones">
                  Misiones
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento5">
                  <input type="checkbox" name="departamento" id="departamento5" class="uncheck_input" value="Canindeyú">
                  Canindeyú
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento6">
                  <input type="checkbox" name="departamento" id="departamento6" class="uncheck_input" value="Cordillera">
                  Cordillera
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento7">
                  <input type="checkbox" name="departamento" id="departamento7" class="uncheck_input" value="Paraguari">
                  Paraguari
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento8">
                  <input type="checkbox" name="departamento" id="departamento8" class="uncheck_input" value="Presidente Hayes">
                  Presidente Hayes
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento9">
                  <input type="checkbox" name="departamento" id="departamento9" class="uncheck_input" value="Guairá">
                  Guairá
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento10">
                  <input type="checkbox" name="departamento" id="departamento10" class="uncheck_input" value="Alto Paraná">
                  Alto Paraná
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento11">
                  <input type="checkbox" name="departamento" id="departamento11" class="uncheck_input" value="Boquerón">
                  Boquerón
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento12">
                  <input type="checkbox" name="departamento" id="departamento12" class="uncheck_input" value="Caaguazú">
                  Caaguazú
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento13">
                  <input type="checkbox" name="departamento" id="departamento13" class="uncheck_input" value="Central">
                  Central
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento14">
                  <input type="checkbox" name="departamento" id="departamento14" class="uncheck_input" value="Alto Paraguay">
                  Alto Paraguay
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento15">
                  <input type="checkbox" name="departamento" id="departamento15" class="uncheck_input" value="Caazapá">
                  Caazapá
                </label>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label for="departamento16">
                  <input type="checkbox" name="departamento" id="departamento16" class="uncheck_input" value="Ñeembucú">
                  Ñeembucú
                </label>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-lg-12 text-left">
                <div class="">
                  <label for="discapacitados">
                    <input type="checkbox" name="discapacitados" id="discapacitados" value="1">
                    Sin costo
                  </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 text-right">
                <button class="btn btn-default btn-hallate-default">Buscar empleos</button>
                <button class="btn cancel">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </form>

  <section class="inspired" style="background-image: url('img/contacto.jpg');"></section>
