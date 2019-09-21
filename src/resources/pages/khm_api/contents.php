<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    Runtime::import('IntellivoidAccounts');

    if(isset($_GET['remote_host']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "Missing parameter 'remote_host'",
            "code" => 1000
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if(isset($_GET['user_agent']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "Missing parameter 'user_agent'",
            "code" => 1000
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
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
        $Response = array(
            "status" => false,
            "message" => "UserAgent is invalid",
            "code" => 1001
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost($_GET['remote_host'], $_GET['user_agent']);
    }
    catch(InvalidIpException $invalidIpException)
    {
        $Response = array(
            "status" => false,
            "message" => "IP Address is invalid",
            "code" => 1002
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }
    catch(Exception $exception)
    {
        $Response = array(
            "status" => false,
            "message" => "Internal Server Error",
            "code" => 1003,
            "error_code" => $exception->getCode()
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if($KnownHost->Blocked == true)
    {
        $Response = array(
            "status" => false,
            "message" => "This IP Address has been blocked for security reasons",
            "code" => 1004,
            "error_code" => $exception->getCode()
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    $Response = array(
        "status" => true,
        "host_id" => $KnownHost->PublicID
    );
    header('Content-Type: application/json');
    print(json_encode($Response));
    exit();