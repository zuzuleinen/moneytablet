@extends('layout/layout')
@section('content')
<div class="row">
    <h4>Dashboard</h4>
</div>
<div class="row">
    <input type="hidden" name="tablet_id" value="{{ $tablet->id }}" />
    <div class="col-md-5">
        <button id="add-new-prediction" type="button" class="btn btn-primary btn-xs">Add prediction</button>
        <button id="add-new-expense-button" type="button" class="btn btn-danger btn-xs" <?php echo ($predictions->count() ? '' : 'style="display: none"') ?>>Add expense</button>
        <button id="delete-predictions" type="button" class="btn btn-default btn-xs" style="display: none;">Delete</button>
        <table class="table table-condensed" id="table-prediction-expense" <?php echo ($predictions->count() ? '' : 'style="display: none"') ?>>
            <thead>
                <tr>
                    <th><input autocomplete="off" class="" id="prediction-all-checkbox" type="checkbox" value=""></th>
                    <th>Category</th>
                    <th>Prediction</th>
                    <th>Expense</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($predictions as $prediction)
                <tr @if ($prediction->value < 0) class="danger" @endif>
                     <td><input autocomplete="off" class="prediction-id-checkbox" type="checkbox" value="{{ $prediction->id }}"></td>
                    <td class="prediction-name">{{ $prediction->name }}</td>
                    <td class="prediction-value">{{ floatval($prediction->value) }}</td>
                    <td class="expense-value">{{ floatval($prediction->getTotalExpenses()) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6 col-md-offset-1">
        <button id="add-new-income" type="button" class="btn btn-success btn-xs">Add income</button>
        <button id="add-new-economy" type="button" class="btn btn-warning btn-xs">Add savings</button>
        <table class="table table-condensed" id="tablet-totals">
            <thead>
                <tr>
                    <th>Income</th>
                    <th>Total expenses</th>
                    <th>Current money</th>
                    <th>Savings</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="total-amount">{{ floatval($tablet->total_amount) }}</td>
                    <td id="total-expenses">{{ floatval($tablet->total_expenses) }}</td>
                    <td id="current-sum">{{ floatval($tablet->current_sum) }}</td>
                    <td id="tablet-economies">{{ floatval($tablet->economies) }}</td>
                </tr>
                <tr></tr>
                <tr></tr>
            </tbody>
        </table>
        @if (count($lastExpenses))
        <table class="table" style="margin-bottom: 0px;">
            <thead>
                <tr>
                    <th>Last expenses</th>
                    <th>Value</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lastExpenses as $lastExpense)
                <tr>
                    <td>{{ $lastExpense->name }}</td>
                    <td>{{ $lastExpense->value }}</td>
                    <td>{{ $lastExpense->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-bottom: 5px;" class="row">
            <div class="col-md-2 col-md-offset-10">
                <a href="{{URL::to('expense/all')}}">see all</a>
            </div>
        </div>
        @endif
        <div class="breadcrumb">
            <strong>Balance: </strong><span id="balance-value" @if ($tablet->getBalance() < 0) class="text-danger" @endif>{{ $tablet->getBalance() }}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1 col-md-offset-10">
        <button type="button" class="btn btn-danger" id="close-tablet-button">Close tablet</button>
    </div>
</div>

{{ $predictionModal }}
{{ $expenseModal }}
{{ $incomeModal }}
{{ $economyModal }}
{{ $closeTabletModal }}

@stop

@section('footer-js-scripts')
@parent
{{ HTML::script('js/validate.min.js') }}
{{ HTML::script('js/dashboard/tablet.js') }}
{{ HTML::script('js/dashboard/tablet_prediction.js') }}
{{ HTML::script('js/dashboard/tablet_expense.js') }}
{{ HTML::script('js/dashboard/tablet_income.js') }}
{{ HTML::script('js/dashboard/tablet_economy.js') }}
{{ HTML::script('js/dashboard/tablet/edit.js') }}
<script type="text/javascript">
    Tablet.init('#close-tablet-modal', '#close-tablet-button');
    Tablet.Prediction.init('#add-prediction-modal', '#add-new-prediction', '#tablet-totals');
    Tablet.Expense.init('#add-expense-modal', '#add-new-expense-button', '#tablet-totals');
    Tablet.Income.init('#add-income-modal', '#add-new-income', '#tablet-totals');
    Tablet.Economy.init('#add-economy-modal', '#add-new-economy', '#tablet-totals');
</script>
@stop