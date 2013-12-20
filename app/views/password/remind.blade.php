@extends('layout/layout')
@section('content')

<div class="row">
    <div class="col-md-7">
        <h2>Forgot your password?</h2>
        <p>Enter your e-mail in the box bellow to reset your password:</p>
        @if (Session::has('error'))
        <div class="alert alert-danger">
            <strong>Oh snap! </strong>{{ trans(Session::get('error')) }}
        </div>
        @elseif (Session::has('status'))
        <div class="alert alert-success">
            <strong>Well done! </strong>{{ trans(Session::get('status')) }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-md-offset-1">
                <form action="{{ action('RemindersController@postRemind') }}" method="POST" class="form-horizontal" role="form">
                    <div class="form-group <?php echo ($errors->has('email')) ? 'has-error' : '' ?>">
                        <label for="email" class=" control-label">Your e-mail</label>
                        <input autocomplete="off" name="email" id="email" type="text" class="form-control" value="" />
                        <p class="help-block"><?php echo $errors->first('email'); ?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-md-11 col-md-offset-1">
                            <button type="submit" class="btn btn-default btn-danger btn-primary">Reset your password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
