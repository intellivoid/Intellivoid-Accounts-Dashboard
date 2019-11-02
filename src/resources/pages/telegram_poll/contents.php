<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
use IntellivoidAccounts\Exceptions\AuthNotPromptedException;
use IntellivoidAccounts\Exceptions\AuthPromptDeniedException;
    use IntellivoidAccounts\Exceptions\AuthPromptExpiredException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use sws\sws;

    Runtime::import('IntellivoidAccounts');
    Runtime::import('SecuredWebSessions');

    HTML::importScript('json_response');
    HTML::importScript('request_parser');


    /** @var sws $sws */
    $sws = DynamicalWeb::setMemoryObject('sws', new sws());

    if($sws->WebManager()->isCookieValid('intellivoid_secured_web_session') == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 200,
            'message' => "Authentication Required"
        ));
    }

    try
    {
        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    if((bool)$Cookie->Data['session_active'] == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 200,
            'message' => "Authentication Required"
        ));
    }

    if((int)time() > (int)$Cookie->Data['auto_logout'])
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 200,
            'message' => "Authentication Required"
        ));
    }

    if((bool)$Cookie->Data['verification_required'] == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 202,
            'message' => "Method not available"
        ));
    }


    if((int)$Cookie->Data['verification_attempts'] > 3)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 203,
            'message' => "Too many attempts"
        ));
    }

    // Define the important parts
    if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
            "intellivoid_accounts", new IntellivoidAccounts()
        );
    }
    else
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
    }

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
            AccountSearchMethod::byId, WEB_ACCOUNT_ID
        );
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    if($Account->Configuration->VerificationMethods->TelegramClientLinked == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 202,
            'message' => "Method not available"
        ));
    }

    try
    {
        $TelegramClient = $IntellivoidAccounts->getTelegramClientManager()->getClient(
            TelegramClientSearchMethod::byId,
            $Account->Configuration->VerificationMethods->TelegramLink->ClientId
        );
    }
    catch (Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    try
    {
        if($IntellivoidAccounts->getTelegramService()->pollAuthPrompt($TelegramClient) == true)
        {
            returnJsonResponse(array(
                'status' => true,
                'approved' => true
            ));
        }

        returnJsonResponse(array(
            'status' => true,
            'approved' => false
        ));
    }
    catch (AuthPromptDeniedException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 205,
            'message' => "The prompt has been denied"
        ));
    }
    catch (AuthPromptExpiredException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 206,
            'message' => "The prompt has expired"
        ));
    }
    catch(AuthNotPromptedException $authNotPromptedException)
    {

    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 204,
            'message' => "Unable to verify prompt authentication"
        ));
    }