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
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ App\Models\Customer::count() }}</h3>

                    <p>Clientes</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="customer" class="small-box-footer">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ App\Models\Vehicle::count() }}</h3>

                <p>Vehículos</p>
            </div>
            <div class="icon">
                <i class="fa fa-car"></i>
            </div>
            <a href="vehicle" class="small-box-footer">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ App\Models\Order::count() }}</h3>

                <p>Órdenes</p>
            </div>
            <div class="icon">
                <i class="fa fa-wrench"></i>
            </div>
            <a href="order" class="small-box-footer">Ver todas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ App\Models\Order::where(['status' => 'Trabajando'])->count() }}</h3>

                <p>Órdenes en curso</p>
            </div>
            <div class="icon">
                <i class="fa fa-wrench"></i>
            </div>
            <a href="order?working=true" class="small-box-footer">Ver todas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
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
                                        <a href="order/{{ $order->id }}">{{ $order->vehicle->customer->fullname }}</a>
                                    </td>
                                    <td>
                                        <a href="order/{{ $order->id }}">{{ $order->vehicle->fullname }}</a>
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
