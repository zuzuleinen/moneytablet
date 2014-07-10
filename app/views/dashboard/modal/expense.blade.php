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
                                <option value="0">Select a category</option>
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
                            <input type="number" value="" class="form-control" name="expense_value" autocomplete="off">
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