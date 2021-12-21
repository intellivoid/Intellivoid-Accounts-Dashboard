<?php

    /**
     * Fetches an existing POST/GET parameter, returns null if it's not set
     *
     * @param string $parameter
     * @return string|null
     */
    function get_parameter(string $parameter)
    {
        if(isset($_POST[$parameter]))
        {
            return $_POST[$parameter];
        }

        if(isset($_GET[$parameter]))
        {
            return $_GET[$parameter];
        }

        return null;
    }