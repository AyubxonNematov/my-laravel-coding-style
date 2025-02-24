<?php


namespace App\Dtos;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as Status;

class ApiResponse
{
    public static function success($data): JsonResponse
    {
        return Response::json([
            "data" => $data,
            "success" => true
        ], Status::HTTP_OK);
    }

    /**
     * @param $message
     * @param int $status
     * @param bool $isArray
     * @return JsonResponse
     */
    public static function error($message, int $status = Status::HTTP_OK, bool $isArray = false): JsonResponse
    {
        if ($isArray) {
            $message = reset($message)[0];
        }
        return Response::json([
            "message" => $message,
            "success" => false
        ], $status);
    }
}