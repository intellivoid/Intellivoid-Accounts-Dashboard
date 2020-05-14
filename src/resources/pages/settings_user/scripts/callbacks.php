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
                RenderAlert(TEXT_CALLBACK_104, "danger", "icon-alert-triangle");
                break;

            case 105:
                RenderAlert(TEXT_CALLBACK_105, "danger", "icon-alert-triangle");
                break;

            case 106:
                RenderAlert(TEXT_CALLBACK_106, "success", "icon-check-circle");
                break;

            case 107:
                RenderAlert(TEXT_CALLBACK_107, "danger", "icon-alert-triangle");
                break;

            case 108:
                RenderAlert(TEXT_CALLBACK_108, "success", "icon-check-circle");
                break;

            case 109:
                RenderAlert(TEXT_CALLBACK_109, "success", "icon-check-circle");
                break;

            case 110:
                RenderAlert(TEXT_CALLBACK_110, "danger", "icon-alert-triangle");
                break;

            case 111:
                RenderAlert(TEXT_CALLBACK_111, "danger", "icon-alert-triangle");
                break;

            case 112:
                RenderAlert(TEXT_CALLBACK_112, "danger", "icon-alert-triangle");
                break;

            case 113:
                RenderAlert(TEXT_CALLBACK_113, "danger", "icon-alert-triangle");
                break;

            case 114:
                RenderAlert(TEXT_CALLBACK_114, "danger", "icon-alert-triangle");
                break;

            case 115:
                RenderAlert(TEXT_CALLBACK_115, "success", "icon-check-circle");
                break;

            case 116:
                RenderAlert(TEXT_CALLBACK_116, "danger", "icon-alert-triangle");
                break;

            case 117:
                RenderAlert(TEXT_CALLBACK_117, "danger", "icon-alert-triangle");
                break;

            case 118:
                RenderAlert(TEXT_CALLBACK_118, "danger", "icon-alert-triangle");
                break;

            case 119:
                RenderAlert(TEXT_CALLBACK_119, "success", "icon-check-circle");
                break;
        }
    }