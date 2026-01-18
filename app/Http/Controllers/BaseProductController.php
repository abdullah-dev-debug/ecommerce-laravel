<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\Sizes;
use App\Models\SubCategory;
use App\Models\Unit;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Http\Controllers\Traits\ProductImagesTrait;

class BaseProductController extends Controller
{
    use ProductImagesTrait;
    public const PAGE_KEY = 'Product';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const THUMBNAIL_KEY = "thumbnail";
    public const GALLERY_KEY = "gallery_photos";
    public const VIEW_NAMESPACE = "product.";
    protected $gallery, $variantModel, $colors, $sizes, $units, $brands, $categories, $subCategories;
    public function __construct(
        AppUtils $appUtils,
        Gallery $gallery,
        ProductVariants $productVariants,
        Color $colors,
        Sizes $sizes,
        Category $categories,
        SubCategory $subCategories,
        Brand $brands,
        Unit $units
    ) {
        $this->gallery = $gallery;
        parent::__construct($appUtils, new Product());
        $this->variantModel = $productVariants;
        $this->colors = $colors;
        $this->sizes = $sizes;
        $this->categories = $categories;
        $this->subCategories = $subCategories;
        $this->brands = $brands;
        $this->units = $units;
    }

    public function create()
    {
        return parent::executeWithTryCatch(function () {
            $view = $this->returnCreateView();
            $data = $this->getCommonData();
            return $this->successView($view, ["data" => $data, 'product' => null]);
        });
    }

    public function store(ProductRequest $request)
    {
        $response = null;
        parent::handleOperation(function () use ($request, &$response) {
            $validatedData = $request->validated();
            $validatedData['slug'] = $this->generateSlug($validatedData['title']);
            $data = $this->setCurrentUserId($validatedData);
            $response = parent::createResource($data);
            $this->insertVariants($request, $response);
        }, false);

        if ($request->hasFile(self::THUMBNAIL_KEY)) {
            $response?->update([
                self::THUMBNAIL_KEY => $this->uploadThumbnail($request, self::THUMBNAIL_KEY)
            ]);
        }
        $this->uploadGallery($request, self::GALLERY_KEY, $response);
        return $this->successView($this->returnListRoute(), [
            "response" => $response
        ], self::MSG_CREATE_SUCCESS);
    }

    public function edit(int|string $product)
    {
        return parent::executeWithTryCatch(function () use ($product) {
            $view = $this->returnEditView();
            $commonData = $this->getCommonData();
            $productData = $this->findOrRedirect($product, $this->returnMediaRelations());
            return $this->successView($view, [
                'product' => $productData,
                'data' => $commonData
            ]);
        });
    }

    public function update($product, ProductRequest $request)
    {
        $result = null;
        parent::handleOperation(function () use ($request, $product, &$result) {
            $validatedData = $request->validated();
            $validatedData['slug'] = $this->generateSlug($validatedData['title']);
            $result = parent::updateResource($product, $validatedData);
        }, false);

        if ($request->hasFile(self::THUMBNAIL_KEY)) {
            $result?->update([
                self::THUMBNAIL_KEY => $this->uploadThumbnail($request, self::THUMBNAIL_KEY)
            ]);
        }
        $this->uploadGallery($request, self::GALLERY_KEY, $product);
        return  $this->successView($this->returnListRoute(), [
            "response" => $result
        ], self::MSG_CREATE_SUCCESS);;
    }

    public function destroy(int|string $product): RedirectResponse
    {
        return parent::handleOperation(function () use ($product) {
            $data = $this->findOrRedirect($product);
            $galleryImages = $this->gallery->where('product_id', $data->id)->get();
            $this->deleteImage($data);
            $this->deleteImages($galleryImages, $data);
            $this->deleteResource($product);
        }, true, self::MSG_DELETE_SUCCESS, $this->returnListRoute());
    }

    public function bulkDelete(ProductRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $ids = json_decode($request->input('selected_ids'), true);

            foreach ($ids as $id) {
                $product = $this->findOrRedirect($id);
                $this->deleteImage($product);
                $galleryImages = $this->gallery
                    ->where('product_id', $product->id)
                    ->get();

                $this->deleteImages($galleryImages, $product);
            }
            $this->bulkDeleteResources($ids);
        }, true, self::MSG_DELETE_SUCCESS, $this->returnListRoute());
    }

    private function returnCreateView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . "create";
    }
    private function returnEditView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . "edit";
    }

    private function returnListRoute()
    {
        $role = $this->getcurrentRole();
        return $role . "products.list";
    }
    
    private function returnMediaRelations(): array
    {
        return [
            'gallery',
        ];
    }
    private function getCommonData()
    {
        return [
            'colors' => $this->colors->where(['status' => 1])->get(),
            'sizes' => $this->sizes->where(['status' => 1])->get(),
            'categories' => $this->categories->where(['status' => 1])->get(),
            'subCategories' => $this->subCategories->where(['status' => 1])->get(),
            'brands' => $this->brands->where(['status' => 1])->get(),
            'units' => $this->units->where(['status' => 1])->get(),
        ];
    }

    private function generateSlug($title): string
    {
        $slug = Str::slug($title);
        return $slug;
    }
    private function setCurrentUserId(array $data): array
    {
        if (auth()->guard('admin')->check()) {
            $data['admin_id'] = auth()->guard('admin')->id();
        }

        if (auth()->guard('vendor')->check()) {
            $data['vendor_id'] = auth()->guard('vendor')->id();
        }

        return $data;
    }

    private function insertVariants(ProductRequest $request, $product): void
    {
        $data = $request->validated();

        $colorIds = $data['colors'] ?? [null];
        $sizeIds = $data['sizes'] ?? [null];

        $variants = [];

        foreach ($colorIds as $colorId) {
            foreach ($sizeIds as $sizeId) {
                $variants[] = [
                    'product_id' => $product->id,
                    'color_id' => $colorId,
                    'size_id' => $sizeId,
                    'sku' => $product->sku
                        . ($colorId ? "-C{$colorId}" : '')
                        . ($sizeId ? "-S{$sizeId}" : ''),
                    'price' => $data['price'],
                    'stock' => $data['quantity'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $this->variantModel->insert($variants);
    }
}
