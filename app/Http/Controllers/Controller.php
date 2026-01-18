<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Utils\AppUtils;
use App\Utils\ErrorUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Controller
{

    /*  
     * Log Constant Messages is given 
     */
    public const STATUS_ACTIVE = 1;
    public const STATUS_IN_ACTIVE = 0;
    public const MSG_NOT_FOUND = Messages::MSG_PAGE_NOT_FOUND;
    public const LOG_MSG_CREATE = Messages::LOG_MSG_STORE;
    public const LOG_MSG_UPDATE = Messages::LOG_MSG_UPDATE;
    public const LOG_MSG_EDIT = Messages::LOG_MSG_EDIT;
    public const LOG_MSG_DELETE = Messages::LOG_MSG_DELETE;
    public const LOG_MSG_BULK_DELETE = Messages::LOG_MSG_DELETE;
    public const LOG_MSG_INDEX = Messages::LOG_MSG_INDEX;
    public const LOG_MSG_IS_ACTIVE = Messages::LOG_MSG_IS_ACTIVE;

    protected ErrorUtils $errorUtils;
    protected AppUtils $appUtils;
    protected Model $model;
    public function __construct(AppUtils $appUtils, Model $model)
    {
        $this->appUtils = $appUtils;
        $this->model = $model;
    }

    public function createResource(array $data): RedirectResponse|Model
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->model->create($data);
            });
        } catch (\Exception $e) {
            return $this->throwError($e, self::LOG_MSG_CREATE);
        }
    }
    public function findOrRedirect($id, array $with = []): RedirectResponse|Model
    {
        try {
            $query = $this->model->query();
            if (!empty($with)) {
                $query->with($with);
            }
            $data = $query->findOrFail($id);
            return $data;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->throwError($e, self::LOG_MSG_INDEX);
        }
    }


    public function updateResource(int|string $id, array $data): Model|RedirectResponse
    {
        try {

            $result = $this->findOrRedirect($id);
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            return DB::transaction(function () use ($result, $data) {
                $result->update($data);
                return $result;
            });
        } catch (\Exception $e) {
            return $this->throwError($e, self::LOG_MSG_UPDATE);
        }
    }
    public function toggleResourceStatus(
        $id,
        ?string $hideMessage = "Item has been disabled successfully",
        ?string $showMessage = "Item has been enabled successfully",
        ?string $column = "status"
    ): array|RedirectResponse {
        try {
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
        } catch (\Exception $e) {
            return $this->throwError($e, self::LOG_MSG_IS_ACTIVE);
        }
    }


    /**
     * Get paginated resources with optional filters
     */
    public function getPaginatedResources(
        array $with = [],
        $useLatest = false,
        ?int $perPage = null,
        array $filters = []
    ): LengthAwarePaginator|RedirectResponse {
        try {
            $perPage = $perPage ?? config('pagination.default_per_page');
            $query = $this->model->query();

            if (!empty($with)) {
                $query->with($with);
            }

            if (!empty($filters)) {
                foreach ($filters as $field => $value) {
                    if (!empty($value)) {
                        if (is_array($value)) {
                            $query->whereIn($field, $value);
                        } else {
                            $query->where($field, $value);
                        }
                    }
                }
            }

            if ($useLatest) {
                $query->latest();
            }

            return $query->paginate($perPage);
        } catch (QueryException $e) {
            return $this->throwError($e, self::LOG_MSG_INDEX);
        }
    }


    public function deleteResource($id): bool|RedirectResponse|null
    {
        try {
            $result = $this->findOrRedirect($id);
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            return DB::transaction(function () use ($result) {
                return $result->delete();
            });
        } catch (\Exception $e) {
            return $this->throwError($e, self::LOG_MSG_DELETE);
        }
    }

    public function bulkDeleteResources(array $items = [], ?string $field = "id")
    {
        try {
            if (empty($items)) {
                return $this->errorRedirect("No Items selected for deletion.");
            }
            return DB::transaction(function () use ($items, $field) {
                return $this->model->whereIn($field, $items)->delete();
            });
        } catch (\Exception $e) {
            return $this->throwError($e, self::LOG_MSG_BULK_DELETE);
        }
    }


    public function getAllResources(array $filters = [], array $with = []): Collection|RedirectResponse
    {
        try {
            $query = $this->model->query();

            if ($filters) {
                foreach ($filters as $fields => $value) {
                    $query->where($fields, $value);
                }
            }
            if (!empty($with)) {
                $query->with($with);
            }

            return $query->get();
        } catch (QueryException $e) {
            return $this->throwError($e, "@getAllResources Controller");
        }
    }

    public function successRedirect(string $message): RedirectResponse
    {
        return $this->appUtils->webSuccessRedirect($message);
    }

    public function errorRedirect(string $message): RedirectResponse
    {
        return $this->appUtils->webErrorRedirect($message);
    }

    public function successView(string $view, array $data = [], string $message = ''): View
    {
        return $this->appUtils->webSuccessView($view, $data, $message);
    }

    public function errorView(string $view, array $data = [], string $message = ''): View
    {
        return $this->appUtils->webErrorView($view, $data, $message);
    }
    public function handleError($th, string $message = "Something went wrong!"): array
    {
        $this->errorUtils = app(ErrorUtils::class);
        return $this->errorUtils->handle($th, $message);
    }
    public function apiSuccessResponse(string $message, array $data = []): JsonResponse
    {
        return $this->appUtils->apiSuccess($message, $data);
    }

    public function handleOperation(
        callable $operation,
        bool $redirect = true,
        ?string $successMessage = '',
        ?string $route = 'index'
    ): mixed {
        DB::beginTransaction();

        try {
            $result = $operation();
            DB::commit();

            if ($redirect) {
                return redirect()
                    ->route($route)
                    ->with('success', $successMessage);
            }

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    public function executeWithTryCatch(callable $operation, string $errorMessage = "Something went wrong!"): mixed
    {
        try {
            return $operation();
        } catch (\Throwable $th) {
            return $this->throwError($th, $errorMessage);
        }
    }
    public function throwError($th, string $message = "Something went wrong!"): RedirectResponse
    {
        $error = $this->handleError($th, $message);
        return $this->errorRedirect($error['error']);
    }

    public function getcurrentRole(): string
    {
        $role = "customer.";
        if (Auth::guard('admin')->check()) {
            $role = "admin.";
        }

        if (Auth::guard('vendor')->check()) {
            $role = "vendor.";
        }
        return $role;
    }
}
