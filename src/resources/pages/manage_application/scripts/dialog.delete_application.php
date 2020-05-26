<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="delete-application" tabindex="-1" role="dialog" aria-labelledby="delete-application-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-application-label"><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_TITLE); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_BODY); ?></p>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('manage_application', array('pub_id' => $_GET['pub_id'], 'action' => 'delete_application')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_CANCEL_BUTTON); ?></button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';"><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_DELETE_BUTTON); ?></button>
            </div>
        </div>
    </div>
</div>