<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    $CardStyle = "";
    if(UI_EXPANDED)
    {
        $CardStyle = " style=\"height: calc(100% - 4px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
    }

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
?>
<div class="linear-activity">
    <div id="linear-spinner" class="indeterminate"></div>
</div>
<div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
    <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
        <div class="card-title">
            <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
            <h4 class="mb-0 auth-header"><?PHP HTML::print(TEXT_AUTHENTICATION_SUB_HEADER); ?></h4>
            <div id="callback_alert">
                <?PHP HTML::importScript('callbacks'); ?>
            </div>
        </div>
    </div>
    <div class="card-content p-2 pt-0">
        <div class="card-body pt-0">
            <form id="authentication_form" name="authentication_form">
                <div class="form-group">
                    <label for="email" id="email_label" class="text-muted"><?PHP HTML::print(TEXT_EMAIL_ADDRESS_LABEL); ?></label>
                    <div class="position-relative has-icon-left">
                        <input type="email" id="email" class="form-control" autocomplete="email" name="email" autofocus="autofocus" placeholder="JohnDoe@intellivoid.info" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-mail"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" id="username_label" class="text-muted"><?PHP HTML::print(TEXT_USERNAME_LABEL); ?></label>
                    <div class="position-relative has-icon-left">
                        <input type="text" id="username" class="form-control" autocomplete="username" name="username" placeholder="JohnDoe123" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" id="password_label" class="text-muted"><?PHP HTML::print(TEXT_PASSWORD_LABEL); ?></label>
                    <div class="position-relative has-icon-left">
                        <input type="password" id="password" class="form-control" autocomplete="new-password" name="password" placeholder="**********" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <fieldset class="checkbox">
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input name="tos_agree" id="tos_agree" type="checkbox" required disabled>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <label for="tos_agree" id="tos_agree_label" class="text-muted"><?PHP HTML::print(TEXT_AGREE_CHECKBOX_LABEL); ?></label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light float-right" disabled>
                    <span id="submit_label" hidden><?PHP HTML::print(TEXT_CREATE_ACCOUNT_BUTTON); ?></span>
                    <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
                <span id="ca_label" class="text-muted"> <?PHP HTML::print(TEXT_EXISTING_ACCOUNT_HINT); ?>
                    <a id="ca_link" class="text-muted" href="<?PHP DynamicalWeb::getRoute('login', $GetParameters, true); ?>"><?PHP HTML::print(TEXT_LOGIN_LINK); ?></a>
                </span>
            </form>
        </div>
    </div>
    <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
        <?PHP HTML::importSection('authentication_footer'); ?>
    </div>
</div>