<?php

    function returnJsonResponse(array $payload)
    {
        $response = json_encode($payload);
        if(isset($payload['response_code']))
        {
            http_response_code($payload['response_code']);
        }
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($response));
        print($response);
        exit();
    }