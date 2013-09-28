@extends('layout/layout')

@section('navbar')
@parent
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>Hello!</h1>
        <p>If you want to manage your personal finances in a simple manner you came to the right place.</p>
        <p><a href="{{ URL::to('account/create') }}" class="btn btn-primary btn-danger btn-lg">Create an account &raquo;</a></p>
    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-lg-4">
        <h2>Simple</h2>
        <p>This is the simplest app you'll ever find.</p>
    </div>
    <div class="col-lg-4">
        <h2>Private</h2>
        <p>Your data will be safe with us and will not be shared with nobody.</p>
    </div>
    <div class="col-lg-4">
        <h2>Free</h2>
        <p>Every feature from this app is completely free.</p>
    </div>
</div>
@stop