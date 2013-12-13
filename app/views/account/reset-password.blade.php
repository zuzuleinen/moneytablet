@extends('layout/layout')
@section('content')
<div class="row">
    <h2>Enter your new password</h2>
    @if (Session::has('error'))
    <div class="alert alert-danger">
        <strong>Oh snap! </strong>{{ trans(Session::get('reason')) }}
    </div>
    @endif
    <div class="col-md-6">
        <form class="form-horizontal" role="form" method="POST" action="">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="inputEmail3" class="col-md-2 control-label">Email</label>
                <div class="col-md-6">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-md-2 control-label">Password</label>
                <div class="col-md-6">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-md-2 control-label">Confirm Password</label>
                <div class="col-md-6">
                    <input type="password" name="password_confirmation" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-2">
                    <button type="submit" class="btn btn-danger">Change your password</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

