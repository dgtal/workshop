@extends('backpack::layout')

@section('content-header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.preview') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
    <section class="content-header no-print">
        <ul class="list-inline">
            <li>
                <a href="{{ url($crud->route) }}">
                    <i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}
                    <span class="text-lowercase">{{ $crud->entity_name_plural }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url($crud->route) }}/{{ $entry->id }}/edit">
                    <i class="fa fa-edit"></i> {{ trans('backpack::crud.edit_the_new_item') }}
                    <span class="text-lowercase"> {{ $crud->entity_name }}</span>
                </a>
            </li>
    </section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            {!! config('backpack.base.logo_lg') !!}
            <small class="pull-right">{{ Carbon\Carbon::now()->format('d/m/Y') }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>{{ config('backpack.base.project_data.company') }}</strong><br>
            {{ config('backpack.base.project_data.address') }}<br>
            {{ config('backpack.base.project_data.city') }}<br>
            {{ config('backpack.base.project_data.phone') }}<br>
            {{ config('backpack.base.project_data.email') }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>{{ $entry->vehicle->customer->fullname }}</strong><br>
            {{ $entry->vehicle->fullname }}<br/>
            {!! $entry->vehicle->customer->address ? $entry->vehicle->customer->address . '<br/>' : '' !!}
            @if ($entry->vehicle->customer->phones)
                {{ implode(', ', array_pluck($entry->vehicle->customer->phones, 'number')) }}<br/>
            @endif
            {!! $entry->vehicle->customer->email ? $entry->vehicle->customer->email . '<br/>' : '' !!}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Orden ID:</b> {{ $entry->id }}<br>
          <b>Fecha:</b> {{ $entry->created_at->format('d/m/Y') }}<br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <!--<th>Subtotal</th>-->
                </tr>
            </thead>
            <tbody>
                @foreach ($entry->tasks as $task)
                <tr>
                    <td>{{ $task['name'] }}</td>
                    <!--<td><input class="no-print" type="text" name="task_{{ $loop->index }}"/></td>-->
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-12">
          @if ( $entry->remarks )
          <p class="lead">Notas</p>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            {!! nl2br(e($entry->remarks)) !!}
          </p>
          @endif
        </div>
        <!-- /.col -->
        <!--
        <div class="col-xs-6">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
              </tr>
              <tr>
                <th>IVA (22%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr>
            </table>
          </div>
        </div>
        -->
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="javascript:window.print();" type="button" class="btn btn-success pull-right">
            <i class="fa fa-print"></i> Imprimir
          </a>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
@endsection