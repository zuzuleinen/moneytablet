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
                            <input type="number" value="" class="form-control" name="income_value" autocomplete="off">
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