<?php

    /**
     * Parses the URL and returns the location to redirect to using the given parameters
     *
     * @param string $url
     * @param array $parameters
     * @return string
     */
    function create_redirect_location(string $url, array $parameters): string
    {
        $ParsedUrl = parse_url($url);
        $CurrentParameters = array();

        if(isset($ParsedUrl['query']))
        {
            parse_str($ParsedUrl['query'], $CurrentParameters);
            unset($ParsedUrl['query']);
        }

        foreach($parameters as $key => $value)
        {
            $CurrentParameters[$key] = $value;
        }

        $ParsedUrl['query'] = http_build_query($CurrentParameters);

        return build_url_from_array($ParsedUrl);
    }

    /**
     * Builds the URL From the array
     *
     * @param array $parsed
     * @return string
     */
    function build_url_from_array(array $parsed): string
    {
        $get = function ($key) use ($parsed) {
            return isset($parsed[$key]) ? $parsed[$key] : null;
        };

        $pass      = $get('pass');
        $user      = $get('user');
        $userinfo  = $pass !== null ? "$user:$pass" : $user;
        $port      = $get('port');
        $scheme    = $get('scheme');
        $query     = $get('query');
        $fragment  = $get('fragment');
        $authority =
            ($userinfo !== null ? "$userinfo@" : '') .
            $get('host') .
            ($port ? ":$port" : '');

        return
            (strlen($scheme) ? "$scheme:" : '') .
            (strlen($authority) ? "//$authority" : '') .
            $get('path') .
            (strlen($query) ? "?$query" : '') .
            (strlen($fragment) ? "#$fragment" : '');
    }