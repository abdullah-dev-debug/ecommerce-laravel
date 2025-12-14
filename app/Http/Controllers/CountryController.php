<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CountryController extends Controller
{
    public const PAGE_KEY = 'Country';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const VIEW_NAMESPACE = "admin.country.";
    public const PARENT_FOLDER = "country";
    public const CHILD_FOLDER = "flags";
    public const FILE_KEY = "flag";
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Country());
    }

    public function store(CountryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data, $request) {
            $data[self::FILE_KEY] = $this->uploadFlag($request, self::FILE_KEY);
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $country, CountryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($country, $data, $request) {
            $data[self::FILE_KEY] = $this->uploadFlag($request, self::FILE_KEY);
            $this->updateResource($country, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $country): RedirectResponse
    {
        return parent::handleOperation(function () use ($country) {
            $data = parent::findOrRedirect($country);
            if ($data->flag && !empty($data->flag)) {
                DeleteFile($data->flag);
            }
            $this->deleteResource($country);
        }, self::MSG_DELETE_SUCCESS);
    }
    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $data = parent::getAllResources();
            return $this->successView($view, ["countries" => $data]);
        });
    }

    public function edit(int|string $country)
    {
        return parent::executeWithTryCatch(function () use ($country): JsonResponse {
            $data = $this->findOrRedirect($country);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["country" => $data]);
        });
    }

    public function toggleStatus(int|string $country)
    {
        return parent::executeWithTryCatch(function () use ($country): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($country, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . 'index';
    }

    private function uploadFlag($request, $fileKey): RedirectResponse|string|null
    {
        try {
            $file = $request->file($fileKey);
            if ($request->hasFile($fileKey) && $file->isValid()) {
                return UploadFile(self::PARENT_FOLDER, self::CHILD_FOLDER, $fileKey, 48, 32);
            }
            return null;
        } catch (\Throwable $th) {
            return $this->errorRedirect($th->getMessage());
        }
    }
}
