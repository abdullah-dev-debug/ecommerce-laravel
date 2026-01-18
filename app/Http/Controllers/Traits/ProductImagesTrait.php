<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\ProductRequest;

trait ProductImagesTrait
{
    public const PARENT_FOLDER = "product";
    public const THUMBNAIL_FOLDER = "thumbnails";
    public const GALLERY_FOLDER = "gallery";

    private function uploadThumbnail(ProductRequest $request, $fileKey): ?string
    {
        $file = $request->file($fileKey);

        if ($request->hasFile($fileKey) && $file->isValid()) {
            $path = UploadFile(
                self::PARENT_FOLDER,
                self::THUMBNAIL_FOLDER,
                $fileKey,
                600,
                600
            );

            if (!$path) {
                throw new \Exception("Thumbnail upload failed.");
            }

            return $path;
        }

        return null;
    }

    private function uploadGallery(ProductRequest $request, $fileKey, $product): void
    {
        if (!$request->hasFile($fileKey)) {
            return;
        }

        $galleryFiles = $request->file($fileKey);
        $galleryFiles = is_array($galleryFiles) ? $galleryFiles : [$galleryFiles];

        $dbPaths = UploadFiles(
            self::PARENT_FOLDER,
            self::GALLERY_FOLDER . "/{$product->sku}",
            $galleryFiles,
            1200,
            1200
        );

        if (!$dbPaths || count($dbPaths) !== count($galleryFiles)) {
            throw new \Exception("Gallery upload failed.");
        }

        foreach ($dbPaths as $path) {
            $this->gallery->create([
                'product_id' => $product->id,
                'path'       => $path,
            ]);
        }
    }

    private function deleteImages($images, $product)
    {
        if ($images->count()) {
            DeleteFolder(self::PARENT_FOLDER . "/gallery/{$product->sku}");
        }
        return null;
    }

    private function deleteImage($product)
    {
        if ($product->thumbnail) {
            DeleteFile($product->thumbnail);
        }
        return null;
    }
}
