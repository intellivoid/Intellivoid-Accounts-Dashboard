<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['callback']))
    {
        HTML::importScript('render_alert');

        switch((int)$_GET['callback'])
        {
            case 100:
                RenderAlert("There was an issue with your request, please make sure you are using an up to date browser", "danger", "mdi-alert-circle");
                break;

            case 101:
                RenderAlert("The given password is invalid, it must be greater than 8 characters but no greater than 128", "danger", "mdi-alert-circle");
                break;

            case 102:
                RenderAlert("There was an error while trying to process your request, try again later.", "danger", "mdi-alert-circle");
                break;
        }
    }