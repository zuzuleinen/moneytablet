@extends('layout/layout')
@section('content')
<h3>Welcome!</h3>
<p>It seems that you don't have an active tablet yet. Would you like to <strong><a href="{{ URL::to('tablet/create') }}">create</a></strong> a new one?</p>
@stop