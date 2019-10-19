<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('json_response');
    HTML::importScript('request_parser');

    if(get_parameter('action') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 100,
            'message' => 'Missing parameter \'action\''
        ));
    }

    switch(strtolower(get_parameter('action')))
    {
        case 'request_authentication':
            HTML::importScript('request_authentication');
            break;

        case 'access_account':
            HTML::importScript('access_account');
            break;

        default:
            returnJsonResponse(array(
                'status' => false,
                'response_code' => 101,
                'message' => 'Invalid Action'
            ));
    }
