@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Clientes</span>
              <span class="info-box-number">{{ App\Models\Customer::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-car"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Vehículos</span>
              <span class="info-box-number">{{ App\Models\Vehicle::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-wrench"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Órdenes</span>
              <span class="info-box-number">{{ App\Models\Order::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-wrench"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Órdenes en curso</span>
              <span class="info-box-number">{{ App\Models\Order::where(['status' => 'Trabajando'])->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

    <div class="row">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Últimos clientes</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Models\Customer::orderBy('created_at', 'DESC')->take(10)->get() as $customer)
                                <tr>
                                    <td>
                                        <a href="customer/{{ $customer->id }}/edit">{{ $customer->fullname }}</a>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="customer/create" class="btn btn-sm btn-info btn-flat pull-left">Crear nuevo cliente</a>
                    <a href="customer" class="btn btn-sm btn-default btn-flat pull-right">Ver todos</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box-info -->
        </div>

        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Últimas órdenes</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Vehículo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Models\Order::with('vehicle.customer')->orderBy('created_at', 'DESC')->take(10)->get() as $order)
                                <tr>
                                    <td>
                                        <a href="customer/{{ $order->vehicle->customer->id }}/edit">{{ $order->vehicle->customer->fullname }}</a>
                                    </td>
                                    <td>
                                        <a href="vehicle/{{ $order->vehicle->id }}/edit">{{ $order->vehicle->fullname }}</a>
                                    </td>
                                    <td><span class="label label-info">{{ $order->status }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="order/create" class="btn btn-sm btn-info btn-flat pull-left">Crear nueva orden</a>
                    <a href="order" class="btn btn-sm btn-default btn-flat pull-right">Ver todas</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box-info -->
        </div>
    </div>
@endsection
