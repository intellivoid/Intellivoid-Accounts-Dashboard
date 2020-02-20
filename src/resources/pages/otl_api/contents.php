<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Request;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\OtlStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\OtlSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\OtlNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('json_response');

    if(isset($_POST['auth_code']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 100,
            'message' => 'Missing POST parameter \'auth_code\''
        ));
    }

    if(isset($_POST['vendor']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 101,
            'message' => 'Missing POST parameter \'vendor\''
        ));
    }

    if(isset($_POST['host_id']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 102,
            'message' => 'Missing POST parameter \'host_id\''
        ));
    }

    if(isset($_POST['user_agent']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 113,
            'message' => 'Missing POST parameter \'user_agent\''
        ));
    }

    if(Validate::userAgent($_POST['user_agent']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 114,
            'message' => 'Invalid parameter for \'user_agent\''
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
        $VerificationCode = $IntellivoidAccounts->getOtlManager()->getOtlRecord(OtlSearchMethod::byCode, $_POST['auth_code']);
    }
    catch (OtlNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'status_code' => 103,
            'message' => 'Invalid Authentication Code'
        ));
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'status_code' => 104,
            'error_code' => $exception->getCode(),
            'message' => 'Internal Server Error'
        ));
    }

    if($VerificationCode->Status == OtlStatus::Used)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'status_code' => 105,
            'message' => 'The authentication code was already used'
        ));
    }

    if($VerificationCode->Status == OtlStatus::Unavailable)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'status_code' => 106,
            'message' => 'The authentication code is unavailable at this time'
        ));
    }

    if(time() > $VerificationCode->ExpiresTimestamp)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'status_code' => 107,
            'message' => 'The authentication code has expired'
        ));
    }

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, $VerificationCode->AccountID);
    }
    catch(AccountNotFoundException $accountNotFoundException)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 404,
            'status_code' => 108,
            'message' => 'The account was not found'
        ));
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'status_code' => 104,
            'error_code' => $exception->getCode(),
            'message' => 'Internal Server Error'
        ));
    }

    if($Account->Status == AccountStatus::Suspended)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'status_code' => 109,
            'message' => 'The account has been suspended'
        ));
    }

    if($Account->Status == AccountStatus::VerificationRequired)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 403,
            'status_code' => 110,
            'message' => 'The account needs to be verified before it can be used'
        ));
    }

    if(Validate::vendor($_POST['vendor']) == false)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 111,
            'message' => 'The vendor name is invalid'
        ));
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->getHost(KnownHostsSearchMethod::byPublicId, $_POST['host_id']);
    }
    catch (HostNotKnownException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'status_code' => 112,
            'message' => 'Invalid Host ID'
        ));
    }
    catch (Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'status_code' => 104,
            'error_code' => $exception->getCode(),
            'message' => 'Internal Server Error'
        ));
    }

    $VerificationCode->Status = OtlStatus::Used;
    $VerificationCode->Vendor = $_POST['vendor'];
    $IntellivoidAccounts->getOtlManager()->updateOtlRecord($VerificationCode);

    $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
        $Account->ID, $KnownHost->ID,
        LoginStatus::Successful, $VerificationCode->Vendor,
        $_POST['user_agent']
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

    returnJsonResponse(array(
        'status' => true,
        'response_code' => 200,
        'account' => $ResponseObject
    ));