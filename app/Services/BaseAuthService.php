<?php

namespace App\Services;

use App\Utils\AppUtils;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BaseAuthService
{
    protected const RES_EXIST_EMAIL_MSG = "Email Already Exist";

    protected $model;
    protected $utils;

    public function __construct(string $modelClass, AppUtils $appUtils)
    {
        $this->model = $modelClass;
        $this->utils = $appUtils;
    }

    /**
     * Register a new user/admin
     */
    public function register(array $data = [])
    {
        $email = strtolower($data['email']);

        if ($this->utils->checkDuplicateEmail($email, $this->model)) {
            return $this->utils->webErrorRedirect(self::RES_EXIST_EMAIL_MSG);
        }

        $user = $this->model::create($data);

        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }

    /**
     * Verify email
     */
    public function verifyEmail($userId, $hash)
    {
        $user = $this->model::find($userId);

        if (!$user) {
            return $this->utils->webErrorRedirect('User not found');
        }

        if (!hash_equals((string)$hash, sha1($user->getEmailForVerification()))) {
            return $this->utils->webErrorRedirect('Invalid verification link');
        }

        if ($user->hasVerifiedEmail()) {
            return $this->utils->webErrorRedirect('Email already verified');
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified successfully']);
    }

    /**
     * Login user/admin/etc
     */

    private function trackIp($user)
    {
        $currentIp = request()->ip();

        if ($user->ip !== $currentIp) {
            $user->update(['ip' => $currentIp]);
        }
    }

    public function login(array $data = [], ?string $authKey = null, bool $useApi = false, ?string $tokenName = null)
    {
        $user = $this->utils->getUserByEmail($this->model, $data);
        $error = $this->utils->validateLoginCredentials($user, $data, true);
        if ($error instanceof JsonResponse) {
            return null;
        }

        $token = null;
        if ($useApi && $authKey === null) {
            $token = $user->createToken($tokenName ?? 'api_token')->plainTextToken;
        } else {
            $this->trackIp($user);
            Auth::guard($authKey)->login($user);
            request()->session()->regenerate();
        }

        return $this->formatUserResponse($this->model, $user, $token);
    }


    /**
     * Get all users/admins profile
     */
    public function profile(): Collection
    {
        $query = $this->model::query();

        if (method_exists($this->model, 'role')) {
            $query->with('role');
        }

        $hidden = Schema::hasColumn((new $this->model)->getTable(), 'role_id') ? ['role_id'] : [];

        return $query->get()->makeHidden($hidden);
    }

    /**
     * Logout user/admin
     */
    public function logout(bool $useApi = false, ?string $authKey = null): bool|null
    {
        return $useApi && $authKey === null
            ? request()->user()->currentAccessToken()->delete()
            : Auth::guard()->logout();
    }


    private function formatUserResponse($model, $user, ?string $token = null): array
    {
        $table = (new $model)->getTable();

        $userData = [
            'email' => $user->email,
        ];

        if (Schema::hasColumn($table, 'first_name') && Schema::hasColumn($table, 'last_name')) {
            $userData['first_name'] = $user->first_name;
            $userData['last_name'] = $user->last_name;
        } elseif (Schema::hasColumn($table, 'name')) {
            $userData['name'] = $user->name;
        }

        if ($token) {
            $userData['token'] = $token;
        }

        return $userData;
    }
}
