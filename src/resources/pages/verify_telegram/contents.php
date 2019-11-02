<?PHP

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

$UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    $BorderDanger = false;
    if(isset($_GET['incorrect_auth']))
    {
        if($_GET['incorrect_auth'] == '1')
        {
            $BorderDanger = true;
        }
    }

    $GetParameters = $_GET;
    unset($GetParameters['callback']);

    HTML::importScript('get_account');

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


    HTML::importScript('check_method');
    HTML::importScript('verify');
    HTML::importScript('send_prompt');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Verify</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto animated slideInRight" id="input_dialog">
                        <div class="col-lg-5 mx-auto">
                            <div class="auto-form-wrapper">
                                <button class="btn btn-rounded btn-inverse-light grid-margin" onclick="go_back();">
                                    <i class="mdi mdi-arrow-left"></i>
                                </button>
                                <h1 class="text-center">
                                    <i class="mdi mdi-telegram"></i>
                                    Telegram Prompt
                                </h1>
                                <p class="text-center">Check your Telegram Account for a Authentication Prompt</p>
                                <div class="border-bottom pb-2"></div>
                                <img src="/assets/images/verification.svg" class="img-fluid" alt="telegram-auth-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP Javascript::importScript('telegramauth', $GetParameters); ?>
    </body>
</html>
