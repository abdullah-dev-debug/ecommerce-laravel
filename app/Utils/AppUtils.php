<?php

namespace App\Utils;

use App\Exceptions\MyCustomException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AppUtils
{
    // ==================== API RESPONSE METHODS ====================

    public static function apiResponse(
        string $mainKey,
        string $message,
        int $statusCode = 200,
        array $additionalData = [],
        string $statusKey = 'success',
        bool $statusValue = true
    ): JsonResponse {
        $response = [
            $statusKey => $statusValue
        ];
        if (!empty($mainKey)) {
            $response[$mainKey] = $message;
        }
        if (!empty($additionalData)) {
            $response = array_merge($response, $additionalData);
        }
        return response()->json($response, $statusCode);
    }

    public static function apiSuccess(string $message, array $data = [], int $statusCode = 200): JsonResponse
    {
        return static::apiResponse('message', $message, $statusCode, $data, 'success', true);
    }

    public static function apiError(string $message, int $statusCode = 400, array $data = []): JsonResponse
    {
        return static::apiResponse('error', $message, $statusCode, $data, 'success', false);
    }

    public static function apiNotFound(string $message = "Resource not found"): JsonResponse
    {
        return static::apiError($message, 404);
    }

    // ==================== WEB RESPONSE METHODS ====================

    public static function webSuccessRedirect(string $message): RedirectResponse
    {
        return redirect()->back()->with('success', $message);
    }

    public static function webErrorRedirect(string $message): RedirectResponse
    {
        return redirect()->back()->withInput()->with('error', $message);
    }

    public static function webSuccessView(string $view, array $data = [], string $message = ''): View
    {
        $viewData = array_merge($data, ['success' => $message]);
        return view($view, $viewData);
    }

    public static function webErrorView(string $view, array $data = [], string $message = ''): View
    {
        $viewData = array_merge($data, ['error' => $message]);
        return view($view, $viewData);
    }

    // ==================== VALIDATION METHODS ====================

    public static function checkDuplicateEmail($email, $modelClass, bool $useApi = false, string $message = "Email Already Exist"): JsonResponse|RedirectResponse|null
    {
        $exists = $modelClass::whereEmail($email)->exists();

        if ($exists) {
            return $useApi
                ? static::apiError($message, 409)
                : static::webErrorRedirect($message);
        }

        return null;
    }

    public static function validateLoginCredentials($user, $validatedData, bool $useApi = false, string $userNotFoundMessage = "User Not Found!"): JsonResponse|RedirectResponse|null
    {
        // User not found
        if (!$user) {
            return $useApi
                ? static::apiError($userNotFoundMessage, 404)
                : static::webErrorRedirect($userNotFoundMessage);
        }

        // Password incorrect
        if (!Hash::check($validatedData['password'], $user->password)) {
            return $useApi
                ? static::apiError("Invalid Password", 401)
                : static::webErrorRedirect("Invalid Password");
        }

        // Credentials correct
        return null;
    }



    // ==================== DATA METHODS ====================

    public static function getUserByEmail($modelClass, $validatedData)
    {
        return $modelClass::whereEmail($validatedData['email'])->first();
    }

    public static function nullCheck($item, string $message)
    {
        return !$item ? throw new MyCustomException($message, 404) : $item;
    }


    // ==================== UNIVERSAL METHODS (Backward Compatibility) ====================

    /**
     * @deprecated Use specific methods instead
     */
    public static function SuccessResponse(string $message, ?int $statusCode = null, bool $useApi = false, array $additionalData = []): JsonResponse|RedirectResponse
    {
        return $useApi
            ? static::apiSuccess($message, $additionalData, $statusCode ?? 200)
            : static::webSuccessRedirect($message);
    }

    /**
     * @deprecated Use specific methods instead
     */
    public static function ErrorResponse(string $message, bool $useRedirect = false, string $view = '', array $data = [], bool $useApi = false, ?int $statusCode = null): JsonResponse|RedirectResponse|View
    {
        if ($useApi) {
            return static::apiError($message, $statusCode ?? 400);
        }

        if ($useRedirect) {
            return static::webErrorRedirect($message);
        }

        return static::webErrorView($view, $data, $message);
    }

    public static function merge_items(array ...$arrays): array
    {
        $merged = [];
        foreach ($arrays as $array) {
            $merged = [...$merged, ...$array];
        }
        return $merged;
    }

}
