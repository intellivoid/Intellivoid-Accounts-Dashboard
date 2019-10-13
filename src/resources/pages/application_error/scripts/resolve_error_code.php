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
                HTML::print("ERROR CODE 5: MISSING PARAMETER 'redirect'");
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