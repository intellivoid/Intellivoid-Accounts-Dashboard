<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="feedback_dialog" tabindex="-1" role="dialog" aria-labelledby="fdl" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'submit_feedback'), true) ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="fdl"><?PHP HTML::print(TEXT_FEEDBACK_DIALOG_TITLE); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="feedback_message"><?PHP HTML::print(TEXT_FEEDBACK_DIALOG_MESSAGE_LABEL); ?></label>
                        <textarea name="feedback_message" id="feedback_message" class="form-control" rows="12" placeholder="<?PHP HTML::print(TEXT_FEEDBACK_DIALOG_MESSAGE_PLACEHOLDER); ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_FEEDBACK_DIALOG_CANCEL_BUTTON); ?></button>
                    <input type="submit" class="btn btn-success" value="<?PHP HTML::print(TEXT_FEEDBACK_DIALOG_SUBMIT_BUTTON); ?>">
                </div>
            </form>
        </div>
    </div>
</div>