<?PHP
    use DynamicalWeb\HTML;
    HTML::importScript('auth.register');
?>
<!DOCTYPE html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('authentication_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>
    <body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static blank-page blank-page area" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
        <div class="app-content content" style="overflow: inherit;">
            <?PHP HTML::importSection('authentication_bhelper'); ?>
            <div class="content-wrapper mt-0">
                <?PHP HTML::importSection('background_animations'); ?>
                <div class="content-body">
                    <?PHP
                    HTML::importScript("expanded");
                    $CardStyle = "";
                    if(UI_EXPANDED)
                    {
                        $CardStyle = " style=\"height: calc(100% - 3px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
                    }
                    if(UI_EXPANDED == false)
                    {
                        ?>
                        <section class="row flexbox-container mx-0">
                            <div class="col-xl-8 col-10 d-flex justify-content-center my-3">
                                <div class="col-12 col-sm-10 col-md-11 col-lg-8 col-xl-7 p-0 mb-3">
                        <?PHP
                    }
                    ?>
                        <div class="linear-activity">
                            <div id="linear-spinner" class="indeterminate"></div>
                        </div>
                                    <div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
                                        <div class="card-content p-2 pt-0">
                                            <div class="card-body mt-auto mb-auto">
                                                <div class="row h-100">
                                                    <div class="col-sm-12 my-auto align-self-center">
                                                        <h1 class="text-center pt-2">
                                                            <img src="/assets/images/iv_logo.svg" alt="Intellivoid Blue Logo" class="img-sm rounded-circle"/>
                                                            Intellivoid
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?PHP
                                    if(UI_EXPANDED == false)
                                    {
                                    ?>
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
    </body>
</html>