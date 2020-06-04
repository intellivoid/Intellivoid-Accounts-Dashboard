<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use IntellivoidAccounts\Objects\Account;

    $CardStyle = "";
    if(UI_EXPANDED)
    {
        $CardStyle = " style=\"height: calc(100% - 3px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
    }

    $GetParameters = $_GET;
    unset($GetParameters['callback']);

    $BorderDanger = false;
    if(isset($_GET['incorrect_auth']))
    {
        if($_GET['incorrect_auth'] == '1')
        {
            $BorderDanger = true;
        }
    }

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }
?>
<div id="verification_dialog" class="<?PHP HTML::print(getAnimationStyle()); ?>">
    <div class="linear-activity">
        <div id="linear-spinner" class="indeterminate"></div>
    </div>
    <div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
        <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
            <div class="card-title">
                <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
                <h4 class="mb-0 auth-header">
                    <?PHP HTML::print(TEXT_HEADER); ?>
                </h4>
                <div id="callback_alert">
                    <?PHP HTML::importScript('callbacks'); ?>
                </div>
            </div>
        </div>
        <div class="card-content p-2 pt-0">
            <div class="card-body pt-0">
                <span class="text-small"><?PHP HTML::print(TEXT_SUB_HEADER); ?></span>
                <form id="authentication_form" name="authentication_form" class="mt-2">
                    <input name="username" id="username" type="text" autocomplete="off" value="<?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?>" hidden>
                    <div class="form-group">
                        <label for="new_password" id="password_label" class="text-muted"><?PHP HTML::print(TEXT_NEW_PASSWORD_LABEL); ?></label>
                        <div class="position-relative has-icon-left">
                            <input type="password" id="new_password" class="form-control<?PHP if($BorderDanger == true){ HTML::print(" border-danger"); } ?>" autocomplete="new-password" name="new_password" autofocus="autofocus" placeholder="<?PHP HTML::print(TEXT_NEW_PASSWORD_PLACEHOLDER); ?>" required disabled>
                            <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light float-right" disabled>
                        <span id="submit_label" hidden><?PHP HTML::print(TEXT_CHANGE_PASSWORD_BUTTON); ?></span>
                        <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status"></span>
                    </button>
                </form>
                <div class="text-block">
                    <span class="text-small font-weight-semibold"><?PHP HTML::print(str_ireplace('%s', $UsernameSafe, TEXT_FOOTER_NOT_USER_TEXT)); ?></span>
                    <a href="<?PHP DynamicalWeb::getRoute('logout', array(), true); ?>" class="text-black text-small"><?PHP HTML::print(TEXT_FOOTER_NOT_USER_LOGOUT_LINK); ?></a>
                </div>
            </div>
        </div>
        <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
            <?PHP HTML::importSection('authentication_footer'); ?>
        </div>
    </div>
</div>
