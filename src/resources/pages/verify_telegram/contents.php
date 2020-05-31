<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\KnownHost;
    use sws\Objects\Cookie;

    HTML::importScript('get_account');
    HTML::importScript('check_method');
    HTML::importScript('verify');
    HTML::importScript('send_prompt');
    HTML::importScript('expanded');

    function getAnimationStyle()
    {
        if(UI_EXPANDED)
        {
            return "";
        }

        return " animated fadeInRight";
    }

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['incorrect_auth']);
    unset($GetParameters['anim']);

    /**
     * Returns the Known Host associated with this client
     *
     * @return KnownHost
     * @throws DatabaseException
     * @throws HostNotKnownException
     * @throws InvalidIpException
     */
    function get_host(): KnownHost
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        /** @var Cookie $Cookie */
        $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

        return $IntellivoidAccounts->getKnownHostsManager()->getHost(KnownHostsSearchMethod::byId, $Cookie->Data['host_id']);
    }
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
        <?PHP HTML::importSection('authentication_js'); ?>
        <?PHP Javascript::importScript('telegramauth', $GetParameters); ?>
    </body>
</html>