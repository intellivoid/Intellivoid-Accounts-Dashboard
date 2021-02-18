<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;

    if(isset($_GET['auth']))
    {
        if($_GET['auth'] == 'application')
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_authenticate', $_GET));
        }
    }