<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Exceptions\AccountNotFoundException;
use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if(isset($_GET['app_id']) == false)
    {
        $Response = array(
            "status" => false,
            "response_code" => 400,
            "message" => "Missing GET parameter 'app_id'"
        );
        header('Content-Type: application/json');
        http_response_code(400);
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
        $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(ApplicationSearchMethod::byApplicationId, $_GET['app_id']);
    }
    catch(ApplicationNotFoundException $applicationNotFoundException)
    {
        $Response = array(
            "status" => false,
            "response_code" => 404,
            "message" => "Resource not found"
        );
        header('Content-Type: application/json');
        http_response_code(404);
        print(json_encode($Response));
        exit();
    }
    catch(Exception $exception)
    {
        $Response = array(
            "status" => false,
            "response_code" => 500,
            "message" => "Internal Server Error"
        );
        header('Content-Type: application/json');
        http_response_code(500);
        print(json_encode($Response));
        exit();
    }

    if($IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->avatar_exists($Application->PublicAppId) == false)
    {
        $IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->generate_avatar($Application->PublicAppId);
    }

    $Avatar = $IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->get_avatar($Application->PublicAppId);

    if(isset($_GET["resource"]))
    {
        if(isset($Avatar[$_GET['resource']]))
        {
            upload_image($Avatar[$_GET['resource']]);
        }

        $Response = array(
            "status" => false,
            "response_code" => 404,
            "message" => "Resource not found"
        );
        header('Content-Type: application/json');
        http_response_code(404);
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

        header('Cache-control: max-age=60');
        header('Content-Length: ' . strlen($ImageContents));
        header('Content-type: image/jpeg');
        http_response_code(200);
        print($ImageContents);
        exit();
    }