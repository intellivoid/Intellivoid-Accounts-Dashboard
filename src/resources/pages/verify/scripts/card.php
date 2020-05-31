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

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');
?>
<div id="verification_dialog" class="<?PHP HTML::print(getAnimationStyle()); ?>">
    <div class="linear-activity">
        <div id="linear-spinner" class="indeterminate"></div>
    </div>
    <div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
        <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
            <div class="card-title">
                <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
                <h4 class="mb-0 auth-header"><?PHP HTML::print(TEXT_HEADER); ?></h4>
                <div id="callback_alert">
                    <?PHP HTML::importScript('callbacks'); ?>
                </div>
            </div>
        </div>
        <div class="card-content p-2 pt-0">
            <div class="card-body pt-0">
                <span class="text-small"><?PHP HTML::print(TEXT_SUB_HEADER); ?></span>
                <form id="authentication_form" class="mt-3" name="authentication_form">
                    <?PHP

                    if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                    {
                        ?>
                        <div class="form-group mt-1">
                            <a class="d-flex align-items-center text-black" href="#" onclick="verify_telegram();" style="text-decoration: none;">
                                <span class="feather icon-message-square"></span>
                                <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_VERIFICATION_METHOD_TELEGRAM); ?></p>
                                <p class="ml-auto mb-0 text-muted">
                                    <i class="feather icon-arrow-right"></i>
                                </p>
                            </a>
                        </div>
                        <?PHP
                    }

                    if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                    {
                        ?>
                        <div class="form-group mt-1">
                            <a class="d-flex align-items-center text-black" href="#" onclick="verify_mobile();" style="text-decoration: none;">
                                <span class="feather icon-smartphone"></span>
                                <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_VERIFICATION_METHOD_MOBILE); ?></p>
                                <p class="ml-auto mb-0 text-muted">
                                    <i class="feather icon-arrow-right"></i>
                                </p>
                            </a>
                        </div>
                        <?PHP
                    }

                    if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                    {
                        ?>
                        <div class="form-group mt-1">
                            <a class="d-flex align-items-center text-black" href="#" onclick="verify_recovery_codes();" style="text-decoration: none;">
                                <span class="feather icon-refresh-ccw"></span>
                                <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_VERIFICATION_METHOD_RECOVERY); ?></p>
                                <p class="ml-auto mb-0 text-muted">
                                    <i class="feather icon-arrow-right"></i>
                                </p>
                            </a>
                        </div>
                        <?PHP
                    }
                    ?>

                    <div class="text-block text-center mt-3">
                        <span class="text-small font-weight-semibold"><?PHP HTML::print(str_ireplace('%s', $UsernameSafe, TEXT_FOOTER_NOT_USER_TEXT)); ?></span>
                        <a href="<?PHP DynamicalWeb::getRoute('logout', array(), true); ?>" class="text-black text-small"><?PHP HTML::print(TEXT_FOOTER_NOT_USER_LOGOUT_LINK); ?></a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
            <?PHP HTML::importSection('authentication_footer'); ?>
        </div>
    </div>
</div>
