@extends('layout/layout')
@section('content')
<h4>Your tablet has been successfully closed!</h4>
<p>Hey, your tablet is closed now. Here are some statistics:</p>
<ul>
    <li><strong>Income:</strong> {{ floatval($tablet->total_amount) }}</li>
    <li><strong>Total expenses:</strong> {{ floatval($tablet->total_expenses) }}</li>
    <li><strong>Money left:</strong> {{ floatval($tablet->current_sum) }}</li>
    <li><strong>Total economies:</strong> {{ floatval($tablet->economies) }}</li>
</ul>
@stop