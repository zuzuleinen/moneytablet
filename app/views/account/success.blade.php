@extends('layout/layout')
@section('content')
<h2>Congratulations!</h2>
<div class="alert alert-success">You have successfully created your account. You can <strong><a href="{{ URL::to('account/login') }}">log in</a></strong> now.</div>
@stop