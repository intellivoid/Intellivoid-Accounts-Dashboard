<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['error_code']))
    {
        HTML::importScript('resolve_coa_error');
        HTML::print("ERROR CODE " .(int)$_GET['error_code'] . ": " . resolve_error_code((int)$_GET['error_code']));
    }
    else
    {
        HTML::print("ERROR CODE NOT DEFINED");
    }