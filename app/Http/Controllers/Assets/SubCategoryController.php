<?php

namespace App\Http\Controllers\Assets;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandAssetsRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class SubCategoryController extends Controller
{
    public const PAGE_KEY = 'Subcategory';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const PARENT_FOLDER = "sub-category";
    public const CHILD_FOLDER = "icon";
    public const FILE_KEY = "icon";
    public const VIEW_NAMESPACE = "admin.sub-category.";
    protected $categoryModel;
    public function __construct(AppUtils $appUtils, Category $categoryModel)
    {
        parent::__construct($appUtils, new SubCategory());
        $this->categoryModel = $categoryModel;
    }


    public function create(): View
    {
        $data = $this->returnCategoryList();
        $view = $this->returnCreateView();
        return $this->successView($view, ['categories' => $data]);
    }

    public function store(BrandAssetsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data, $request) {
            $data[self::FILE_KEY] = $this->uploadIcon($request, self::FILE_KEY);
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $subcategory, BrandAssetsRequest $request): RedirectResponse|View
    {
        $data = $request->validated();
        if ($request->hasFile(self::FILE_KEY)) {
            $data[self::FILE_KEY] = $this->uploadIcon($request, self::FILE_KEY);
        }
        return parent::handleOperation(function () use ($subcategory, $data, ) {
            $this->updateResource($subcategory, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $subcategory): RedirectResponse
    {
        return parent::handleOperation(function () use ($subcategory) {
            $data = parent::findOrRedirect($subcategory);
            if ($data->icon && !empty($data->icon)) {
                DeleteFile($data->icon);
            }
            $this->deleteResource($subcategory);
        }, self::MSG_DELETE_SUCCESS);
    }
    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $data = parent::getAllResources([], ['category']);
            return $this->successView($view, ["subCategories" => $data]);
        });
    }

    public function edit(int|string $subcategory)
    {
        return parent::executeWithTryCatch(function () use ($subcategory): View {
            $categories = $this->returnCategoryList();
            $data = $this->findOrRedirect($subcategory);
            $view = $this->returnEditView();
            return $this->successView($view, [
                "subCategory" => $data,
                'categories' => $categories
            ]);
        });
    }

    public function toggleStatus(int|string $subcategory)
    {
        return parent::executeWithTryCatch(function () use ($subcategory): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($subcategory, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

    public function getByCategory(int|string $categoryId)
    {

        return parent::executeWithTryCatch(function () use ($categoryId) {
            $subCategories = $this->model->where([
                'category_id' => $categoryId,
                'status' => 1
            ])->get();
            return $this->apiSuccessResponse('sub-categories fetched successfully', ["subCategories" => $subCategories]);
        });
    }

    private function returnCategoryList(): Collection
    {
        $categories = $this->categoryModel->where(['status' => 1])->get();
        return $categories;
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
    private function uploadIcon($request, string $fileKey): ?string
    {
        if (!$request->hasFile($fileKey)) {
            return null;
        }

        return UploadFile(
            self::PARENT_FOLDER,
            self::CHILD_FOLDER,
            $fileKey,
            214,
            214
        );
    }
}
