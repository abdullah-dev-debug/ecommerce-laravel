<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ErrorUtils
{
    public static function handle($th, $message, $errormsg = "Something Went Wrong!", bool $useApi = false, ?int $statusCode = 500): array|JsonResponse
    {
        Log::error($message, [
            "message" => $th->getMessage(),
            "line" => $th->getLine(),
            "trace" => $th->getTraceAsString(),
            "code" => $th->getCode(),
            "file" => $th->getFile(),
            "url" => request()->fullUrl(),
            "method" => request()->method(),
            "input" => request()->except(['icon'])
        ]);

        if ($useApi) {
            return response()->json([
                "error" => $errormsg, 
                "success" => false
            ], method_exists($th, 'getStatusCode') ? $th->getStatusCode() : $statusCode);
        }
        

        return [
            "error" => $errormsg,
            "success" => false
        ];
    }
}
