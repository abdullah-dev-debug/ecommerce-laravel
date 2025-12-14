<?php

namespace App\Http\Controllers\Assets;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandAssetsRequest;
use App\Models\Category;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public const PAGE_KEY = 'Category';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const PARENT_FOLDER = "category";
    public const CHILD_FOLDER = "icon";
    public const FILE_KEY = "icon";
    public const VIEW_NAMESPACE = "admin.category.";
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Category());
    }

    public function create(): View
    {
        $view = $this->returnCreateView();
        return $this->successView($view);
    }

    public function store(BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data, $request) {
            $data[self::FILE_KEY] = $this->uploadIcon($request, self::FILE_KEY);
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $category, BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($category, $data, $request) {
            $data[self::FILE_KEY] = $this->uploadIcon($request, self::FILE_KEY);
            $this->updateResource($category, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $category): RedirectResponse
    {
        return parent::handleOperation(function () use ($category) {
            $data = parent::findOrRedirect($category);
            if ($data->icon && !empty($data->icon)) {
                DeleteFile($data->icon);
            }
            $this->deleteResource($category);
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

    public function edit(int|string $category)
    {
        return parent::executeWithTryCatch(function () use ($category): View {
            $data = $this->findOrRedirect($category);
            $view = $this->returnEditView();
            return $this->successView($view, ["category" => $data]);
        });
    }

    public function toggleStatus(int|string $category)
    {
        return parent::executeWithTryCatch(function () use ($category): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($category, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . 'index';
    }
    private function returnEditView(): string
    {
        return self::VIEW_NAMESPACE . 'edit';
    }
    private function returnCreateView(): string
    {
        return self::VIEW_NAMESPACE . 'create';
    }
    // 
    private function uploadIcon($request, $fileKey): RedirectResponse|string|null
    {
        try {
            $file = $request->file($fileKey);
            if ($request->hasFile($fileKey) && $file->isValid()) {
                return UploadFile(self::PARENT_FOLDER, self::CHILD_FOLDER, $fileKey, 128, 128);
            }
            return null;
        } catch (\Throwable $th) {
            return $this->errorRedirect($th->getMessage());
        }
    }
}
