<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CurrencyController extends Controller
{
    public const PAGE_KEY = 'Currency';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_LIST_SUCCESS = self::PAGE_KEY . Messages::MSG_LIST_SUCCESS;
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;
    public const VIEW_NAMESPACE = "admin.settings.currency.";
    public function __construct(AppUtils $appUtils)
    {
        return parent::__construct($appUtils, new Currency());
    }

    public function store(CurrencyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($data) {
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }
    public function update(int|string $currency, CurrencyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return parent::handleOperation(function () use ($currency, $data) {
            $this->updateResource($currency, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int|string $currency): RedirectResponse
    {
        return parent::handleOperation(function () use ($currency) {
            $this->deleteResource($currency);
        }, self::MSG_DELETE_SUCCESS);
    }
    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $data = parent::getAllResources();
            return $this->successView($view, ["currencies" => $data]);
        });
    }

    public function edit(int|string $currency)
    {
        return parent::executeWithTryCatch(function () use ($currency): JsonResponse {
            $data = $this->findOrRedirect($currency);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ["currency" => $data]);
        });
    }

    public function toggleStatus(int|string $currency)
    {
        return parent::executeWithTryCatch(function () use ($currency): RedirectResponse {
            $currentStatus = $this->toggleResourceStatus($currency, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return $this->successRedirect($currentStatus['message']);
        });
    }

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . '.index';
    }
}
