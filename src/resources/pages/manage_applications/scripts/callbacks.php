<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['callback']))
    {
        HTML::importScript('render_alert');

        switch((int)$_GET['callback'])
        {
            case 100:
                RenderAlert(TEXT_CALLBACK_100, "danger", "icon-alert-triangle");
                break;

            case 101:
                RenderAlert(TEXT_CALLBACK_101, "warning", "icon-alert-triangle");
                break;

            case 102:
                RenderAlert(TEXT_CALLBACK_102, "danger", "icon-alert-triangle");
                break;

            case 103:
                RenderAlert(TEXT_CALLBACK_103, "danger", "icon-alert-triangle");
                break;

            case 104:
                RenderAlert(TEXT_CALLBACK_104, "warning", "icon-alert-triangle");
                break;

            case 105:
                RenderAlert(TEXT_CALLBACK_105, "danger", "icon-alert-triangle");
                break;

            case 106:
                RenderAlert(TEXT_CALLBACK_106, "success", "icon-check-circle");
                break;

            case 107:
                RenderAlert(TEXT_CALLBACK_107, "warning", "icon-alert-triangle");
                break;

            case 108:
                RenderAlert(TEXT_CALLBACK_108, "success", "icon-check-circle");
                break;

            case 109:
                RenderAlert(TEXT_CALLBACK_109, "warning", "icon-alert-triangle");
                break;
        }
    }