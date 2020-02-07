<?PHP
    use DynamicalWeb\DynamicalWeb;
?>
<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
    <div class="container d-flex flex-row nav-top">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top">
            <a class="navbar-brand brand-logo" href="<?PHP DynamicalWeb::getRoute('index', array(), true); ?>">
                <img src="/assets/images/logo_2.svg" alt="logo"/>
            </a>
            <a class="navbar-brand brand-logo-mini" href="<?PHP DynamicalWeb::getRoute('index', array(), true); ?>">
                <img src="/assets/images/iv_logo.svg" alt="logo"/>
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <button class="btn btn-outline-secondary ml-auto" onclick="location.href='<?PHP DynamicalWeb::getRoute('index', array(), true); ?>'">Home</button>
        </div>
    </div>
</nav>