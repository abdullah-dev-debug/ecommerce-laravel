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
    public const MSG_REG = self::PAGE_KEY . Messages::MSG_REG_SUCCESS;
    public const MSG_LOGIN = self::PAGE_KEY . Messages::MSG_LOGIN_SUCCESS;
    public const MSG_LOGOUT = self::PAGE_KEY . Messages::MSG_LOGOUT_SUCCESS;
    public const MSG_UPDATE = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const CURRENT_ROLE = 1;
    private function returnProfileView(): string
    {
        return "admin.profile";
    }
    private function returnAdminRoutes()
    {
        return [
            "register" => "admin.register",
            "login" => "admin.login",
            "dashboard" => "admin.dashboard",
        ];
    }

    protected $service;
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Admin());
        $this->service = new BaseAuthService(Admin::class, $appUtils);
    }

    private function prepareData($request): array
    {
        $validatedData = $request->validated();
        $validatedData['ip'] = $request->ip();
        $data = [
            ...$validatedData,
            'role_id' => self::CURRENT_ROLE,
        ];

        return $data;
    }
    public function register(AdminRequest $request): RedirectResponse
    {
        $route = $this->returnAdminRoutes();
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request);
            $this->service->register($validatedData);
        }, self::MSG_REG, false, $route['login']);
    }
    public function update(int|string $vendor, AdminRequest $request): RedirectResponse
    {
        $route = $this->returnAdminRoutes();
        return parent::handleOperation(function () use ($vendor, $request) {
            $validatedData = $request->validated();
            parent::updateResource($vendor, $validatedData);
        }, self::MSG_UPDATE, false, $route['dashboard']);
    }

    public function login(AdminRequest $request)
    {
        return parent::executeWithTryCatch(function () use ($request) {
            $data = $request->validated();

            $route = $this->returnAdminRoutes();
            $this->service->login($data,'admin');
            return redirect()->route($route['dashboard'])->with('success', self::MSG_LOGIN);
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
            $route = $this->returnAdminRoutes();
            return redirect()->route($route['login'])->with('success', self::MSG_LOGOUT);

        });
    }
}
