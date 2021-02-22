<?PHP

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;
    use TelegramClientManager\Abstracts\SearchMethods\TelegramClientSearchMethod;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('json_response');
    HTML::importScript('request_parser');

    if(get_parameter("client_id") == null)
    {
        Actions::redirect(DynamicalWeb::getRoute('authentication/login'));
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
        $Client = $IntellivoidAccounts->getTelegramClientManager()->getClient(
            TelegramClientSearchMethod::byPublicId, get_parameter('client_id')
        );
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('authentication/login'));
    }


    /**
     * Sorts the query results
     *
     * @return string
     */
    function sortQuery()
    {
        $data_check_arr = [];
        foreach ($_GET as $key => $value) {
            switch($key)
            {
                case 'auth_date':
                case 'first_name':
                case 'last_name':
                case 'username':
                case 'photo_url':
                case 'id':
                    $data_check_arr[] = $key . '=' . $value;

            }
        }
        sort($data_check_arr);
        return implode("\n", $data_check_arr);
    }

    $secret_key = hash('sha256', $IntellivoidAccounts->getTelegramConfiguration()['TgBotToken'], true);

    if(hash_hmac('sha256', sortQuery(), $secret_key) !== $_GET["hash"])
    {
        Actions::redirect(DynamicalWeb::getRoute('authentication/login'));
    }

    if($_GET["auth_date"] > time() + 86400)
    {
        Actions::redirect(DynamicalWeb::getRoute('authentication/login'));
    }

    /** @noinspection PhpUndefinedVariableInspection */
    Actions::redirect(DynamicalWeb::getRoute('authentication/login',
        array_merge(['auth' => 'telegram', "verification_sign" => hash("sha256", $_GET["hash"] . $Client->ID)], $_GET)
    ));