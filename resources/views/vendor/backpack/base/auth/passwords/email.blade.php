@extends('backpack::layout-simple')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            {!! config('backpack.base.logo_lg') !!}
        </div>
        <!-- /.login-logo -->
        
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('backpack::base.reset_password') }}</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ url(config('backpack.base.route_prefix', 'admin').'/password/email') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="{{ trans('backpack::base.email_address') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>


                <div class="row">
                    <div class="col-xs-offset-7 col-xs-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ trans('backpack::base.send_reset_link') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>

            </form>

            <a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.already_registered') }}</a>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection