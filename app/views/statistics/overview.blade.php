@extends('layout/layout')
@section('content')
<div class="row">
    <h4>Statistics: Main overview</h4>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="chart_income" style="height: 400px;"></div>
        <div id="chart_expenses" style="height: 400px;"></div>
        <div id="chart_economies" style="height: 400px;"></div>
        <div id="chart_all_expenses" style="height: 400px;"></div>
    </div>
</div>

@stop

@section('footer-js-scripts')
@parent
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
{{ HTML::script('js/statistics/overview.js') }}
@stop