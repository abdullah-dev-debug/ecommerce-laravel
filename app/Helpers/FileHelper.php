<?php

use App\Utils\AppUtils;
use App\Utils\ErrorUtils;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Image\Image;

function UploadFile(
    string $parentFolder,
    string $childFolder,
    string $fileKey,
    int $width,
    int $height
): ?string {

    if (!request()->hasFile($fileKey)) {
        return null;
    }

    $file = request()->file($fileKey);

    if (!$file->isValid()) {
        return null;
    }

    $directory = public_path(
        'assets/' . $parentFolder . ($childFolder ? '/' . $childFolder : '')
    );

    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true);
    }

    $filename = Str::uuid() . '.webp';
    $tempPath = $directory . '/temp_' . $filename;
    $finalPath = $directory . '/' . $filename;

    // Move uploaded file
    $file->move($directory, 'temp_' . $filename);

    // Spatie Image v3 syntax
    Image::load($tempPath)
        ->width($width)
        ->height($height)
        ->format('webp')
        ->quality(80)
        ->optimize()
        ->save($finalPath);

    File::delete($tempPath);

    return '/assets/' . trim(
        $parentFolder . ($childFolder ? '/' . $childFolder : ''),
        '/'
    ) . '/' . $filename;
}



function UploadFiles(
    string $parentFolder,
    ?string $childFolder,
    array $files = [],
    int $width = 1200,
    int $height = 1200
): array {
    $uploadedPaths = [];

    if (empty($files)) {
        return $uploadedPaths;
    }

    $directory = public_path("assets/$parentFolder" . ($childFolder ? "/$childFolder" : ''));

    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true);
    }

    foreach ($files as $file) {
        if ($file && $file->isValid()) {

            $filename = Str::uuid() . '.webp';
            $tempName = 'temp_' . $filename;

            // Move temp file
            $file->move($directory, $tempName);

            // Spatie Image v3 syntax
            Image::load("$directory/$tempName")
                ->width($width)
                ->height($height)
                ->format('webp')
                ->quality(80)
                ->optimize()
                ->save("$directory/$filename");

            // Delete temp file
            File::delete("$directory/$tempName");

            $uploadedPaths[] =
                "/assets/$parentFolder" .
                ($childFolder ? "/$childFolder" : '') .
                "/$filename";
        }
    }

    return $uploadedPaths;
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

function DeleteFile($filePath)
{
    try {
        $fullpath = public_path($filePath);
        if (File::exists($fullpath)) {
            return File::delete($fullpath);
        }
        if (!File::exists($fullpath)) {
            return AppUtils::webErrorRedirect('File Not Found!');
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
            return AppUtils::webErrorRedirect('File Not Found!');
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
