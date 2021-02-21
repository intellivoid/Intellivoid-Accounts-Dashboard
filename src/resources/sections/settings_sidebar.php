<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    $ActiveClass = " active bg-gradient-primary";
?>
<ul class="nav nav-pills flex-column mt-md-0 mt-1">
    <li class="nav-item">
        <a href="<?PHP DynamicalWeb::getRoute('settings/user', [], true); ?>" class="nav-link d-flex py-75<?PHP if(APP_CURRENT_PAGE == 'settings/user'){ HTML::print($ActiveClass); } ?>">
            <i class="feather icon-user mr-50 font-medium-3"></i>
            <?PHP HTML::print(TEXT_SETTINGS_TAB_PERSONAL); ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?PHP DynamicalWeb::getRoute('settings/password', [], true); ?>" class="nav-link d-flex py-75<?PHP if(APP_CURRENT_PAGE == 'settings/password'){ HTML::print($ActiveClass); } ?>">
            <i class="feather icon-lock mr-50 font-medium-3"></i>
            <?PHP HTML::print(TEXT_SETTINGS_TAB_CHANGE_PASSWORD); ?>
        </a>
    </li>
    <li class="nav-item">
        <?PHP
            $SettingsLoginSecurityClass = "";

            switch(APP_CURRENT_PAGE)
            {
                case "settings/login_security":
                case "settings/setup_recovery_codes":
                case "settings/setup_mobile_verification":
                    $SettingsLoginSecurityClass = $ActiveClass;
                    break;
            }
        ?>
        <a href="<?PHP DynamicalWeb::getRoute('settings/login_security', [], true); ?>" class="nav-link d-flex py-75<?PHP HTML::print($SettingsLoginSecurityClass); ?>">
            <i class="feather icon-shield mr-50 font-medium-3"></i>
            <?PHP HTML::print(TEXT_SETTINGS_TAB_LOGIN_SECURITY); ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?PHP DynamicalWeb::getRoute('settings/authorized_apps', [], true); ?>" class="nav-link d-flex py-75<?PHP if(APP_CURRENT_PAGE == 'settings/authorized_apps'){ HTML::print($ActiveClass); } ?>">
            <i class="feather icon-layers mr-50 font-medium-3"></i>
            <?PHP HTML::print(TEXT_SETTINGS_TAB_AUTHORIZED_APPS); ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?PHP DynamicalWeb::getRoute('settings/login_history', [], true); ?>" class="nav-link d-flex py-75<?PHP if(APP_CURRENT_PAGE == 'settings/login_history'){ HTML::print($ActiveClass); } ?>">
            <i class="feather icon-activity mr-50 font-medium-3"></i>
            <?PHP HTML::print(TEXT_SETTINGS_TAB_LOGIN_HISTORY); ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?PHP DynamicalWeb::getRoute('settings/otl_generator', [], true); ?>" class="nav-link d-flex py-75<?PHP if(APP_CURRENT_PAGE == 'settings/otl_generator'){ HTML::print($ActiveClass); } ?>">
            <i class="feather icon-zap mr-50 font-medium-3"></i>
            <?PHP HTML::print(TEXT_SETTINGS_TAB_OTL_GENERATOR); ?>
        </a>
    </li>
</ul>