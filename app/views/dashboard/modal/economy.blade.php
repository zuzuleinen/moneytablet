<div class="modal fade" id="add-economy-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add savings</h4>
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