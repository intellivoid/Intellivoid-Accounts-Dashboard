<?PHP

    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('resolve_coa_error');
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
        case 'create_authentication_request':
            HTML::importScript('create_authentication_request');
            break;

        case 'request_authentication':
            HTML::importScript('request_authentication');
            break;

        case 'get_access_code':
            HTML::importScript('get_access_code');
            break;

        case 'check_permissions':
            HTML::importScript('check_permissions');
            break;

        case 'get_user':
            HTML::importScript('get_user');
            break;

        default:
            returnJsonResponse(array(
                'status' => false,
                'response_code' => 101,
                'message' => 'Invalid Action'
            ));
    }
