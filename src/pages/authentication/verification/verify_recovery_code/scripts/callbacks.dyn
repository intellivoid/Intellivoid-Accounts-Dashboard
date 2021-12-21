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
                RenderAuthWarning(TEXT_CALLBACK_101);
                break;
        }
    }