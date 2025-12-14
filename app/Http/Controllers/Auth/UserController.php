<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\BaseAuthService;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public const PAGE_KEY = "Customer";
    public const MSG_REG = self::PAGE_KEY . Messages::MSG_REG_SUCCESS;
    public const MSG_LOGIN = self::PAGE_KEY . Messages::MSG_LOGIN_SUCCESS;
    public const MSG_LOGOUT = self::PAGE_KEY . Messages::MSG_LOGOUT_SUCCESS;
    public const MSG_DELETE = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const CURRENT_ROLE = 3;
    public const VIEW_NAMESPACE = "admin.user.";

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

    private function returnUserFilter(): array
    {
        return [
            "role_id" => self::CURRENT_ROLE
        ];
    }

    private function prepareData($request, $status = 1, $isVerify = false): array
    {
        $validatedData = $request->validated();
        $validatedData['ip'] = $request->ip();
        $validatedData['status'] = $status;
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
        parent::__construct($appUtils, new User());
        $this->service = new BaseAuthService(User::class, $appUtils);
    }

    public function create(): View
    {
        $view = $this->returnCreateView();
        return $this->successView($view);
    }
    public function edit(int|string $user): View
    {
        $view = $this->returnEditView();
        $data = parent::findOrRedirect($user);
        return $this->successView($view, ["user" => $data]);
    }
    public function index(): mixed
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $filter = $this->returnUserFilter();
            $list = parent::getAllResources($filter);
            return $this->successView($view, ["users" => $list]);
        });
    }

    public function destroy(int|string $client): RedirectResponse
    {
        return parent::handleOperation(function () use ($client) {
            parent::deleteResource($client);
        }, self::MSG_DELETE);
    }


    public function store(UserRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request);
            $this->service->register($validatedData);
        }, self::MSG_REG);
    }

    public function register(UserRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request, 0, true);
            $this->service->register($validatedData);
        }, self::MSG_REG);
    }

    public function update(int|string $user, UserRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($user, $request) {
            $data = $request->validated();
            parent::updateResource($user, $data);
        }, self::MSG_UPDATE);
    }

    public function login(UserRequest $request)
    {
        return parent::executeWithTryCatch(function () use ($request): View {
            $data = $request->validated();
            $view = $this->returnProfileView();
            $this->service->login($data);
            return $this->successView($view, [],);
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
