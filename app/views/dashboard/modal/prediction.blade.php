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
                            <input id="prediction-name" type="text" value="" class="form-control" name="name" autocomplete="off">
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group ">
                        <label class="col-lg-2 control-label" for="value">Value</label>
                        <div class="col-lg-5">
                            <input type="number" value="" class="form-control" name="value" autocomplete="off">
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