@extends('layout/layout')
@section('content')
<h4>Dashboard</h4>
<div class="row">
    <div class="col-md-4">
        <button id="add-new-prediction" type="button" class="btn btn-default btn-xs">Add prediction</button>
        <button id="add-new-expense-button" type="button" class="btn btn-default btn-xs">Add expense</button>
    </div>
    <div class="col-md-6 col-md-offset-2">
        <button id="add-new-income" type="button" class="btn btn-default btn-xs">Add income</button>
        <button id="add-new-economy" type="button" class="btn btn-default btn-xs">Add economy</button>
    </div>
</div>
<div class="row">
    <input type="hidden" name="tablet_id" value="{{ $tablet->id }}">
    <div class="col-md-4">
        <table class="table table-hover table-condensed" id="table-prediction-expense" <?php echo ($predictions->count() ? '' : 'style="display: none"') ?>>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Prediction</th>
                    <th>Expense</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($predictions as $prediction)
                <tr>
                    <td><input class="form-control prediction-id-checkbox" type="checkbox" value="{{ $prediction->id }}"></td>
                    <td>{{ $prediction->name }}</td>
                    <td class="prediction-value">{{ floatval($prediction->value) }}</td>
                    <td class="expense-value">{{ floatval($prediction->getTotalExpenses()) }}</td>
                </tr>
                @endforeach
                <!--
                <tr>
                    <td>Fun</td>
                    <td>50</td>
                    <td><span class="text-muted">0</span></td>
                </tr><!--
                <tr>
                    <td>Car</td>
                    <td>100</td>
                    <td><input class="form-control" type="text"></td>
                </tr>-->
            </tbody>
        </table>
    </div>
    <div class="col-md-6 col-md-offset-2">
        <table class="table table-condensed" id="tablet-totals">
            <thead>
                <tr>
                    <th>Income</th>
                    <th>Total expenses</th>
                    <th>Current money</th>
                    <th>Economies</th>
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
        <div class="breadcrumb">
            <strong>Balance: </strong><span id="balance-value">{{ $tablet->getBalance() }}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-11">
        <button type="button" class="btn btn-danger ">Close tablet</button>
    </div>
</div>

<!-- Add prediction modal -->
<div class="modal fade" id="add-prediction-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add a new prediction</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="add-prediction-form" name="add-prediction-form">
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="name">Name</label>
                        <div class="col-lg-5">
                            <input type="text" value="" class="form-control" name="name" autocomplete="off">
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="value">Value</label>
                        <div class="col-lg-5">
                            <input type="text" value="" class="form-control" name="value" autocomplete="off">
                        </div>
                        <span class="help-block"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="prediction-save">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add expense modal -->
<div class="modal fade" id="add-expense-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add a new expense</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="add-expense-form" name="add-expense-form">
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="prediction_id">Category</label>
                        <div class="col-lg-5">
                            <select name="prediction_id" class="form-control">
                                @foreach ($predictions as $prediction)
                                <option value="{{ $prediction->id }}">{{ $prediction->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="expense_value">Value</label>
                        <div class="col-lg-5">
                            <input type="text" value="" class="form-control" name="expense_value" autocomplete="off">
                        </div>
                        <span class="help-block"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="expense-save">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Add income modal -->
<div class="modal fade" id="add-income-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add a new income</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="add-income-form" name="add-income-form">
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="income_value">Value</label>
                        <div class="col-lg-5">
                            <input type="text" value="" class="form-control" name="income_value" autocomplete="off">
                        </div>
                        <span class="help-block"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="income-save">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Add economy modal -->
<div class="modal fade" id="add-economy-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add a new economy</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" id="add-economy-form" name="add-economy-form">
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="economy_value">Value</label>
                        <div class="col-lg-5">
                            <input type="text" value="" class="form-control" name="economy_value" autocomplete="off">
                        </div>
                        <span class="help-block"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="economy-save">Save changes</button>
            </div>
        </div>
    </div>
</div>

@stop
@section('footer-js-scripts')
@parent
{{ HTML::script('js/validate.min.js') }}
{{ HTML::script('js/dashboard/tablet_prediction.js') }}
{{ HTML::script('js/dashboard/tablet_expense.js') }}
{{ HTML::script('js/dashboard/tablet_income.js') }}
{{ HTML::script('js/dashboard/tablet_economy.js') }}
<script type="text/javascript">
    config = {};
    config.tabletId = $("input[name='tablet_id']");
    config.addPredictionModal = $('#add-prediction-modal');
    config.addNewPredictionButton = $('#add-new-prediction');
    config.addPredictionForm = $('#add-prediction-form');
    config.savePredictionButton = $('#prediction-save');
    config.tablePredictionExpense = $('#table-prediction-expense');
    Tablet.Prediction.init(config);

    Tablet.Expense.init('#add-expense-modal', '#add-new-expense-button', '#tablet-totals');
    Tablet.Income.init('#add-income-modal', '#add-new-income', '#tablet-totals');
    Tablet.Economy.init('#add-economy-modal', '#add-new-economy', '#tablet-totals');
</script>
@stop