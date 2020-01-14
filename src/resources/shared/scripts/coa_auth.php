<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;

    if(isset($_GET['auth']))
    {
        if($_GET['auth'] == 'application')
        {
            Actions::redirect(DynamicalWeb::getRoute('application_authenticate', $_GET));
        }
    }