<?PHP

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('json_response');
    HTML::importScript('request_parser');

    if(get_parameter('client_id') == null)
    {
        Actions::redirect(DynamicalWeb::getRoute('login'));
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
        $IntellivoidAccounts->getTelegramClientManager()->getClient(
            TelegramClientSearchMethod::byPublicId, get_parameter('client_id')
        );
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('login'));
    }

    Actions::redirect(DynamicalWeb::getRoute('login',
        array('auth' => 'telegram', 'client_id' => get_parameter('client_id'))
    ));
