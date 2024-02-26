@extends('layouts.backend')

@section('header')
  <link rel="stylesheet" href="{{ url('assets/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de ofertas @if($ofertas)({{ $ofertas->count() }})@endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Ofertas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                  
                    <th># ID</th>
                    <th>Destacado</th>
                    <th>Fuente</th>
                    <th>Propietario</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de expiración</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar oferta</h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar el oferta <span id="oferta_title"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              {!! Form::open(['method' => 'post']) !!}
                    {!! Form::button('Sí, eliminar oferta', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Sortable -->
<script src="{{ url('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<!-- page script -->
<!-- DataTables -->
<script src="{{ url('js/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
$(function() {
  /*
  if($('#table tbody tr').length > 1) $('#table').DataTable({
    'order': [[ 3, 'desc' ]],
    'pageLength': 50,
    'language': {
      'lengthMenu': 'Mostrando _MENU_ registros por página',
      'zeroRecords': 'No hay registros',
      'info': 'Mostrando página _PAGE_ de _PAGES_',
      'infoEmpty': 'No hay registros',
      'infoFiltered': '(de un total de _MAX_ registros)',
      'search': 'Buscar',
      'paginate': {
        'first':      'Inicio',
        'last':       'Fin',
        'next':       'Siguiente',
        'previous':   'Anterior'
      }
    },
    'columnDefs': [
      {
        'orderable': false,
        'targets': [4]
      }
    ]
  });
  */

  var table = $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('backend.ofertas.data') }}',
      "columnDefs": [
      { "orderable": true, "targets": 0 },
      { "orderable": false, "targets": 1 },
      { "orderable": false, "targets": 4 },
      { "orderable": false, "targets": 7 }
    ],
      
    'order': [[ 1, 'desc' ]],
    'pageLength': 10,
    'language': {
      'lengthMenu': 'Mostrando _MENU_ registros por página',
      'zeroRecords': 'No hay registros',
      'info': 'Mostrando página _PAGE_ de _PAGES_',
      'infoEmpty': 'No hay registros',
      'infoFiltered': '(de un total de _MAX_ registros)',
      'search': 'Buscar',
      'paginate': {
        'first':      'Inicio',
        'last':       'Fin',
        'next':       'Siguiente',
        'previous':   'Anterior'
      }
    },
    
    columns: [
    { data: 'id', name: 'id' },
    { data: 'featured', name: 'featured' },
    { data: 'source', name: "source" },
    { data: 'user.name', name: "name", searchable: false},
    { data: 'title', name: "title" },
    { data: 'categories.0.name', name: "name", searchable: false},
    { data: 'fecha_inicio', name: "ofertas.fecha_inicio" },
    { data: 'fecha_limite', name: "ofertas.fecha_limite" },
    { data: 'action', name: "action" }

    ]
  });
  yadcf.init(table, [
    {

      column_number: 2,
      data : [@foreach($source as $s) {value: '{{ $s->value }}', label: '{{ $s->label }}'}, @endforeach],
  }], {
    filters_position: 'header',
    filter_default_label: 'Filtro',
    style_class: 'form-control',
    reset_button_style_class: 'btn btn-default'
  });
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });

  


  $(document).on('click', '.btn-delete', function(){
    $('.modal form').attr('action', $(this).data('route'));
    $('#oferta_title').text($(this).data('title'));
  });

  $('#table tbody').sortable({
    update: function (event, ui) {
      var data = $(this).sortable('serialize');
        $.post('ofertas/ajax', data, function(response) {
      });
    }
  });
  $(document).on('change', '.featured', function(){
    var id = $('input', this).data('id');
   
    $.post('{{ route('ajax.featured') }}', { id: id }, function(response) {});
  })

  $('#ofertas-button').addClass('active').find('.treeview-menu').show();
});
</script>
<style type="text/css">
.custom-control-input {
    position: absolute;
    z-index: -1;
    opacity: 0;
}
  .custom-checkbox {
  min-height: 1rem;
  padding-left: 0;
  margin-right: 0;
  cursor: pointer; 
}
  .custom-checkbox .custom-control-indicator {
    content: "";
    display: inline-block;
    position: relative;
    width: 30px;
    height: 10px;
    background-color: #818181;
    border-radius: 15px;
    margin-right: 10px;
    -webkit-transition: background .3s ease;
    transition: background .3s ease;
    vertical-align: middle;
    margin: 0 16px;
    box-shadow: none; 
  }
    .custom-checkbox .custom-control-indicator:after {
      content: "";
      position: absolute;
      display: inline-block;
      width: 18px;
      height: 18px;
      background-color: #f1f1f1;
      border-radius: 21px;
      box-shadow: 0 1px 3px 1px rgba(0, 0, 0, 0.4);
      left: -2px;
      top: -4px;
      -webkit-transition: left .3s ease, background .3s ease, box-shadow .1s ease;
      transition: left .3s ease, background .3s ease, box-shadow .1s ease; 
    }
  .custom-checkbox .custom-control-input:checked ~ .custom-control-indicator {
    background-color: #84c7c1;
    background-image: none;
    box-shadow: none !important; 
  }
    .custom-checkbox .custom-control-input:checked ~ .custom-control-indicator:after {
      background-color: #84c7c1;
      left: 15px; 
    }
  .custom-checkbox .custom-control-input:focus ~ .custom-control-indicator {
    box-shadow: none !important; 
  }
</style>
@endsection