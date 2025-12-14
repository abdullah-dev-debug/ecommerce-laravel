<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Http\Requests\ProductRequest;
use App\Models\Gallery;
use App\Models\Product;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
    public const VIEW_NAMESPACE = "products.";
    protected $gallery;
    public function __construct(AppUtils $appUtils, Gallery $gallery)
    {
        $this->gallery = $gallery;
        return parent::__construct($appUtils, new Product());
    }

    private function getcurrentRole(): string
    {
        return auth()->user()->role == 1 ? 'admin.' : auth()->user()->role == 2 ? 'vendor.' : 'customer.';
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
    private function returnDetailView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . "edit";
    }

    private function returnDetailRelations(): array
    {
        return [
            'category',
            'subCategory',
            'brand',
            'gallery',
            'vendor',
            'admin',
            'color',
            'size',
            'unit',
        ];
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

    public function create(): View
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnCreateView();
            return parent::successView($view);
        });
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $data = $request->validated();
            $data[self::THUMBNAIL_KEY] = $this->uploadThumbnail($request, self::THUMBNAIL_KEY);
            $result = $this->createResource($data);
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $this->uploadGallery($request, self::GALLERY_KEY, $result);
        }, self::MSG_CREATE_SUCCESS);
    }

    public function edit(int|string $product): View
    {
        return parent::executeWithTryCatch(function () use ($product): View {
            $view = $this->returnEditView();
            $relations = $this->returnMediaRelations();
            $data = $this->findOrRedirect($product, $relations);
            return parent::successView($view, [
                "product" => $data
            ]);
        });
    }

    public function update(int|string $product, ProductRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request, $product) {
            $data = $request->validated();
            $data[self::THUMBNAIL_KEY] = $this->uploadThumbnail($request, self::THUMBNAIL_KEY);
            $result = $this->updateResource($product, $data);
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $this->uploadGallery($request, self::GALLERY_KEY, $result);
        }, self::MSG_UPDATE_SUCCESS);
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

    public function detail(int|string $product): View
    {
        return parent::executeWithTryCatch(function () use ($product): View {
            $relations = $this->returnDetailRelations();
            $view = $this->returnDetailView();
            $data = $this->findOrRedirect($product, $relations);
            return parent::successView($view, [
                "product" => $data
            ]);
        });
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
}
