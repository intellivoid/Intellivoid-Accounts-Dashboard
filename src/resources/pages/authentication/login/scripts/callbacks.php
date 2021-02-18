<?php

    use DynamicalWeb\HTML;


    if(isset($_GET['callback']))
    {
        HTML::importScript('render_auth_alert');

        switch((int)$_GET['callback'])
        {
            case 100:
                RenderAuthError(TEXT_CALLBACK_100);
                break;

            case 101:
                RenderAuthError(TEXT_CALLBACK_101);
                break;

            case 102:
                RenderAuthError(TEXT_CALLBACK_102);
                break;

            case 103:
                RenderAuthError(TEXT_CALLBACK_103);
                break;

            case 104:
                RenderAuthError(TEXT_CALLBACK_104);
                break;

            case 105:
                RenderAuthWarning(TEXT_CALLBACK_105);
                break;

            case 106:
                RenderAuthSuccess(TEXT_CALLBACK_106);
                break;

            case 107:
                RenderAuthWarning(TEXT_CALLBACK_107);
                break;

            case 108:
                RenderAuthWarning(TEXT_CALLBACK_108);
                break;

            case 109:
                RenderAuthError(TEXT_CALLBACK_109);
                break;

            case 110:
                RenderAuthPrimary(TEXT_CALLBACK_110);
                break;
        }
    }