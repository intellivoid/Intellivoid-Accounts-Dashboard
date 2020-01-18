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
                RenderAlert(TEXT_CALLBACK_101, "danger", "mdi-alert-circle");
                break;

            case 102:
                RenderAlert(TEXT_CALLBACK_102, "danger", "mdi-alert-circle");
                break;

            case 103:
                RenderAlert(TEXT_CALLBACK_103, "danger", "mdi-alert-circle");
                break;

            case 104:
                RenderAlert(TEXT_CALLBACK_104, "danger", "mdi-alert-circle");
                break;
        }
    }