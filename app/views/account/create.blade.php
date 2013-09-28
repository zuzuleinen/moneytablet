@extends('layout/layout')
@section('content')
<h2>Create an account</h2>
<form name="create-user-form" action="{{ URL::to('account/createPost') }}" method="POST" class="form-horizontal" role="form">
    <div class="form-group <?php echo ($errors->has('email')) ? 'has-error' : '' ?>">
        <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="email" type="text" class="form-control" id="inputEmail" placeholder="Type your e-mail" value="<?php echo Session::get('email') ?>">
        </div>
        <p class="help-block"><?php echo $errors->first('email'); ?></p>
    </div>
    <div class="form-group <?php echo ($errors->has('password1')) ? 'has-error' : '' ?>">
        <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="password1" type="password" class="form-control" id="inputPassword1" placeholder="Password">
        </div>
        <span class="help-block"><?php echo $errors->first('password1'); ?></span>
    </div>
    <div class="form-group <?php echo ($errors->has('password2')) ? 'has-error' : '' ?>">
        <label for="inputPassword2" class="col-lg-2 control-label">Re-type password</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="password2" type="password" class="form-control" id="inputPassword2" placeholder="Re-type password">
        </div>
        <span class="help-block"><?php echo $errors->first('password2'); ?></span>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <button id="create-account-button" type="submit" class="btn btn-primary">Create your account</button>
        </div>
    </div>
</form>
@stop
@section('footer-js-scripts')
@parent
{{ HTML::script('js/validate.min.js') }}
{{ HTML::script('js/account/create.js') }}
@stop