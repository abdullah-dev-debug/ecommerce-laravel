<?php

namespace App\Http\Controllers\Assets;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandAssetsRequest;
use App\Models\Color;
use App\Utils\AppUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ColorController extends Controller
{
    public const PAGE_KEY = 'Color';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Color());
    }

    public function store(BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data) {
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $color, BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($color, $data) {
            $this->updateResource($color, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $color): RedirectResponse
    {
        return parent::handleOperation(function () use ($color) {
            $this->deleteResource($color);
        }, self::MSG_DELETE_SUCCESS);
    }

    public function edit(int|string $color)
    {
        return parent::executeWithTryCatch(function () use ($color): JsonResponse {
            $data = $this->findOrRedirect($color);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["color" => $data]);
        });
    }

    public function toggleStatus(int|string $color)
    {
        return parent::executeWithTryCatch(function () use ($color): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($color, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

}
