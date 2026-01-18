<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Messages;
use App\Constants\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use App\Services\BaseAuthService;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public const PAGE_KEY = "vendor";
    public const MSG_REG = self::PAGE_KEY . Messages::MSG_REG_SUCCESS;
    public const MSG_LOGIN = self::PAGE_KEY . Messages::MSG_LOGIN_SUCCESS;
    public const MSG_LOGOUT = self::PAGE_KEY . Messages::MSG_LOGOUT_SUCCESS;
    public const MSG_DELETE = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const CURRENT_ROLE = Role::VENDOR;
    public const AUTH_VIEW_NAMESPACE = "vendor.auth";

    private function prepareData($request, $status = 1, $isVerify = false): array
    {
        $validatedData = $request->validated();
        $validatedData['status'] = $status;
        $validatedData['ip'] = $request->ip();
        $data = [
            ...$validatedData,
            'role_id' => self::CURRENT_ROLE,
        ];

        if ($isVerify) {
            $data['email_verified_at'] = now();
        }

        return $data;
    }

    protected $service;
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Vendor());
        $this->service = new BaseAuthService(Vendor::class, $appUtils);
    }

    public function register(VendorRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request, 0);
            $this->service->register($validatedData);
        }, false, self::MSG_REG, $this->returnLoginView());
    }


    public function login(VendorRequest $request)
    {
        return parent::executeWithTryCatch(function () use ($request): View {
            $data = $request->validated();
            $view = $this->returnDashboardView();
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


    public function dashboard()
    {
        return parent::executeWithTryCatch(function () {
            $view = $this->returnDashboardView();
            $vendor = Auth::guard('vendor')->user() ?? null;
            $this->storeInSession($vendor);
            return $this->successView($view);
        });
    }

    protected function storeInSession($vendor)
    {
        if (!$vendor)
            return;

        session([
            'vendor' => [
                'name' => $vendor->name,
                'role_name' => $vendor->role->name ?? null,
            ],
            'last_login' => now()->toDateTimeString(),
        ]);
    }

    public function logout()
    {
        return parent::executeWithTryCatch(function (): View {
            $this->service->logout();
            return $this->successView($this->returnLoginView(), [], self::MSG_LOGOUT);
        });
    }

    private function returnDashboardView(): string
    {
        return 'vendor.dashboard';
    }
    private function returnLoginView(): string
    {
        return self::AUTH_VIEW_NAMESPACE . '.login';
    }
    private function returnProfileView(): string
    {
        return self::AUTH_VIEW_NAMESPACE . ".profile";
    }
}
