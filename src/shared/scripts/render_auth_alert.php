<?php

    use DynamicalWeb\HTML;

    /**
     * Renders a text-danger alert
     *
     * @param string $text
     */
    function RenderAuthError(string $text)
    {
        HTML::print("<span class=\"text-danger font-small-2 auth-error\">", false);
        HTML::print($text);
        HTML::print("</span>", false);
    }

    /**
     * Renders a text-warning alert
     *
     * @param string $text
     */
    function RenderAuthWarning(string $text)
    {
        HTML::print("<span class=\"text-warning font-small-2 auth-error\">", false);
        HTML::print($text);
        HTML::print("</span>", false);
    }

    /**
     * Renders a text-success alert
     *
     * @param string $text
     */
    function RenderAuthSuccess(string $text)
    {
        HTML::print("<span class=\"text-success font-small-2 auth-error\">", false);
        HTML::print($text);
        HTML::print("</span>", false);
    }

    /**
     * Renders a text-primary alert
     *
     * @param string $text
     */
    function RenderAuthPrimary(string $text)
    {
        HTML::print("<span class=\"text-primary font-small-2 auth-error\">", false);
        HTML::print($text);
        HTML::print("</span>", false);
    }