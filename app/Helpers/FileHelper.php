<?php

use App\Utils\AppUtils;
use App\Utils\ErrorUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
function UploadFile($request, string $fileKey, string $parentFolder, string $childFolder, $file)
{
    if ($request->hasFile($fileKey) && $request->file($fileKey)->isValid()) {
        $directory = public_path("assets/$parentFolder" . ($childFolder ? "/$childFolder" : ''));
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);
        return rtrim("/assets/$parentFolder" . ($childFolder ? "/$childFolder" : ''), '/') . "/$filename";
    }
}



function UploadVideo(
    $request,
    string $fileKey,
    string $parentFolder,
    string $childFolder,
    bool $useOriginalName = false,
    array $allowedExtensions = ['mp4', 'mov', 'avi'],
    int $maxSize = 51200
) {
    try {
        if (!$request->hasFile($fileKey)) {
            throw new \Exception("No file uploaded");
        }

        $file = $request->file($fileKey);
        if (!$file->isValid()) {
            throw new \Exception("Invalid file upload");
        }
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception("Invalid file type. Allowed: " . implode(', ', $allowedExtensions));
        }

        if ($file->getSize() > $maxSize * 1024) {
            throw new \Exception("File too large. Max size: " . ($maxSize / 1024) . "MB");
        }

        $directory = public_path("assets/$parentFolder" . ($childFolder ? "/$childFolder" : ''));
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $filename = $useOriginalName
            ? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension
            : Str::uuid() . '.' . $extension;
        $file->move($directory, $filename);

        return [
            'status' => true,
            'path' => "assets/$parentFolder" . ($childFolder ? "/$childFolder" : '') . "/$filename",
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
            'extension' => $extension,
            'full_path' => $directory . '/' . $filename
        ];
    } catch (\Throwable $th) {
        return ErrorUtils::handle($th, "Helper @UploadVideo");
    }
}

function UploadFiles(string $parentFolder, ?string $childFolder, array $files = []): array|JsonResponse
{
    $uploadedPaths = [];

    try {
        if (empty($files)) {
            return $uploadedPaths;
        }

        $directory = public_path("assets/$parentFolder" . ($childFolder ? "/$childFolder" : ''));

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        foreach ($files as $file) {
            if ($file && $file->isValid()) {
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move($directory, $filename);
                $uploadedPaths[] = "/assets/$parentFolder" . ($childFolder ? "/$childFolder" : '') . "/$filename";
            }
        }

        return $uploadedPaths;
    } catch (\Throwable $th) {
        return ErrorUtils::handle($th, "Helper @DeleteFile");
    }
}
function DeleteFile($filePath)
{
    try {
        $fullpath = public_path($filePath);
        if (File::exists($fullpath)) {
            return File::delete($fullpath);
        }
        if (!File::exists($fullpath)) {
            return AppUtils::notFoundResponse('error', 'File Not Found!', 404);
        }
        return AppUtils::apiResponse('error', 'Failed to delete the file', 500);
    } catch (\Throwable $th) {
        return ErrorUtils::handle($th, "Helper @DeleteFile");
    }
}

function DeleteFiles(array $files)
{
    try {
        $notFoundFiles = [];
        $deletedFiles = [];

        foreach ($files as $file) {
            $fullpath = public_path($file);

            if (File::exists($fullpath)) {
                if (File::delete($fullpath)) {
                    $deletedFiles[] = $file;
                }
            } else {
                $notFoundFiles[] = $file;
            }
        }

        if (!empty($deletedFiles) && empty($notFoundFiles)) {
            return AppUtils::apiResponse('success', 'Successfully deleted.', 200);
        }

        if (!empty($deletedFiles) && !empty($notFoundFiles)) {
            return AppUtils::apiResponse('partial', 'Some files were deleted. Some not found.', 206, [
                'deleted' => $deletedFiles,
                'not_found' => $notFoundFiles
            ]);
        }

        if (empty($deletedFiles)) {
            return AppUtils::notFoundResponse('error', 'Files not found.', 404);
        }
    } catch (\Throwable $th) {
        return ErrorUtils::handle($th, "Files deletion error");
    }
}

function DeleteFolder(string $FolderPath)
{
    try {
        $fullPath = public_path($FolderPath);
        if (FILE::exists($fullPath)) {
            File::deleteDirectory($fullPath);
            return $fullPath;
        }
    } catch (\Throwable $th) {
        return ErrorUtils::handle($th, "Helper @DeleteFolder");
    }
}
