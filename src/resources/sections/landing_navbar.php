<?PHP
    use DynamicalWeb\DynamicalWeb;
?>
<nav class="navbar navbar-expand-lg bg-transparent">
    <div class="row flex-grow">
        <div class="col-md-8 d-lg-flex flex-row mx-auto">
            <a class="navbar-brand" href="<?PHP DynamicalWeb::getRoute('landing_page', array(), true); ?>">
                <img src="/assets/images/logo_2_white.svg" alt="logo">
            </a>
            <button class="navbar-toggler collapsed float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon ti ti-menu text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-link" href="<?PHP DynamicalWeb::getRoute('login', array(), true); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="<?PHP DynamicalWeb::getRoute('register', array('redirect' => 'register'), true); ?>">Create an Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>