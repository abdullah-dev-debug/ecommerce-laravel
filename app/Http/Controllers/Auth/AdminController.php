<?php

namespace App\Http\Controllers\Auth;
use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Services\BaseAuthService;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public const PAGE_KEY = "Admin";
    public const MSG_LOGIN = self::PAGE_KEY . Messages::MSG_LOGIN_SUCCESS;
    public const MSG_LOGOUT = self::PAGE_KEY . Messages::MSG_LOGOUT_SUCCESS;
    public const MSG_UPDATE = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const CURRENT_ROLE = 1;
    private function returnProfileView(): string
    {
        return "admin.profile";
    }

    protected $service;
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Admin());
        $this->service = new BaseAuthService(Admin::class, $appUtils);
    }

    public function update(int|string $vendor, AdminRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($vendor, $request) {
            $validatedData = $request->validated();
            parent::updateResource($vendor, $validatedData);
        }, self::MSG_UPDATE);
    }

    public function login(AdminRequest $request)
    {
        return parent::executeWithTryCatch(function () use ($request): View {
            $data = $request->validated();
            $view = $this->returnProfileView();
            $this->service->login($data);
            return $this->successView($view);
        });
    }

    public function profile()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnProfileView();
            $profile = $this->service->profile();
            return $this->successView($view, [
                "profile" => $profile
            ]);
        });
    }

    public function logout()
    {
        return parent::executeWithTryCatch(function (): RedirectResponse {
            $this->service->logout();
            return $this->successRedirect(self::MSG_LOGOUT);
        });
    }
}
