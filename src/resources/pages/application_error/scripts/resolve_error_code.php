<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['error_code']))
    {
        switch((int)$_GET['error_code'])
        {
            case -1:
                HTML::print("ERROR CODE -1: INTERNAL SERVER ERROR (INTELLIVOID)");
                break;

            case 1:
                HTML::print("ERROR CODE 1: MISSING PARAMETER 'application_id'");
                break;

            case 2:
                HTML::print("ERROR CODE 2: INVALID APPLICATION ID");
                break;

            case 3:
                HTML::print("ERROR CODE 3: APPLICATION SUSPENDED");
                break;

            case 4:
                HTML::print("ERROR CODE 4: APPLICATION UNAVAILABLE");
                break;

            case 5:
                HTML::print("ERROR CODE 5: CANNOT VERIFY CLIENT HOST");
                break;

            case 6:
                HTML::print("ERROR CODE 6: MISSING PARAMETER 'redirect'");
                break;

            case 7:
                HTML::print("ERROR CODE 7: MISSING PARAMETER 'auth' IN AUTH PROMPT");
                break;

            case 8:
                HTML::print("ERROR CODE 8: MISSING PARAMETER 'application_id' IN AUTH PROMPT");
                break;

            case 9:
                HTML::print("ERROR CODE 9: MISSING PARAMETER 'request_token' IN AUTH PROMPT");
                break;

            case 10:
                HTML::print("ERROR CODE 10: INVALID APPLICATION ID IN AUTH PROMPT");
                break;

            case 11:
                HTML::print("ERROR CODE 11: INTERNAL SERVER ERROR IN AUTH PROMPT (TYPE PROMPT-01)");
                break;

            case 12:
                HTML::print("ERROR CODE 12: INVALID REQUEST TOKEN IN AUTH PROMPT");
                break;

            case 13:
                HTML::print("ERROR CODE 13: INTERNAL SERVER ERROR IN AUTH PROMPT (TYPE PROMPT-02)");
                break;

            case 14:
                HTML::print("ERROR CODE 14: MISSING PARAMETER 'redirect' IN AUTH PROMPT");
                break;

            case 15:
                HTML::print("ERROR CODE 15: UNSUPPORTED AUTHENTICATION TYPE");
                break;

            case 16:
                HTML::print("ERROR CODE 16: INVALID REDIRECT URL");
                break;

            case 17:
                HTML::print("ERROR CODE 17: MISSING PARAMETER 'verification_token' IN AUTH PROMPT->ACTION");
                break;

            case 18:
                HTML::print("ERROR CODE 18: CANNOT VERIFY REQUEST");
                break;

            case 19:
                HTML::print("ERROR CODE 19: AUTHENTICATION ACCESS DOES NOT EXIST");
                break;

            case 20:
                HTML::print("ERROR CODE 20: ALREADY AUTHENTICATED");
                break;

            case 21:
                HTML::print("ERROR CODE 21: INTERNAL SERVER ERROR WHILE TRYING TO AUTHENTICATE USER");
                break;

            case 22:
                HTML::print("ERROR CODE 22: MISSING PARAMETER 'secret_key'");
                break;

            case 23:
                HTML::print("ERROR CODE 23: ACCESS DENIED, INCORRECT SECRET KEY");
                break;

            case 24:
                HTML::print("ERROR CODE 24: MISSING PARAMETER 'access_token'");
                break;

            case 25:
                HTML::print("ERROR CODE 25: ACCESS DENIED, INCORRECT ACCESS TOKEN");
                break;

            default:
                HTML::print("ERROR CODE " . (int)$_GET['error_code'] . ': UNKNOWN');
                break;
        }
    }
    else
    {
        HTML::print("ERROR CODE NOT DEFINED");
    }