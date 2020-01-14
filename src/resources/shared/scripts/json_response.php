<?php

    function returnJsonResponse(array $payload)
    {
        $response = json_encode($payload);
        if(isset($payload['status_code']))
        {
            http_response_code($payload['status_code']);
        }
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($response));
        print($response);
        exit();
    }