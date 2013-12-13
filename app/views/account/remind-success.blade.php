@extends('layout/layout')
@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Check your e-mail</h2>
        <div class="alert alert-success">
            <strong>Well done!</strong> An e-mail has been sent to you with instructions for resetting your password. Go back to <strong><a href="{{URL::to('/')}}">home</a></strong>.
        </div>
    </div>
</div>
@stop   
