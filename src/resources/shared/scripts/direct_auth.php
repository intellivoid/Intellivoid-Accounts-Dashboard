<?php

    /**
     * Returns an array of allowed apps for direct authentication
     *
     * @return array|string[]
     */
    function directAuthGetApps(): array
    {
        return array(
            "todo"
        );
    }

    /**
     * Verifies if the application is applicable to a direct auth
     *
     * @param string $application_name
     * @return bool
     */
    function directAuthVerify(string $application_name): bool
    {
        if(in_array($application_name, directAuthGetApps()))
        {
            return true;
        }

        return false;
    }