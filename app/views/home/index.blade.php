@extends('layout/layout')

@section('navbar')
@parent
<div class="jumbotron">
    <div class="container">
        <h1>Join us!</h1>
        <p>If you want to manage your personal finances in a simple manner you came to the right place.</p>
        <div>
            <a class="btn-auth btn-facebook large" href="{{URL::to('login/fb')}}">
                Sign up with <b>Facebook</b>
            </a>
            or
            <a class="red-link" href="{{URL::to('account/create')}}">Sign up by e-mail</a>
        </div>
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