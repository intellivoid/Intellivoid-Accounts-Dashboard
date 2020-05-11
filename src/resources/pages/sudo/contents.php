<?php

    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('check');
    HTML::importScript('enter_sudo_mode');
    HTML::importScript('expanded');

    function getAnimationStyle()
    {
        if(UI_EXPANDED)
        {
            return "";
        }

        return " animated fadeInUp";
    }


    if(isset($_GET['redirect']) == false)
    {
        header('Location: /');
        exit();
    }

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['incorrect_auth']);
    unset($GetParameters['anim']);
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('authentication_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static blank-page blank-page area" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
        <div class="app-content content" style="overflow: inherit;">
            <?PHP HTML::importSection('authentication_bhelper'); ?>
            <div class="content-wrapper mt-0">
                <?PHP HTML::importSection('background_animations'); ?>
                <div class="content-body">
                    <?PHP
                    if(UI_EXPANDED)
                    {
                        HTML::importScript("card");
                    }
                    else
                    {
                        ?>
                        <section class="row flexbox-container mx-0">
                            <div class="col-xl-8 col-10 d-flex justify-content-center my-1">
                                <div class="col-12 col-sm-10 col-md-11 col-lg-8 col-xl-7 p-0">
                                    <?PHP HTML::importScript("card"); ?>
                                </div>
                            </div>
                        </section>
                        <?PHP
                    }
                    ?>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('authentication_js'); ?>
        <?PHP Javascript::importScript('sudo', $_GET); ?>
    </body>
</html>