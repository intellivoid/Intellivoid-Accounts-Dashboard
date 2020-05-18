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
                RenderAlert(TEXT_CALLBACK_101, "danger", "icon-alert-triangle");
                break;

            case 102:
                RenderAlert(TEXT_CALLBACK_102, "danger", "icon-alert-triangle");
                break;

            case 103:
                RenderAlert(TEXT_CALLBACK_103, "success", "icon-check-circle");
                break;

            case 104:
                RenderAlert(TEXT_CALLBACK_104, "warning", "icon-alert-triangle");
                break;

            case 105:
                RenderAlert(TEXT_CALLBACK_105, "danger", "icon-alert-triangle");
                break;

            case 106:
                RenderAlert(TEXT_CALLBACK_106, "danger", "icon-alert-triangle");
                break;

            case 107:
                RenderAlert(TEXT_CALLBACK_107, "danger", "icon-alert-triangle");
                break;

            case 108:
                RenderAlert(TEXT_CALLBACK_108, "danger", "icon-alert-triangle");
                break;

            case 109:
                RenderAlert(TEXT_CALLBACK_109, "danger", "icon-alert-triangle");
                break;

            case 110:
                RenderAlert(TEXT_CALLBACK_110, "success", "icon-check-circle");
                break;

            case 111:
                RenderAlert(TEXT_CALLBACK_111, "danger", "icon-alert-triangle");
                break;

            case 112:
                RenderAlert(TEXT_CALLBACK_112, "danger", "icon-alert-triangle");
                break;

            case 113:
                RenderAlert(TEXT_CALLBACK_113, "success", "icon-check-circle");
                break;

            case 114:
                RenderAlert(TEXT_CALLBACK_114, "danger", "icon-alert-triangle");
                break;

            case 115:
                RenderAlert(TEXT_CALLBACK_115, "warning", "icon-alert-triangle");
                break;

        }
    }