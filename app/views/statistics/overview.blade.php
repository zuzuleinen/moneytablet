@extends('layout/layout')
@section('content')
<div class="row">
    <h4>Statistics: Main overview</h4>
</div>

@if ($allowToViewStatistics === true)
<div class="row">
    <div class="col-md-12">
        <div id="chart_income" style="height: 400px;"></div>
        <div id="chart_expenses" style="height: 400px;"></div>
        <div id="chart_economies" style="height: 400px;"></div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-6">
        <p>You will have access to statistics only after 2 closed tablets.</p>
    </div>
</div>
@endif

@stop

@section('footer-js-scripts')
@parent
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
{{ HTML::script('js/statistics/overview.js') }}
@stop