<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['error_code']))
    {
        switch((int)$_GET['error_code'])
        {
            default:
                HTML::print("ERROR CODE " . (int)$_GET['error_code'] . ': UNKNOWN');
        }
    }
    else
    {
        HTML::print("ERROR CODE NOT DEFINED");
    }