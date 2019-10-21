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
        <?PHP HTML::importSection('gen_dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("gen_dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">

                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('gen_dashboard_js'); ?>
    </body>
</html>
