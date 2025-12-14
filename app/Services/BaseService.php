<?php

namespace App\Services;

use App\Utils\AppUtils;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BaseService
{
    protected const STATUS_ACTIVE = 1;
    protected const STATUS_IN_ACTIVE = 0;
    protected Model $model;
    protected string $notFoundMessage;
    protected $utils;
    public function __construct(Model $model, string $notFoundMessage = 'Item not found', AppUtils $appUtils)
    {
        $this->model = $model;
        $this->notFoundMessage = $notFoundMessage;
        $this->utils = $appUtils;
    }

    private function ensureCachekey(?string $cacheKey = null)
    {
        if ($cacheKey) {
            Cache::forget($cacheKey);
        }
    }
    private function ensureCheckNull(
        $item,
        $key = 'error',
        $useApi = false,
        $statusCode = 404
    ): JsonResponse|RedirectResponse|null {
        if (empty($item)) {
            if ($useApi) {
                return response()->json([$key => $this->notFoundMessage], $statusCode);
            }
            return redirect()->back()->with([$key => $this->notFoundMessage]);
        }
        return null;
    }

    public function create(array $data, ?string $cacheKey = null): Model|null
    {
        $this->ensureCachekey($cacheKey);
        return $this->model->create($data);
    }
    public function update(array $data, int $id, string|null $cacheKey = null, array $filePaths = [])
    {
        $this->ensureCachekey($cacheKey);
        $currentItem = $this->model->find($id);

        $this->ensureCheckNull($currentItem);

        if ($filePaths) {
            DeleteFiles($filePaths);
        }

        $currentItem->update($data);
        return $currentItem->refresh();
    }

    public function destroy(int $id, string|null $cacheKey = null, string|null $filePath = null): bool
    {
        $this->ensureCachekey($cacheKey);
        $currentItem = $this->model->find($id);
        $this->ensureCheckNull($currentItem);
        if ($filePath) {
            DeleteFile($filePath);
        }
        return $currentItem->delete();
    }
    public function getAllActiveItem(
        array $relation = [],
        ?string $statusColumn = 'status',
        bool $usePagination = false,
        bool $useCache = false,
        $perPage = 10,
        ?string $cacheKey = null,
        $cacheTimer = 60
    ): Collection {
        $query = $this->model->with($relation)->where($statusColumn, self::STATUS_ACTIVE);
        if ($usePagination) {
            $result = $query->paginate($perPage);
        } else {
            $result = $query->get();
        }
        if ($useCache && $cacheKey) {
            return Cache::remember($cacheKey, now()->addMinutes($cacheTimer), function () use ($result) {
                return $result;
            });
        }
        return $result;
    }
    public function getPaginatedItem(
        $perPage = 10,
        array $relation = [],
        bool $searchFilter = false,
        ?string $search = null,
        ?array $searchFields = [],
        bool $useLatest = false
    ): LengthAwarePaginator {
        $query = $this->model->with($relation);
        if ($useLatest) {
            $query->latest();
        }
        if ($searchFilter && $search && $searchFields) {
            $query->where(function ($q) use ($search, $searchFields) {
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'LIKE', '%' . $search . '%');
                }
            });
        }
        return $query->paginate($perPage);
    }

    private function getQueryParameter($key): array|string|null
    {
        return request()->query($key);
    }
    public function getPaginatedCacheItem(
        $perPageKey,
        $cacheKey,
        $cacheTimer = 60,
        ?array $relation = [],
        array $searchableColumns = [],
        $defaultPages = 10,
        bool $useLatest = false
    ): LengthAwarePaginator {

        $perPage = $this->getQueryParameter($perPageKey) ?? $defaultPages;
        $page = request()->get('page', 1);
        $search = $this->getQueryParameter('search') ?? null;

        $cacheKey = $cacheKey . "_page_{$page}_perPage_{$perPage}_" . md5($search ?? '');

        $item = Cache::remember($cacheKey, now()->addMinutes($cacheTimer), function () use ($perPage, $relation, $search, $searchableColumns, $useLatest) {
            $query = $this->model->with($relation);
            if ($useLatest) {
                $query->latest();
            }
            if (!empty($search) && !empty($searchableColumns)) {
                $query->where(function ($q) use ($search, $searchableColumns) {
                    foreach ($searchableColumns as $column) {
                        $q->orWhere($column, 'LIKE', '%' . $search . '%');
                    }
                });
            }

            return $query->paginate($perPage);
        });

        return $item;
    }


    public function getSingleItem(int $id, array $relation = [], string $pageKey = "item"): Model
    {
        $currentItem = $this->model->with($relation)->find($id);
        if (!$currentItem) {
            throw new ModelNotFoundException($pageKey . " not found.");
        }
        return $currentItem;
    }
    public function getAllItem(?bool $useCache = false, array $relation = [], bool $useLatest, ?string $cacheKey = "", ?int $cacheTimer = 60): Collection
    {
        $query = $this->model->with($relation);

        if ($useLatest) {
            $query->latest();
        }

        if ($useCache && $cacheKey) {
            return Cache::remember($cacheKey, now()->addMinutes($cacheTimer), function () use ($query) {
                return $query->get();
            });
        }
        return $query->get();
    }
    public function toggleStatus(
        $id,
        ?string $hideMessage = "Item has been disabled successfully",
        ?string $showMessage = "Item has been enabled successfully",
        ?string $column = "status"
    ) {
        $item = $this->model->findOrFail($id, [$column]);
        $currentStatus = $item->$column;
        $logic = $currentStatus === self::STATUS_ACTIVE;
        $newStatus = $logic ? self::STATUS_IN_ACTIVE : self::STATUS_ACTIVE;
        $unit = $this->model->where('id', $id)->where($column, $currentStatus);
        $unit->update([
            $column => $newStatus
        ]);
        return [
            "message" => $newStatus === self::STATUS_ACTIVE ? $showMessage : $hideMessage,
            'is_active' => $newStatus
        ];
    }


}
