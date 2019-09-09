<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');


    if(isset($_GET['user_id']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "Missing GET parameter 'user_id'"
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

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byPublicID, $_GET['user_id']);
    }
    catch(AccountNotFoundException $accountNotFoundException)
    {
        $Response = array(
            "status" => false,
            "message" => "Resource not found"
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }
    catch(Exception $exception)
    {
        $Response = array(
            "status" => false,
            "message" => "Internal Server Error"
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if($IntellivoidAccounts->getUdp()->getProfilePictureManager()->avatar_exists($Account->PublicID) == false)
    {
        $IntellivoidAccounts->getUdp()->getProfilePictureManager()->generate_avatar($Account->PublicID);
    }

    $Avatar = $IntellivoidAccounts->getUdp()->getProfilePictureManager()->get_avatar($Account->PublicID);

    if(isset($_GET["resource"]))
    {
        if(isset($Avatar[$_GET['resource']]))
        {
            upload_image($Avatar[$_GET['resource']]);
        }

        $Response = array(
            "status" => false,
            "message" => "Resource not found"
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }
    else
    {
        upload_image($Avatar['normal']);
    }


    function upload_image($file)
    {
        $ImageContents = file_get_contents($file);

        header('Cache-control: max-age='.(60*60*24*365));
        header('Content-Length: ' . strlen($ImageContents));
        header('Content-type: image/jpeg');
        print($ImageContents);
        exit();
    }