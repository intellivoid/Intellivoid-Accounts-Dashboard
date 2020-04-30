<?php
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal fixed-top navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="<?PHP DynamicalWeb::getRoute('index', [], true); ?>">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0"><?PHP HTML::print(TEXT_NAV_MENU_BRAND_TEXT); ?></h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                        <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item">
                    <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('index', [], true); ?>">
                        <i class="feather icon-home"></i>
                        <span><?PHP HTML::print(TEXT_NAV_MENU_LINK_OVERVIEW); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('personal', [], true); ?>">
                        <i class="feather icon-user"></i>
                        <span><?PHP HTML::print(TEXT_NAV_MENU_LINK_ACCOUNT_SETTINGS); ?></span>
                    </a>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="feather icon-dollar-sign"></i>
                        <span data-i18n="Starter kit"><?PHP HTML::print(TEXT_NAV_MENU_LINK_FINANCE); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('account_balance', [], true); ?>" data-toggle="dropdown">
                                <?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_FINANCE_ACCOUNT_BALANCE); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('transaction_history', [], true); ?>" data-toggle="dropdown">
                                <?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_FINANCE_TRANSACTION_HISTORY); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('manage_subscriptions', [], true); ?>" data-toggle="dropdown">
                                <?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_FINANCE_SUBSCRIPTIONS); ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="feather icon-message-square"></i>
                        <span data-i18n="Starter kit"><?PHP HTML::print(TEXT_NAV_MENU_LINK_SUPPORT); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('privacy', [], true); ?>" data-toggle="dropdown">
                                <?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SUPPORT_PRIVACY); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('tos', [], true); ?>" data-toggle="dropdown">
                                <?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SUPPORT_TERMS_OF_SERVICE); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">
                                <?PHP HTML::print(TEXT_NAV_MENU_DROPDOWN_SUPPORT_FEEDBACK); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>