  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Auth::user()->theImage() }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{ Auth::user()->theRole()->name }}</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li>
          <a href="{{ url('backend/dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Inicio</span>
          </a>
        </li>
        <li class="header">Sitio Web</li>
        @if(\Auth::user()->isAdmin())
        <li class="treeview" id="pages-button">
          <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Páginas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('pages.index') }}"><i class="fa fa-circle-o"></i> Lista de páginas</a></li>
            <li><a href="{{ route('pages.create') }}"><i class="fa fa-circle-o"></i> Añadir página</a></li>
          </ul>
        </li>
        @endif
        <li class="treeview" id="ofertas-button">
          <a href="#">
            <i class="fa fa-star"></i> <span>Ofertas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="{{ route('ofertas.create') }}"><i class="fa fa-circle-o"></i> Añadir oferta</a></li>
              <li><a href="{{ route('backend.ofertas.borradores') }}"><i class="fa fa-circle-o"></i> Lista de borradores</a></li>
            <li><a href="{{ route('ofertas.index') }}"><i class="fa fa-circle-o"></i> Lista de ofertas</a></li>
            <li><a href="{{ route('backend.ofertas.vencidas') }}"><i class="fa fa-circle-o"></i> Vencidas</a></li>
            <li><a href="{{ route('backend.categories.index', 3) }}"><i class="fa fa-circle-o"></i> Categorías</a></li>
          </ul>
        </li>
        @if(Auth::user()->isAdmin() OR Auth::user()->isModerador())
        <li class="header">Administración</li>
        <li class="treeview" id="users-button">
          <a href="#">
            <i class="fa fa-users"></i> <span>Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> Lista de usuarios</a></li>
            <li><a href="{{ route('users.empresas') }}"><i class="fa fa-circle-o"></i> Lista de empresas</a></li>
            <li><a href="{{ route('backend.users.solicitudes') }}"><i class="fa fa-circle-o"></i> Lista de solicitudes</a></li>
            <li><a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i> Añadir usuario</a></li>
          </ul>
        </li>
        <li id="options-button">
          <a href="{{ route('options.index') }}">
            <i class="fa fa-cog"></i> <span>Opciones</span>
          </a>
        </li>
        <li id="paises-button">
          <a href="{{ route('paises.index') }}">
            <i class="fa fa-globe" aria-hidden="true"></i> <span>Países</span>
          </a>
        </li>

        <li class="treeview" id="selector-button">
          <a href="#">
            <i class="fa fa-filter" aria-hidden="true"></i> <span>Selector</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('selector.index') }}"><i class="fa fa-circle-o"></i> Lista de opciones</a></li>
            <li><a href="{{ route('selector.create') }}"><i class="fa fa-circle-o"></i> Añadir opción</a></li>
          </ul>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
