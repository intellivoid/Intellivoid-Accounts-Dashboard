<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use DynamicalWeb\Page;

$UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    /**
     * Determines if the quick access object is enabled or not
     *
     * @param string $name
     * @return bool
     * @throws Exception
     */
    function quick_access_enabled(string $name): bool
    {
        $Configuration = DynamicalWeb::getConfiguration("quick_access");

        if(isset($Configuration[$name]) == false)
        {
            return false;
        }

        if($Configuration[$name]["ENABLED"])
        {
            return true;
        }

        return false;
    }

    /**
     * Determines the quick access location depending if it's localhost mode or not
     *
     * @param string $name
     * @return string
     * @throws Exception
     */
    function quick_access_location(string $name): string
    {
        $Configuration = DynamicalWeb::getConfiguration("quick_access");

        if(isset($Configuration[$name]) == false)
        {
            Page::staticResponse(
                "Intellivoid Accounts Error", "Quick Access Configuration",
                "The quick access '$name' is not configured properly, see quick_access.json"
            );
            exit(0);
        }

        if($Configuration["LOCAL_MODE"])
        {
            return $Configuration[$name]["LOCAL_URI"];
        }

        return $Configuration[$name]["PRODUCTION_URI"];
    }
?>
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-brand-center">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item">
                <a class="navbar-brand" href="#">
                    <div class="brand-logo"></div>
                </a>
            </li>
        </ul>
    </div>
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                <i class="ficon feather icon-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-block">
                            <a class="nav-link disabled" href="#" data-toggle="tooltip" data-placement="top" title="Accounts">
                                <i class="ficon feather icon-user"></i>
                            </a>
                        </li>
                        <?PHP
                            if(quick_access_enabled("TODO"))
                            {
                                ?>
                                <li class="nav-item d-block">
                                    <a class="nav-link" href="<?PHP HTML::print(quick_access_location("TODO"), false); ?>" data-toggle="tooltip" data-placement="top" title="Todo">
                                        <i class="ficon feather icon-check-square"></i>
                                    </a>
                                </li>
                                <?PHP
                            }
                        ?>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="nav-link" id="dropdown-flag" href="#" data-toggle="modal" data-target="#change-language-dialog">
                            <i class="ficon feather icon-globe"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600">
                                    <?PHP HTML::print($UsernameSafe); ?>
                                    <?PHP
                                        $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal');
                                        if(isset($_GET['cache_refresh']))
                                        {
                                            if($_GET['cache_refresh'] == 'true')
                                            {
                                                $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal', 'cache_refresh' => hash('sha256', time() . 'CACHE'));
                                            }
                                        }
                                    ?>
                                </span>
                                <span class="user-status"><?PHP HTML::print(WEB_ACCOUNT_EMAIL); ?></span>
                            </div>
                            <span>
                                <img class="round" src="<?PHP DynamicalWeb::getRoute('avatar', $img_parameters, true) ?>" alt="<?PHP HTML::print($UsernameSafe); ?>" height="40" width="40">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('manage_applications', [], true); ?>">
                                <i class="feather icon-layers"></i> <?PHP HTML::print(TEXT_USER_DROPDOWN_MANAGE_APPLICATIONS); ?>
                            </a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#password-reset-dialog" href="#">
                                <i class="feather icon-lock"></i> <?PHP HTML::print(TEXT_USER_DROPDOWN_CHANGE_PASSWORD); ?>
                            </a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#change-avatar-dialog" href="#">
                                <i class="feather icon-image"></i> <?PHP HTML::print(TEXT_USER_DROPDOWN_CHANGE_AVATAR); ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('logout', [], true); ?>">
                                <i class="feather icon-power"></i> <?PHP HTML::print(TEXT_USER_DROPDOWN_LOGOUT); ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?PHP HTML::importSection('reset_password_modal'); ?>
<?PHP HTML::importSection('change_avatar_modal'); ?>
<?PHP HTML::importSection('change_language_modal'); ?>
<?PHP HTML::importSection('feedback_modal'); ?>