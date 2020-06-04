<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="feedback_dialog" tabindex="-1" role="dialog" aria-labelledby="fdl" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'submit_feedback'), true) ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="fdl"><?PHP HTML::print(TEXT_FEEDBACK_DIALOG_TITLE); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="feedback_message"><?PHP HTML::print(TEXT_FEEDBACK_DIALOG_MESSAGE_LABEL); ?></label>
                        <textarea name="feedback_message" id="feedback_message" class="form-control" rows="12" placeholder="<?PHP HTML::print(TEXT_FEEDBACK_DIALOG_MESSAGE_PLACEHOLDER); ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_FEEDBACK_DIALOG_CANCEL_BUTTON); ?></button>
                    <input type="submit" class="btn btn-primary" value="<?PHP HTML::print(TEXT_FEEDBACK_DIALOG_SUBMIT_BUTTON); ?>">
                </div>
            </form>

        </div>
    </div>
</div>