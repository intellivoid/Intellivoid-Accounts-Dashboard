<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;

    if(isset($_GET['auth']))
    {
        if($_GET['auth'] == 'telegram')
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_login_security', $_GET));
        }
    }