@extends('layout/layout')
@section('content')
<h3>Welcome!</h3>
@if ($tabletsSoFar == 0) 
<p>Thank you for creating an account to MoneyTablet. You already made the first step on putting your personal finances in order.</p>
<p>First, you should read the <strong><a href="{{ URL::to('how-to') }}">short introduction</a></strong> to see what is all about.</p>
<p>When you finish reading, you can start creating your <strong><a href="{{ URL::to('tablet/create') }}">first tablet</a></strong>.</p>
@else 
<p>It seems that you don't have an active tablet yet. Would you like to <strong><a href="{{ URL::to('tablet/create') }}">create</a></strong> a new one?</p>
@endif
@stop