<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('json_response');

    if(isset($_GET['remote_host']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 100,
            'message' => 'Missing GET parameter \'remote_host\''
        ));
    }

    if(isset($_GET['user_agent']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 101,
            'message' => 'Missing GET parameter \'user_agent\''
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

    if(Validate::userAgent($_GET['user_agent']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 102,
            'message' => 'The given user agent is invalid'
        ));
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost($_GET['remote_host'], $_GET['user_agent']);
    }
    catch(InvalidIpException $invalidIpException)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 103,
            'message' => 'The given IP Address is invalid'
        ));
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 104,
            'error_code' => $exception->getCode(),
            'message' => 'Internal Server Error'
        ));
    }

    if($KnownHost->Blocked == true)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 105,
            'message' => 'The IP Address is blocked for security reasons'
        ));
    }

    returnJsonResponse(array(
        'status' => true,
        'host_id' => $KnownHost->PublicID
    ));