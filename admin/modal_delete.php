<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete | Record</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete?</p>
                <p id="myP"></p>
            </div>
            <div class="modal-footer justify-content-right">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                <a id="btnDeleteOK" href="<?php $page_url ?>?action=delete&recid="
                    class="btn btn-outline-light">OK</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>