@extends('layout/layout')
@section('login')
@stop
@section('content')
<h2>MoneyTablet Login</h2>
<?php if (Session::get('loginFailed')): ?>
    <div class="alert alert-danger">
        <strong>Oh snap!</strong> The e-mail/password combination is incorrect.
    </div>
<?php endif; ?>
<?php if (Session::get('notconfirmed')): ?>
    <div class="alert alert-danger">
        <strong>Oh snap!</strong> Your account has not been confirmed.
    </div>
<?php endif; ?>
<form name="login-user-form" action="{{ URL::to('account/loginPost') }}" method="POST" class="form-horizontal" role="form">
    <div class="form-group <?php echo ($errors->has('email')) ? 'has-error' : '' ?>">
        <label for="email" class="col-lg-2 control-label">Email</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="email" type="text" class="form-control" id="email" placeholder="Type your e-mail" value="<?php echo Session::get('email') ?>">
        </div>
        <p class="help-block"><?php echo $errors->first('email'); ?></p>
    </div>
    <div class="form-group <?php echo ($errors->has('password')) ? 'has-error' : '' ?>">
        <label for="password" class="col-lg-2 control-label">Password</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <span class="help-block"><?php echo $errors->first('password'); ?></span>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="1">Keep me signed in<br>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <button id="create-account-button" type="submit" class="btn btn-danger btn-primary">Sign In</button> or <strong><a href="{{ URL::to('account/create') }}">Create your account</a></strong>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-4 col-md-offset-2">
        <p><a href="{{URL::to('password/remind')}}">Forgot your password?</a></p>
    </div>
</div>
@stop
@section('footer-js-scripts')
@parent
{{ HTML::script('js/validate.min.js') }}
{{ HTML::script('js/account/login.js') }}
@stop