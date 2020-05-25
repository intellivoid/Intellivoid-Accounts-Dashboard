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
                    <h5 class="pb-1"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_HEADER); ?></h5>
                    <div class="form-group px-1 mb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="perm_view_email_address" id="perm_view_email_address" value="false">
                                        <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                        <label for="perm_view_email_address" class="font-medium-1"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_EMAIL_TEXT); ?></label>
                                    </div>
                                </fieldset>
                                <p class="text-muted font-small-3 pb-1"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_EMAIL_DESCRIPTION); ?></p>
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="perm_telegram_notifications" id="perm_telegram_notifications" value="false">
                                        <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                        <label for="perm_telegram_notifications" class="font-medium-1"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?></label>
                                    </div>
                                </fieldset>
                                <p class="text-muted font-small-3"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_TELEGRAM_NOTIFICATIONS_DESCRIPTION); ?></p>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="perm_view_personal_information" id="perm_view_personal_information" value="false">
                                        <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                        <label for="perm_view_personal_information" class="font-medium-1"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_PERSONAL_INFORMATION_TEXT); ?></label>
                                    </div>
                                </fieldset>
                                <p class="text-muted font-small-3"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_PERSONAL_INFORMATION_DESCRIPTION); ?></p>
                            </div>
                        </div>
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