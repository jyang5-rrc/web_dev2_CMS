<?php

class util
{

    /**
     * @throws JsonException
     */
    public static function jsonSuccess($msg = 'success', $data = []) {
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $msg,
            'status' => 1,
            'data' => $data
        ], JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @throws JsonException
     */
    public static function jsonError($msg = '', $status = 0)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $msg,
            'status' => $status
        ], JSON_THROW_ON_ERROR);
        exit();
    }
}




