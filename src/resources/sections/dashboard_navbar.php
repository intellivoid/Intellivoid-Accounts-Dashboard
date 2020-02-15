<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }
?>
<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
    <div class="container d-flex flex-row nav-top">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top">
            <a class="navbar-brand brand-logo" href="/">
                <img src="/assets/images/logo_2.svg" alt="logo"/>
            </a>
            <a class="navbar-brand brand-logo-mini" href="/">
                <img src="/assets/images/iv_logo.svg" alt="logo"/>
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ml-4">
                    <a class="nav-link" data-toggle="modal" data-target="#change-language-dialog" href="#">
                        <i class="mdi mdi-translate"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <?PHP HTML::print($UsernameSafe); ?>
                        <?PHP
                            $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'small');
                            if(isset($_GET['cache_refresh']))
                            {
                                if($_GET['cache_refresh'] == 'true')
                                {
                                    $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'small', 'cache_refresh' => hash('sha256', time() . 'CACHE'));
                                }
                            }
                        ?>
                        <img class="img-xs rounded-circle ml-3" src="<?PHP DynamicalWeb::getRoute('avatar', $img_parameters, true) ?>"  alt="<?PHP HTML::print($UsernameSafe); ?>">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <a class="dropdown-item mt-4" href="<?PHP DynamicalWeb::getRoute('applications', [], true); ?>"><?PHP HTML::print(TEXT_USER_DROPDOWN_MANAGE_APPLICATIONS); ?></a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#password-reset-dialog" href="#"><?PHP HTML::print(TEXT_USER_DROPDOWN_CHANGE_PASSWORD); ?></a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#change-avatar-dialog" href="#"><?PHP HTML::print(TEXT_USER_DROPDOWN_CHANGE_AVATAR); ?></a>
                        <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('logout', [], true); ?>"><?PHP HTML::print(TEXT_USER_DROPDOWN_LOGOUT); ?></a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler align-self-center" id="toggle-navbar-mini" name="toggle-navbar-mini"  type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </div>
    <div class="nav-bottom" id="navigation_bar">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="link-icon mdi mdi-view-dashboard"></i>
                        <span class="menu-title"><?PHP HTML::print(TEXT_NAV_MENU_LINK_OVERVIEW); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?PHP DynamicalWeb::getRoute('personal', [], true) ?>" class="nav-link">
                        <i class="link-icon mdi mdi-account"></i>
                        <span class="menu-title"><?PHP HTML::print(TEXT_NAV_MENU_LINK_OVERVIEW); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon mdi mdi-lock"></i>
                        <span class="menu-title"><?PHP HTML::print(TEXT_NAV_MENU_LINK_SECURITY); ?></span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item" style="padding-top: 23px; padding-bottom: 23px;">
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('services', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SECURITY_AUTHORIZED_APPS); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('login_history', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SECURITY_LOGIN_HISTORY); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('login_security', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SECURITY_LOGIN_SECURITY); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('internal_authentication', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SECURITY_INTERNAL_AUTH); ?></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" data-toggle="modal" data-target="#password-reset-dialog" href="#"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SECURITY_UPDATE_PASSWORD); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon mdi mdi-bank"></i>
                        <span class="menu-title"><?PHP HTML::print(TEXT_NAV_MENU_LINK_FINANCE); ?></span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item" style="padding-top: 23px; padding-bottom: 23px;">
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('account_balance', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_FINANCE_ACCOUNT_BALANCE); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('transaction_history', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_FINANCE_TRANSACTION_HISTORY); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('manage_subscriptions', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_FINANCE_SUBSCRIPTIONS); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon mdi mdi-message"></i>
                        <span class="menu-title"><?PHP HTML::print(TEXT_NAV_MENU_LINK_SUPPORT); ?></span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item" style="padding-top: 23px; padding-bottom: 23px;">
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('privacy', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SUPPORT_PRIVACY); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('tos', [], true) ?>"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SUPPORT_TERMS_OF_SERVICE); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="modal" data-target="#feedback_dialog" href="#"><?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SUPPORT_FEEDBACK); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?PHP HTML::importSection('reset_password_modal'); ?>
<?PHP HTML::importSection('change_avatar_modal'); ?>
<?PHP HTML::importSection('change_language_modal'); ?>
<?PHP HTML::importSection('feedback_modal'); ?>