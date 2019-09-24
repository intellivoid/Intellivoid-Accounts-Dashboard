<?php

    function returnJsonResponse(array $payload)
    {
        $response = json_encode($payload);
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($response));
        print($response);
        exit();
    }