<?php

    // successResponse is method to generate success response to client
    function successResponse($code = 200, $message = "success", $content = [])
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'content' => $content
        ];

        return json_encode($response);
    }

    // errorResponse is method to generate error response to client
    function errorResponse($code = 500, $message = "error")
    {
        $response = [
            'code' => $code,
            'error_message' => $message
        ];

        return json_encode($response);
    }

    // errorResponseWithContent is method to generate error response to client with content
    function errorResponseWithContent($code = 500, $message = "error", $content = [])
    {
        $response = [
            'code' => $code,
            'error_message' => $message,
            'content' => $content
        ];

        return json_encode($response);
    }
