<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use App\Services\BaseAuthService;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VendorController extends Controller
{
    public const PAGE_KEY = "vendor";
    public const MSG_REG = self::PAGE_KEY . Messages::MSG_REG_SUCCESS;
    public const MSG_LOGIN = self::PAGE_KEY . Messages::MSG_LOGIN_SUCCESS;
    public const MSG_LOGOUT = self::PAGE_KEY . Messages::MSG_LOGOUT_SUCCESS;
    public const MSG_DELETE = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const CURRENT_ROLE = 2;
    public const VIEW_NAMESPACE = "admin.vendor.";

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . "index";
    }
    private function returnCreateView(): string
    {
        return self::VIEW_NAMESPACE . "create";
    }
    private function returnEditView(): string
    {
        return self::VIEW_NAMESPACE . "edit";
    }

    private function returnProfileView(): string
    {
        return "user.profile";
    }
    private function returnVendorFilter(): array
    {
        return [
            "role_id" => self::CURRENT_ROLE
        ];
    }

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

    public function create(): View
    {
        $view = $this->returnCreateView();
        return $this->successView($view);
    }

    public function edit(int|string $vendor): View
    {
        $view = $this->returnEditView();
        $data = parent::findOrRedirect($vendor);
        return $this->successView($view, ["vendor" => $data]);
    }

    public function index(): mixed
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $filter = $this->returnVendorFilter();
            $list = parent::getAllResources($filter);
            return $this->successView($view, ["vendors" => $list]);
        });
    }

    public function destroy(int|string $vendor): RedirectResponse
    {
        return parent::handleOperation(function () use ($vendor) {
            parent::deleteResource($vendor);
        }, self::MSG_DELETE);
    }

    public function store(VendorRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request, 1, true);
            $this->service->register($validatedData);
        }, self::MSG_REG);
    }

    public function register(VendorRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request, 0);
            $this->service->register($validatedData);
        }, self::MSG_REG);
    }

    public function update(int|string $vendor, VendorRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($vendor, $request) {
            $validatedData = $request->validated();
            parent::updateResource($vendor, $validatedData);
        }, self::MSG_UPDATE);
    }

    public function login(VendorRequest $request)
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
