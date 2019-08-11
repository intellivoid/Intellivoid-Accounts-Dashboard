<?PHP

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
                <img src="../assets/images/logo_2.png" alt="logo" /> </a>
            <a class="navbar-brand brand-logo-mini" href="/">
                <img src="../assets/images/iv_logo.svg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false"><?PHP HTML::print($UsernameSafe); ?></a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <a class="dropdown-item p-0">
                            <div class="d-flex border-bottom">
                                <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                                </div>
                                <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                                </div>
                                <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item mt-2"> Manage Accounts </a>
                        <a class="dropdown-item"> Change Password </a>
                        <a class="dropdown-item"> Check Inbox </a>
                        <a class="dropdown-item"> Sign Out </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler align-self-center" id="toggle-navbar-mini" name="toggle-navbar-mini"  type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </div>
    <div class="nav-bottom" id="navigation_bar" name="navigation_bar">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="link-icon mdi mdi-airplay"></i>
                        <span class="menu-title">Overview</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/personal" class="nav-link">
                        <i class="link-icon mdi mdi-account"></i>
                        <span class="menu-title">Personal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon mdi mdi-lock"></i>
                        <span class="menu-title ">Security</span>
                        <i class="menu-arrow "></i>
                    </a>
                    <div class="submenu ">
                        <ul class="submenu-item ">
                            <li class="nav-item ">
                                <a class="nav-link " href="/login_history">Login History</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="/services">Services</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="/2fa">Login Security</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="/update_password">Update Password</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="/balance" class="nav-link">
                        <i class="link-icon mdi mdi-bank"></i>
                        <span class="menu-title">Balance</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>