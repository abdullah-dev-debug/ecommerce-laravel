<?php

namespace App\Http\Controllers\Assets;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandAssetsRequest;
use App\Models\Sizes;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class SizeController extends Controller
{
    public const PAGE_KEY = 'Size';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Sizes());
    }

    public function store(BrandAssetsRequest $request)
    {
        $data = $request->validated();
        return parent::executeWithTryCatch(function () use ($data): JsonResponse {
            $this->createResource($data);
            return $this->apiSuccessResponse(self::MSG_CREATE_SUCCESS);
        });
    }
    public function update(int|string $size, BrandAssetsRequest $request)
    {
        $data = $request->validated();
        return parent::executeWithTryCatch(function () use ($size, $data): JsonResponse {
            $this->updateResource($size, $data);
            return $this->apiSuccessResponse(self::MSG_UPDATE_SUCCESS);
        });
    }

    public function destroy(int|string $size): RedirectResponse
    {
        return parent::handleOperation(function () use ($size) {
            $this->deleteResource($size);
        }, self::MSG_DELETE_SUCCESS);
    }

    public function edit(int|string $size)
    {
        return parent::executeWithTryCatch(function () use ($size): JsonResponse {
            $data = $this->findOrRedirect($size);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["size" => $data]);
        });
    }

    public function toggleStatus(int|string $size)
    {
        return parent::executeWithTryCatch(function () use ($size): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($size, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }
}
