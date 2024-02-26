@extends('layouts.backend')

@section('header')
<link rel="stylesheet" href="{{ url('assets/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Lista de solicitudes</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Solicitudes</li>
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
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Aprobador por</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($solicitudes->isEmpty())
                            <tr>
                                <td colspan="6" align="center">No hay usuarios</td>
                            </tr>
                            @else
                            @foreach($solicitudes as $user)
                            <tr>
                                <td class="cell-stretch">{{ $i++ }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->user_id) }}">{{ $user->usuario->name }}</a>
                                </td>
                                <td>{{ $user->usuario->email }}</td>
                                <td>{{ $user->usuario->theRole()->name }}</td>
                                <td>@if($user->estado == 1) Aprobado @else En revisión @endif</td>
                                <td>@if($user->approved()){{ $user->approved()->name }}@else - @endif</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @if($user->estado == 1)  @else <a href="{{ url('backend/users/'.$user->user_id.'/solicitud') }}" class="btn btn-xs btn-success">Aprobar</a> @endif
                                    <a href="{{ route('users.solicitud.denegar', ['id' => $user->id, 'user_id' => $user->user_id]) }}" class="btn btn-xs btn-danger">Denegar</a>
                                    
                                </td>
                                
                            </tr>
                            @endforeach     
                            @endif
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
<script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- page script -->
<script>
$(function () {
    $('#users-button').addClass('active').find('.treeview-menu').show();

    $('.btn-delete').on('click', function() {
        $('#modal-default form').attr('action', $(this).data('route'));
        $('#user_name').text($(this).data('name'));
    });

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
});
</script>
@endsection