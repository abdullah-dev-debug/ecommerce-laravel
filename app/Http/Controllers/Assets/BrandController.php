<?php

namespace App\Http\Controllers\Assets;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandAssetsRequest;
use App\Models\Brand;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    public const PAGE_KEY = 'Brand';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const VIEW_NAMESPACE = "admin.brand.";
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Brand());
    }

    public function store(BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data) {
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $brand, BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($brand, $data) {
            $this->updateResource($brand, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $brand): RedirectResponse
    {
        return parent::handleOperation(function () use ($brand) {
            $this->deleteResource($brand);
        }, self::MSG_DELETE_SUCCESS);
    }
    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $data = parent::getAllResources();
            return $this->successView($view, ["brands" => $data]);
        });
    }

    public function edit(int|string $brand)
    {
        return parent::executeWithTryCatch(function () use ($brand): JsonResponse {
            $data = $this->findOrRedirect($brand);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["brand" => $data]);
        });
    }

    public function toggleStatus(int|string $brand)
    {
        return parent::executeWithTryCatch(function () use ($brand): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($brand, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . '.index';
    }
}
