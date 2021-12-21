<?PHP

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use DynamicalWeb\Javascript;
use DynamicalWeb\Runtime;
    use sws\sws;

    Runtime::import('SecuredWebSessions');

    $sws = DynamicalWeb::setMemoryObject('sws', new sws());

    if($sws->WebManager()->isCookieValid('intellivoid_secured_web_session'))
    {
        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
        if(isset($Cookie->Data['session_active']))
        {
            if($Cookie->Data['session_active'])
            {
                Actions::redirect(DynamicalWeb::getRoute('index'));
            }
        }
    }

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('landing_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body>
        <div class="container-scroller landing-page">
            <div class="container-fluid top-banner">
                <?PHP HTML::importSection('landing_navbar'); ?>
                <div class="row top-banner-content">
                    <div class="col-md-8 mx-auto">
                        <div class="row mx-2">
                            <h1 class="mr-2 text-white"><?PHP HTML::print(TEXT_HOME_BANNER_HEADER); ?></h1>
                        </div>
                        <div class="row mx-2">
                            <h3 class="font-weight-light text-white quotes"><?PHP HTML::print(TEXT_HOME_BANNER_QUOTE_1); ?></h3>
                            <h3 class="font-weight-light text-white quotes"><?PHP HTML::print(TEXT_HOME_BANNER_QUOTE_2); ?></h3>
                            <h3 class="font-weight-light text-white quotes"><?PHP HTML::print(TEXT_HOME_BANNER_QUOTE_3); ?></h3>
                            <h3 class="font-weight-light text-white quotes"><?PHP HTML::print(TEXT_HOME_BANNER_QUOTE_4); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid middle-section bg-white">
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <div class="row">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-icon-top mb-3">
                                    <div class="card-body" style="padding: 1.88rem 1.81rem;">
                                        <img src="/assets/images/landing/gddd_1.svg" alt="image" class="card-icon">
                                        <h4 class="mt-4"><?PHP HTML::print(TEXT_FEATURES_1_HEADER); ?></h4>
                                        <p class="card-text"><?PHP HTML::print(TEXT_FEATURES_1_BODY); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-icon-top mb-3">
                                    <div class="card-body" style="padding: 1.88rem 1.81rem;">
                                        <img src="/assets/images/landing/gddd_2.svg" alt="image" class="card-icon">
                                        <h4 class="mt-4"><?PHP HTML::print(TEXT_FEATURES_2_HEADER); ?></h4>
                                        <p class="card-text"><?PHP HTML::print(TEXT_FEATURES_2_BODY); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-icon-top mb-3">
                                    <div class="card-body" style="padding: 1.88rem 1.81rem;">
                                        <img src="/assets/images/landing/gddd_3.svg" alt="image" class="card-icon">
                                        <h4 class="mt-4"><?PHP HTML::print(TEXT_FEATURES_3_HEADER); ?></h4>
                                        <p class="card-text"><?PHP HTML::print(TEXT_FEATURES_3_BODY); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto">
                        <div class="row ticket-card mt-5 mb-5 justify-content-center align-items">
                            <div class="col-md-2">
                                <img class="img-lg mb-4 mb-md-0" src="/assets/images/landing/gddd_4.svg" alt="profile image">
                            </div>
                            <div class="ticket-details col-md-10">
                                <h3><?PHP HTML::print(TEXT_ABOUT_1_HEADER); ?></h3>
                                <p class="text-gray mb-2"><?PHP HTML::print(TEXT_ABOUT_1_BODY); ?></p>
                            </div>
                        </div>

                        <div class="row ticket-card mt-5 mb-5 justify-content-center align-items">
                            <div class="col-md-2">
                                <img class="img-lg mb-4 mb-md-0" src="/assets/images/landing/gddd_6.svg" alt="profile image">
                            </div>
                            <div class="ticket-details col-md-10">
                                <h3><?PHP HTML::print(TEXT_ABOUT_2_HEADER); ?></h3>
                                <p class="text-gray mb-2"><?PHP HTML::print(TEXT_ABOUT_2_BODY); ?></p>
                            </div>
                        </div>

                        <div class="row ticket-card mt-5 mb-5 justify-content-center align-items">
                            <div class="col-md-2">
                                <img class="img-lg mb-4 mb-md-0" src="/assets/images/landing/gddd_7.svg" alt="profile image">
                            </div>
                            <div class="ticket-details col-md-10">
                                <h3><?PHP HTML::print(TEXT_ABOUT_3_HEADER); ?></h3>
                                <p class="text-gray mb-2"><?PHP HTML::print(TEXT_ABOUT_3_BODY); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?PHP HTML::importSection('landing_footer'); ?>
            <?PHP HTML::importSection('change_language_modal'); ?>
        </div>
        <?PHP HTML::importSection('generic_js'); ?>
        <?PHP Javascript::importScript('landingquotes'); ?>
    </body>
</html>
