<?PHP
    use DynamicalWeb\HTML;

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">

                        <div class="row">
                            <div class="col-12 grid-margin d-none d-lg-block">
                                <div class="intro-banner">
                                    <div class="banner-image">
                                        <img src="../assets/images/dashboard/banner_img.png" alt="banner image"> </div>
                                    <div class="content-area">
                                        <h3 class="mb-0">Welcome back, <?PHP HTML::print($UsernameSafe); ?>!</h3>
                                        <p class="mb-0">Need anything more to know more? Feel free to contact us at any point.</p>
                                    </div>
                                    <a href="https://intellivoid.info/contact" target="_blank" class="btn btn-light">Contact us</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
