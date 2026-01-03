<?php

namespace App\Http\Controllers\Assets;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandAssetsRequest;
use App\Models\Unit;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    public const PAGE_KEY = 'Unit';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Unit());
    }

    public function store(BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data) {
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $unit, BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($unit, $data) {
            $this->updateResource($unit, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $unit): RedirectResponse
    {
        return parent::handleOperation(function () use ($unit) {
            $this->deleteResource($unit);
        }, self::MSG_DELETE_SUCCESS);
    }


    public function edit(int|string $unit)
    {
        return parent::executeWithTryCatch(function () use ($unit): JsonResponse {
            $data = $this->findOrRedirect($unit);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["unit" => $data]);
        });
    }

    public function toggleStatus(int|string $unit)
    {
        return parent::executeWithTryCatch(function () use ($unit): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($unit, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

}
