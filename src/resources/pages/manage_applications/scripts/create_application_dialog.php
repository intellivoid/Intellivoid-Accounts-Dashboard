<?php
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="create-application" tabindex="-1" role="dialog" aria-labelledby="create-application-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <form class="modal-content" method="POST" action="<?PHP DynamicalWeb::getRoute('manage_applications', array('action' => 'register_application'), true); ?>">
                <div class="modal-header">
                    <h4 class="modal-title" id="create-application-label"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_TITLE); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="application_name"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_APPLICATION_NAME_LABEL); ?></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input id="application_name" name="application_name" type="text" class="form-control" placeholder="<?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_APPLICATION_NAME_PLACEHOLDER); ?>" required>
                            <div class="form-control-position">
                                <i class="feather icon-layers"></i>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <label for="authentication_type"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_LABEL); ?></label>
                        <select class="form-control" name="authentication_type" id="authentication_type">
                            <option value="redirect"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_REDIRECT); ?></option>
                            <option value="placeholder"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_PLACEHOLDER); ?></option>
                            <option value="code"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_CODE); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_CANCEL_BUTTON); ?></button>
                    <input type="submit" class="btn btn-primary" value="<?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_SUBMIT_BUTTON); ?>">
                </div>
            </form>
        </div>
    </div>
</div>