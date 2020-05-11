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
                    <div class="form-group">
                        <label for="password" id="password_lablel" class="text-muted"><?PHP HTML::print(TEXT_PASSWORD_LABEL); ?></label>
                        <div class="position-relative has-icon-left">
                            <input type="password" id="password" class="form-control<?PHP if($BorderDanger == true){ HTML::print(" border-danger"); } ?>" autocomplete="off" name="password" autofocus="autofocus" placeholder="***********" required disabled>
                            <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light float-right" disabled>
                        <span id="submit_label" hidden><?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?></span>
                        <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status"></span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
            <?PHP HTML::importSection('authentication_footer'); ?>
        </div>
    </div>
</div>
