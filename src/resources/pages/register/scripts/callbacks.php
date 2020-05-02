<?php

    use DynamicalWeb\HTML;

    function RenderAuthError(string $text)
    {
        HTML::print("<span class=\"text-danger font-small-2 auth-error\">", false);
        HTML::print($text);
        HTML::print("</span>", false);
    }

    if(isset($_GET['callback']))
    {
        HTML::importScript('render_alert');

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
                RenderAuthError(TEXT_CALLBACK_105);
                break;

            case 106:
                RenderAuthError(TEXT_CALLBACK_106);
                break;

            case 107:
                RenderAuthError(TEXT_CALLBACK_107);
                break;

            case 108:
                RenderAuthError(TEXT_CALLBACK_108);
                break;
        }
    }