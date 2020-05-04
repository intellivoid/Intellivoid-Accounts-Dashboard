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
            <h4 class="mb-0 auth-header"><?PHP HTML::print(TEXT_AUTHENTICATION_HEADER); ?></h4>
            <div id="callback_alert">
                <?PHP HTML::importScript('callbacks'); ?>
            </div>
        </div>
    </div>
    <div class="card-content p-2 pt-0">
        <div class="card-body pt-0">
            <form id="authentication_form" name="authentication_form">
                <div class="form-group">
                    <label for="username_email" id="username_email_label" class="text-muted"><?PHP HTML::print(TEXT_LOGIN_PLACEHOLDER); ?></label>
                    <div class="position-relative has-icon-left">
                        <input type="text" id="username_email" class="form-control" autocomplete="username" autofocus="autofocus" name="username_email" placeholder="JohnDoe@intellivoid.info" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" id="password_label" class="text-muted"><?PHP HTML::print(TEXT_PASSWORD_PLACEHOLDER); ?></label>
                    <div class="position-relative has-icon-left">
                        <input type="password" id="password" class="form-control" autocomplete="password" name="password" placeholder="**********" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                    </div>
                </div>
                <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light float-right" disabled>
                    <span id="submit_label" hidden><?PHP HTML::print(TEXT_LOGIN_BUTTON); ?></span>
                    <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
                <span id="ca_label" class="text-muted"> <?PHP HTML::print(TEXT_HINT_NO_ACCOUNT); ?>
                    <a id="ca_link" class="text-muted" href="<?PHP DynamicalWeb::getRoute('register', $GetParameters, true); ?>"><?PHP HTML::print(TEXT_CREATE_ACCOUNT_LINK); ?></a>
                </span>
            </form>
        </div>
    </div>
    <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
        <?PHP HTML::importSection('authentication_footer'); ?>
    </div>
</div>