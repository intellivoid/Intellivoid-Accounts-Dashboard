<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['callback']))
    {
        HTML::importScript('render_alert');

        switch((int)$_GET['callback'])
        {
            case 100:
                RenderAlert(TEXT_CALLBACK_100, "danger", "mdi-alert-circle");
                break;

            case 101:
                RenderAlert(TEXT_CALLBACK_101, "warning", "mdi-alert-circle");
                break;
        }
    }