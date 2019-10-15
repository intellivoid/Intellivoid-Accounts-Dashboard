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

            default:
                HTML::print("ERROR CODE " . (int)$_GET['error_code'] . ': UNKNOWN');
                break;
        }
    }
    else
    {
        HTML::print("ERROR CODE NOT DEFINED");
    }