@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar no-print">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="http://placehold.it/45x45/00a65a/ffffff/&text={{ Auth::user()->name[0] }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/make') }}"><i class="fa fa-tag"></i> <span>Marcas</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/model') }}"><i class="fa fa-tag"></i> <span>Modelos</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/customer') }}"><i class="fa fa-users"></i> <span>Clientes</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/vehicle') }}"><i class="fa fa-car"></i> <span>Vehículos</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/order') }}"><i class="fa fa-wrench"></i> <span>Órdenes</span></a></li>
          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/user') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
