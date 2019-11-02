<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['callback']))
    {
        HTML::importScript('render_alert');

        switch((int)$_GET['callback'])
        {
            case 100:
                RenderAlert(TEXT_CALLBACK_100, "success", "mdi-checkbox-marked-circle-outline");
                break;

            case 101:
                RenderAlert(TEXT_CALLBACK_101, "danger", "mdi-alert-circle");
                break;

            case 102:
                RenderAlert(TEXT_CALLBACK_102, "danger", "mdi-alert-circle");
                break;

            case 103:
                RenderAlert(TEXT_CALLBACK_103, "success", "mdi-checkbox-marked-circle-outline");
                break;

            case 104:
                RenderAlert(TEXT_CALLBACK_104, "danger", "mdi-alert-circle");
                break;

            case 105:
                RenderAlert(TEXT_CALLBACK_105, "success", "mdi-checkbox-marked-circle-outline");
                break;

            case 106:
                RenderAlert(TEXT_CALLBACK_106, "danger", "mdi-alert-circle");
                break;

            case 107:
                RenderAlert(TEXT_CALLBACK_107, "success", "mdi-checkbox-marked-circle-outline");
                break;

            case 108:
                RenderAlert(TEXT_CALLBACK_108, "danger", "mdi-alert-circle");
                break;

            case 109:
                RenderAlert(TEXT_CALLBACK_109, "danger", "mdi-alert-circle");
                break;

            case 110:
                RenderAlert(TEXT_CALLBACK_110, "danger", "mdi-alert-circle");
                break;

            case 111:
                RenderAlert(TEXT_CALLBACK_111, "danger", "mdi-alert-circle");
                break;

            case 112:
                RenderAlert(TEXT_CALLBACK_112, "success", "mdi-checkbox-marked-circle-outline");
                break;
        }
    }