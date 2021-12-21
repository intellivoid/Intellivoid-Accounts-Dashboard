<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="password-reset-dialog" tabindex="-1" role="dialog" aria-labelledby="prd" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'update_password'), true) ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="prd"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_TITLE); ?></h4>
                </div>
                <div class="modal-body">

                    <!-- CURRENT PASSWORD -->
                    <div class="form-group">
                        <label for="current_password"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_CURRENT_PASSWORD_LABEL); ?></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input id="current_password" name="current_password" autocomplete="current-password" type="password" class="form-control" placeholder="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_CURRENT_PASSWORD_PLACEHOLDER); ?>" required>
                            <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                            </div>
                        </fieldset>
                    </div>

                    <!-- NEW PASSWORD -->
                    <div class="form-group">
                        <label for="new_password"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_NEW_PASSWORD_LABEL); ?></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input id="new_password" name="new_password" autocomplete="new-password" type="password" class="form-control" placeholder="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_NEW_PASSWORD_PLACEHOLDER); ?>" required>
                            <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                            </div>
                        </fieldset>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="form-group">
                        <label for="confirm_password"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_REPEAT_PASSWORD_LABEL); ?></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input id="confirm_password" name="confirm_password" autocomplete="new-password" type="password" class="form-control" placeholder="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_REPEAT_PASSWORD_PLACEHOLDER); ?>" required>
                            <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                            </div>
                        </fieldset>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_CANCEL_BUTTON); ?></button>
                    <input type="submit" class="btn btn-primary" value="<?PHP HTML::print(TEXT_RESET_PASSWORD_DIALOG_SUBMIT_BUTTON); ?>">
                </div>
            </form>

        </div>
    </div>
</div>