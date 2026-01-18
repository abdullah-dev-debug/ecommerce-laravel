<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public const PAGE_KEY = 'Role';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const VIEW_NAMESPACE = "admin.role.";
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Role());
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data) {
            $this->createResource($data);
        }, true,self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $role, RoleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($role, $data) {
            $this->updateResource($role, $data);
        }, true,self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $role): RedirectResponse
    {
        return parent::handleOperation(function () use ($role) {
            $this->deleteResource($role);
        }, true,self::MSG_DELETE_SUCCESS);
    }
    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $data = parent::getAllResources();
            return $this->successView($view, ["roles" => $data]);
        });
    }

    public function edit(int|string $role)
    {
        return parent::executeWithTryCatch(function () use ($role): JsonResponse {
            $data = $this->findOrRedirect($role);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["role" => $data]);
        });
    }

    public function toggleStatus(int|string $role)
    {
        return parent::executeWithTryCatch(function () use ($role): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($role, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . 'index';
    }
}
