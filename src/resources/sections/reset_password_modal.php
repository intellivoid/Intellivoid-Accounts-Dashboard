<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="password-reset-dialog" tabindex="-1" role="dialog" aria-labelledby="prd" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'update_password'), true) ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="prd"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_TITLE); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_CURRENT_PASSWORD_LABEL); ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_CURRENT_PASSWORD_PLACEHOLDER); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_NEW_PASSWORD_LABEL); ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock-plus"></i>
                                </span>
                            </div>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_NEW_PASSWORD_PLACEHOLDER); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_REPEAT_PASSWORD_LABEL); ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock-reset"></i>
                                </span>
                            </div>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_REPEAT_PASSWORD_PLACEHOLDER); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_CANCEL_BUTTON); ?></button>
                    <input type="submit" class="btn btn-success" value="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_SUBMIT_BUTTON); ?>">
                </div>
            </form>
        </div>
    </div>
</div>