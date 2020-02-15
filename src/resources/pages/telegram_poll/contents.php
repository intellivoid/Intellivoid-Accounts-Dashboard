<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthPromptDeniedException;
    use IntellivoidAccounts\Exceptions\AuthPromptExpiredException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\Exceptions\InvalidLoginStatusException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\KnownHost;
    use IntellivoidAccounts\Objects\TelegramClient;
    use sws\Objects\Cookie;
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
            'response_code' => 401,
            'error_code' => 200,
            'message' => "Unauthorized Request"
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
            'response_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    if((bool)$Cookie->Data['session_active'] == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 401,
            'error_code' => 200,
            'message' => "Unauthorized Request"
        ));
    }

    if((int)time() > (int)$Cookie->Data['auto_logout'])
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 401,
            'error_code' => 200,
            'message' => "Unauthorized Request"
        ));
    }

    if((bool)$Cookie->Data['verification_required'] == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 405,
            'error_code' => 202,
            'message' => "Method not available"
        ));
    }


    if((int)$Cookie->Data['verification_attempts'] > 3)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 429,
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

    /**
     * Processes a denial login record
     *
     * @param IntellivoidAccounts $intellivoidAccounts
     * @param Account $account
     * @throws DatabaseException
     * @throws HostNotKnownException
     * @throws InvalidIpException
     * @throws AccountNotFoundException
     * @throws InvalidLoginStatusException
     * @throws InvalidSearchMethodException
     */
    function process_denial(IntellivoidAccounts $intellivoidAccounts, Account $account, TelegramClient $telegramClient)
    {
        $Host = get_host();

        $intellivoidAccounts->getLoginRecordManager()->createLoginRecord(
            $account->ID, $Host->ID,
            LoginStatus::VerificationFailed, 'Intellivoid Accounts',
            CLIENT_USER_AGENT
        );

        $intellivoidAccounts->getTelegramService()->closePrompt($telegramClient);
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
            'response_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    if($Account->Configuration->VerificationMethods->TelegramClientLinked == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 405,
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
            'response_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    $prompt_denied = false;
    $prompt_expired = false;

    try
    {
        if($IntellivoidAccounts->getTelegramService()->pollAuthPrompt($TelegramClient) == true)
        {
            returnJsonResponse(array(
                'status' => true,
                'response_code' => 200,
                'approved' => true
            ));
        }

        returnJsonResponse(array(
            'status' => true,
            'response_code' => 200,
            'approved' => false
        ));
    }
    catch (AuthPromptDeniedException $e)
    {
        $prompt_denied = true;
    }
    catch (AuthPromptExpiredException $e)
    {
        $prompt_expired = true;
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'error_code' => 204,
            'message' => "Unable to verify prompt authentication"
        ));
    }

    try
    {
        process_denial($IntellivoidAccounts, $Account, $TelegramClient);
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'error_code' => 201,
            'message' => "Internal Server Error"
        ));
    }

    if($prompt_expired == true)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'error_code' => 206,
            'message' => "The prompt has expired"
        ));
    }

    if($prompt_denied == true)
    {
        $Cookie->Data['session_active'] = false;
        $Cookie->Data['verification_required'] = false;
        $Cookie->Data['auto_logout'] = 0;
        $Cookie->Data['verification_attempts'] = 0;
        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->disposeCookie('intellivoid_secured_web_session');

        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'error_code' => 205,
            'message' => "The prompt has been denied"
        ));
    }