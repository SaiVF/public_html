@extends('layouts.backend')

@section('header')
<link rel="stylesheet" href="{{ url('assets/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Lista de <?php echo (isset($isEmpresas)&&$isEmpresas)?'empresas':'usuarios'; ?></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
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
                    <table id="table" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Sexo</th>
                                <th>Departamento</th>
                                <th>Ciudad</th>
                                <th>Rol</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
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
                <h4 class="modal-title">Eliminar usuario</h4>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar el usuario <span id="user_name"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                {!! Form::open(['method' => 'delete']) !!}
                    {!! Form::button('Sí, eliminar este usuario', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- DataTables -->
<script src="{{ url('js/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- page script -->
<script>
$(function () {
    $('#users-button').addClass('active').find('.treeview-menu').show();

    $(document).on('click', '.btn-delete', function() {
        $('#modal-default form').attr('action', $(this).data('route'));
        $('#user_name').text($(this).data('name'));
    });
    /*
    $('#table').DataTable({
        'order': [],
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
            'targets': [0, 5]
            }
        ]
    });
    */

   var table = $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('backend.users.data') }}',
    "columnDefs": [
      { "orderable": false, "targets": 3 },
      { "orderable": false, "targets": 4 },
      { "orderable": false, "targets": 5 }
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
    { data: 'id', name: 'users.id' },
    { data: 'name', name: 'users.name' },
    { data: 'email', name: "users.email" },
    { data: 'sexo', name: "users.sexo" },
    { data: 'departamento_name', name: "departamento" },
    { data: 'ciudad', name: "ciudad" },
    { data: 'roles.name', name: "roles.name" },
    { data: 'perfil', name: "perfil" },
    { data: 'action', name: "action" }
    ]
  });
    yadcf.init(table, [{
      column_number: 4,
      data : [@foreach($departamentos as $departamento) {value: '{{ $departamento->value }}', label: '{{ $departamento->label }}'}, @endforeach],
  }], {
    filters_position: 'header',
    filter_default_label: 'Filtro',
    style_class: 'form-control',
    reset_button_style_class: 'btn btn-default'
  });

});
</script>
@endsection