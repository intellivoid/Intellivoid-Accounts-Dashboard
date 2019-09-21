<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Request;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountStatus;
use IntellivoidAccounts\Abstracts\LoginStatus;
use IntellivoidAccounts\Abstracts\OtlStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\OtlSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\OtlNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
use IntellivoidAccounts\Utilities\Validate;

Runtime::import('IntellivoidAccounts');

    if(isset($_GET['code']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "Missing parameter 'code'",
            "code" => 1000
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if(isset($_GET['vendor']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "Missing parameter 'vendor'",
            "code" => 1000
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if(isset($_GET['host_id']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "Missing parameter 'host_id'",
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

    try
    {
        $VerificationCode = $IntellivoidAccounts->getOtlManager()->getOtlRecord(OtlSearchMethod::byCode, Request::getParameter('code'));
    }
    catch (OtlNotFoundException $e)
    {
        $Response = array(
            "status" => false,
            "message" => "Invalid authentication code",
            "code" => 1001
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
            "error_code" => $exception->getCode(),
            "code" => 1002
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if($VerificationCode->Status == OtlStatus::Used)
    {
        $Response = array(
            "status" => false,
            "message" => "Token already used",
            "code" => 1004
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if(time() > $VerificationCode->ExpiresTimestamp)
    {
        $Response = array(
            "status" => false,
            "message" => "Expired Token",
            "code" => 1003
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if($VerificationCode->Status == OtlStatus::Unavailable)
    {
        $Response = array(
            "status" => false,
            "message" => "Token unavailable",
            "code" => 1005
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, $VerificationCode->AccountID);
    }
    catch(AccountNotFoundException $accountNotFoundException)
    {
        $Response = array(
            "status" => false,
            "message" => "Account does not exist",
            "code" => 1006
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
            "error_code" => $exception->getCode(),
            "code" => 1002
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if($Account->Status == AccountStatus::Suspended)
    {
        $Response = array(
            "status" => false,
            "message" => "The account is unavailable because it has been suspended",
            "code" => 1007
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if($Account->Status == AccountStatus::VerificationRequired)
    {
        $Response = array(
            "status" => false,
            "message" => "The account is unavailable because the owner needs to verify the account",
            "code" => 1008
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    if(Validate::vendor($_GET['vendor']) == false)
    {
        $Response = array(
            "status" => false,
            "message" => "The vendor name is invalid",
            "code" => 1009
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->getHost(KnownHostsSearchMethod::byPublicId, $_GET['host_id']);
    }
    catch (\IntellivoidAccounts\Exceptions\HostNotKnownException $e)
    {
        $Response = array(
            "status" => false,
            "message" => "Invalid Host ID",
            "code" => 1009
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }
    catch (Exception $e)
    {
        $Response = array(
            "status" => false,
            "message" => "Internal Server Error",
            "error_code" => $exception->getCode(),
            "code" => 1002
        );
        header('Content-Type: application/json');
        print(json_encode($Response));
        exit();
    }

    $VerificationCode->Status = OtlStatus::Used;
    $VerificationCode->Vendor = $_GET['vendor'];
    $IntellivoidAccounts->getOtlManager()->updateOtlRecord($VerificationCode);

    $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
        $Account->ID, $KnownHost->ID,
        LoginStatus::Successful, $VerificationCode->Vendor,
        CLIENT_USER_AGENT
    );

    $ResponseObject = array(
        'id' => $Account->PublicID,
        'username' => $Account->Username,
        'email' => $Account->Email,
        'avatars' => array(),
        'roles'  => $Account->Configuration->Roles->Roles
    );

    if($IntellivoidAccounts->getUdp()->getProfilePictureManager()->avatar_exists($Account->PublicID) == false)
    {
        $IntellivoidAccounts->getUdp()->getProfilePictureManager()->generate_avatar($Account->PublicID);
    }

    foreach($IntellivoidAccounts->getUdp()->getProfilePictureManager()->get_avatar($Account->PublicID) as $item => $value)
    {
        $ResponseObject['avatars'][$item] = 'https://accounts.intellivoid.info/user/contents/public/avatar?user_id=' . $Account->PublicID . '&resource=' . urlencode($item);
        $ResponseObject['avatars'][$item . '_direct'] = 'user/contents/public/avatar?user_id=' . $Account->PublicID . '&resource=' . urlencode($item);
    }

    $Response = array(
        "status" => true,
        "account" => $ResponseObject
    );
    header('Content-Type: application/json');
    print(json_encode($Response));
    exit();