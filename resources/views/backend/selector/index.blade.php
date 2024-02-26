@extends('layouts.backend')



@section('header')

  <link rel="stylesheet" href="{{ url('assets/plugins/datatables/dataTables.bootstrap.css') }}">

@endsection



@section('content')

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Lista de países

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li class="active">Selectores</li>

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

              <table id="table" class="table table-bordered table-striped">

                <thead>

                  <tr>

                    <th>Title</th>
                    <th>Tipo</th>
                    <th>Categoría</th>

                    <th></th>

                  </tr>

                </thead>

                <tbody>

                @if($selectores->isEmpty())

                <tr>

                  <td colspan="5" align="center">No hay selectores</td>

                </tr>

                @else

                @foreach($selectores as $selector)

                <tr id="post_{{ $selector->id }}">

                  <td><a href="{{ route('selector.edit', $selector->id) }}">{{ $selector->title }}</a></td>

                  <td>{{ $selector->type }}</td>
                  <td>{{ $selector->category ? $selector->category->name : '' }}</td>



                  <td class="last">

                    <a href="{{ route('selector.edit', $selector->id) }}" class="btn btn-success btn-xs">

                      <span class="fa fa-edit"></span> Editar

                    </a>

                    <a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-title="{{ $selector->title }}" data-route="{{ route('selector.destroy', $selector->id) }}">

                      <span class="fa fa-close"></span> Eliminar

                    </a>

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

                <h4 class="modal-title">Eliminar selector</h4>

            </div>

            <div class="modal-body">

                <p>¿Estás seguro de eliminar el selector <span id="pais_title"></span>?</p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>

                {!! Form::open(['method' => 'delete']) !!}

                    {!! Form::button('Sí, eliminar selector', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}

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

<script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ url('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>

$(function() {

  if($('#table tbody tr').length > 1) $('#table').DataTable({

    'order': [[ 1, 'desc' ]],

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

        'targets': [0]

      }

    ]

  });

  $.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': '{{ csrf_token() }}'

    }

  });



  $(document).on('click', '.btn-delete', function() {

    $('.modal form').attr('action', $(this).data('route'));

    $('#selector_title').text($(this).data('title'));

  });



  $('#selector-button').addClass('active').find('.treeview-menu').show();

});

</script>

@endsection