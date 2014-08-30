@extends('layout/layout')
@section('content')
<h2>Create your tablet</h2>
<form name="create-tablet-form" action="{{ URL::to('tablet/createPost') }}" method="POST" class="form-horizontal" role="form">
    <div class="form-group <?php echo ($errors->has('name')) ? 'has-error' : '' ?>">
        <label for="name" class="col-lg-2 control-label">Tablet name</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="name" id="name" type="text" class="form-control" value="<?php echo ($errors->has('name')) ? '' : $tabletName ?>">
        </div>
        <p class="help-block"><?php echo $errors->first('name'); ?></p>
    </div>
    <div class="form-group <?php echo ($errors->has('amount')) ? 'has-error' : '' ?>">
        <label for="amount" class="col-lg-2 control-label">Start income</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="amount" id="amount" type="number" class="form-control" value="<?php echo Session::get('amount') ?>" >
        </div>
        <span class="help-block"><?php echo $errors->first('amount'); ?></span>
    </div>
    <div class="form-group <?php echo ($errors->has('economies')) ? 'has-error' : '' ?>">
        <label for="economies" class="col-lg-2 control-label">Savings</label>
        <div class="col-lg-3">
            <input autocomplete="off" name="economies" id="economies" type="number" class="form-control" value="<?php echo Session::get('economies') ?>" >
        </div>
        <span class="help-block"><?php echo $errors->first('economies'); ?></span>
    </div>
    @if ($totalTablets > 0) 
    <div class="form-group">
        <div class="col-lg-3 col-lg-offset-2">
            <label for="recurrent_predictions">
                <input id="recurrent_predictions" name="recurrent_predictions" type="checkbox" value="1"> Add predictions from previous tablet.
            </label>
        </div>
    </div>
    @endif
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-3">
            <button type="submit" class="btn btn-lg btn-block btn-danger btn-primary">Create your tablet</button>
        </div>
    </div>
</form>
@stop
@section('footer-js-scripts')
@parent
{{ HTML::script('js/validate.min.js') }}
{{ HTML::script('js/tablet/create.js') }}
@stop