@extends('backpack::layout-simple')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            {!! config('backpack.base.logo_lg') !!}
        </div>
        <!-- /.login-logo -->
        
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('backpack::base.login') }}</p>

            <form action="{{ url(config('backpack.base.route_prefix').'/login') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="{{ trans('backpack::base.email_address') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="{{ trans('backpack::base.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                            <input type="checkbox"> {{ trans('backpack::base.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('backpack::base.login_action') }}</button>
                    </div>
                    <!-- /.col -->
                </div>

            </form>

            <a href="{{ url(config('backpack.base.route_prefix', 'admin').'/password/reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a>
            <br/>
            <a href="{{ url(config('backpack.base.route_prefix', 'admin').'/register') }}">{{ trans('backpack::base.register') }}</a>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
