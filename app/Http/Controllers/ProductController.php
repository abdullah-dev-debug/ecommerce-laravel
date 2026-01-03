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
use Str;

class ProductController extends Controller
{
    public const PAGE_KEY = 'Product';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const PARENT_FOLDER = "product";
    public const THUMBNAIL_FOLDER = "thumbnails";
    public const GALLERY_FOLDER = "gallery";
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

    private function returnListView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . "list";
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

    private function returnInfoRelations(): array
    {
        return [
            'vendor',
            'admin',
        ];
    }

    private function returnMediaRelations(): array
    {
        return [
            'gallery',
        ];
    }
    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $infoRelations = $this->returnInfoRelations();
            $products = parent::getAllResources([], $infoRelations);
            return parent::successView($view, [
                'products' => $products
            ]);
        });
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
        return parent::handleOperation(function () use ($request) {
            $validatedData = $request->validated();
            $validatedData['slug'] = $this->generateSlug($validatedData['title']);
            $data = $this->setCurrentUserId($validatedData);
            $product = parent::createResource($data);
            if ($request->hasFile(self::THUMBNAIL_KEY)) {
                $product->update([
                    self::THUMBNAIL_KEY => $this->uploadThumbnail($request, self::THUMBNAIL_KEY)
                ]);
            }
            $this->uploadGallery($request, self::GALLERY_KEY, $product);
            $this->insertVariants($request, $product);
        }, self::MSG_CREATE_SUCCESS, false, $this->returnListRoute());

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
        $response = parent::handleOperation(function () use ($request, $product, &$result) {
            $validatedData = $request->validated();
            $validatedData['slug'] = $this->generateSlug($validatedData['title']);
            $result = parent::updateResource($product, $validatedData);
        }, self::MSG_UPDATE_SUCCESS);
        if ($request->hasFile(self::THUMBNAIL_KEY)) {
            $product->update([
                self::THUMBNAIL_KEY => $this->uploadThumbnail($request, self::THUMBNAIL_KEY)
            ]);
        }
        $this->uploadGallery($request, self::GALLERY_KEY, $product);
        return $response;
    }

    public function destroy(int|string $product): RedirectResponse
    {
        return parent::handleOperation(function () use ($product) {
            $data = $this->findOrRedirect($product);
            if ($data->thumbnail) {
                DeleteFile($data->thumbnail);
            }
            $galleryImages = $this->gallery->where('product_id', $data->id)->get();
            foreach ($galleryImages as $image) {
                DeleteFile($image->path);
            }
            $this->deleteResource($product);
        }, self::MSG_DELETE_SUCCESS);
    }


    public function bulkDelete(ProductRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $ids = json_decode($request->input('selected_ids'), true);
            foreach ($ids as $id) {
                $product = $this->findOrRedirect($id);
                if ($product->thumbnail) {
                    DeleteFile($product->thumbnail);
                }
                $galleryImages = $this->gallery->where('product_id', $product->id)->get();
                foreach ($galleryImages as $image) {
                    if ($image->path) {
                        DeleteFolder(self::PARENT_FOLDER . "/gallery/{$product->sku}");
                    }
                }
            }
            $this->bulkDeleteResources($ids);
        }, self::MSG_DELETE_SUCCESS);

    }
    public function toggleStatus(int|string $product): RedirectResponse
    {
        return parent::executeWithTryCatch(function () use ($product): RedirectResponse {
            $status = $this->toggleResourceStatus($product, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return parent::successRedirect($status['message']);
        });
    }

    private function uploadThumbnail(ProductRequest $request, $fileKey): ?string
    {
        $file = $request->file($fileKey);
        if ($request->hasFile($fileKey) && $file->isValid()) {
            $path = UploadFile(self::PARENT_FOLDER, self::THUMBNAIL_FOLDER, $fileKey, 600, 600);
            if (!$path) {
                throw new \Exception("Thumbnail upload failed.");
            }
            return $path;
        }
        return null;
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

    private function uploadGallery(ProductRequest $request, $fileKey, $result): void
    {
        if ($request->hasFile($fileKey)) {
            $galleryFiles = $request->file($fileKey);
            if (!is_array($galleryFiles)) {
                $galleryFiles = [$galleryFiles];
            }
            $dbPaths = UploadFiles(
                self::PARENT_FOLDER,
                self::GALLERY_FOLDER . "/{$result->sku}",
                $galleryFiles,
                1200,
                1200
            );
            if (!$dbPaths || count($dbPaths) !== count($galleryFiles)) {
                throw new \Exception("Gallery upload failed.");
            }
            foreach ($dbPaths as $path) {
                $this->gallery->create([
                    "product_id" => $result->id,
                    "path" => $path
                ]);
            }
        }
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