<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="delete-application" tabindex="-1" role="dialog" aria-labelledby="delete-application-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-application-label">Delete Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Please confirm that you want to delete this Application, though the Application name is recoverable
                    (if it's not taken by another user) the current access that this Application has will also be deleted.
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('manage_application', array('pub_id' => $_GET['pub_id'], 'action' => 'delete-application')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Delete</button>
            </div>
        </div>
    </div>
</div>