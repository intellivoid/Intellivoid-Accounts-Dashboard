<?PHP

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
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
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller landing-page">
            <div class="container-fluid top-banner">
                <?PHP HTML::importSection('landing_navbar'); ?>
                <div class="row top-banner-content">
                    <div class="col-md-8 mx-auto">
                        <div class="row">
                            <div class="col-lg-7">
                                <h1 class="mr-2 text-white"> Intellivoid Accounts </h1>
                                <h3 class="font-weight-light text-white"> Second-generation Authentication Solution </h3>
                            </div>
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
                                    <div class="card-body">
                                        <img src="/assets/images/landing/gddd_1.svg" alt="image" class="card-icon">
                                        <h4>Secured</h4>
                                        <p class="card-text"> Setup multiple methods of verification of authentication, no email or phone verification </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-icon-top mb-3">
                                    <div class="card-body">
                                        <img src="/assets/images/landing/gddd_2.svg" alt="image" class="card-icon">
                                        <h4>Data Control</h4>
                                        <p class="card-text"> Choose the data you want to share, there is no obligation other than your Username and Avatar </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-icon-top mb-3">
                                    <div class="card-body">
                                        <img src="/assets/images/landing/gddd_3.svg" alt="image" class="card-icon">
                                        <h4>Open Platform</h4>
                                        <p class="card-text"> Integrate Intellivoid Accounts into anything, even Android ROMs </p>
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
                                <h3>Say No to data collection</h3>
                                <p class="text-gray mb-2">Intellivoid does not display ads or collects data about you to share with third-party companies without your consent. Your data is yours, you have the right to choose how to share it with others</p>
                            </div>
                        </div>

                        <div class="row ticket-card mt-5 mb-5 justify-content-center align-items">
                            <div class="col-md-2">
                                <img class="img-lg mb-4 mb-md-0" src="/assets/images/landing/gddd_6.svg" alt="profile image">
                            </div>
                            <div class="ticket-details col-md-10">
                                <h3>Stop reinventing the wheel</h3>
                                <p class="text-gray mb-2">Having too many accounts for many different services can put users at risk if one service gets compromised. Instead use Intellivoid Accounts as a form of authentication for your next project</p>
                            </div>
                        </div>

                        <div class="row ticket-card mt-5 mb-5 justify-content-center align-items">
                            <div class="col-md-2">
                                <img class="img-lg mb-4 mb-md-0" src="/assets/images/landing/gddd_7.svg" alt="profile image">
                            </div>
                            <div class="ticket-details col-md-10">
                                <h3>No more ineffective forms of verification</h3>
                                <p class="text-gray mb-2">Getting tired of Phone Verification / Email Verification? No more! sim swapping is a thing of the past.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?PHP HTML::importSection('landing_footer'); ?>
            <?PHP HTML::importSection('change_language_modal'); ?>
        </div>
        <?PHP HTML::importSection('gen_dashboard_js'); ?>
    </body>
</html>
