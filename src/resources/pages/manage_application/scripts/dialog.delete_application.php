<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="delete-application" tabindex="-1" role="dialog" aria-labelledby="delete-application-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-application-label"><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_TITLE); ?></h4>
            </div>
            <div class="modal-body">
                <?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_BODY); ?>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('manage_application', array('pub_id' => $_GET['pub_id'], 'action' => 'delete_application')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_CANCEL_BUTTON); ?></button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';"><?PHP HTML::print(TEXT_DELETE_APPLICATION_DIALOG_DELETE_BUTTON); ?></button>
            </div>
        </div>
    </div>
</div>