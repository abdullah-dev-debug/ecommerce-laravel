<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminVendorController extends Controller
{
    public const PAGE_KEY = "vendor";
    public const MSG_REG = self::PAGE_KEY . Messages::MSG_REG_SUCCESS;
    public const MSG_DELETE = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const MSG_UPDATE = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const CURRENT_ROLE = 2;
    public const VIEW_NAMESPACE = "admin.vendors.";
    public const VENDOR_LIST_ROUTE = "admin.vendor.list";
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Vendor());
    }

    public function pending()
    {
        return parent::executeWithTryCatch(function () {
            $vendors = $this->getAllResources(['status' => 'pending']);
            return $this->successView($this->returnPendingListView(), [
                'vendors' => $vendors
            ]);
        });
    }
    public function show($vendor)
    {
        return parent::executeWithTryCatch(function () use ($vendor) {
            $details = $this->findOrRedirect($vendor);
            // return $this->successView()
        });
    }

    public function index(): mixed
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $filter = $this->returnVendorFilter();
            $list = parent::getAllResources($filter);
            return $this->successView($view, ["vendors" => $list]);
        });
    }

    public function create(): View
    {
        $view = $this->returnCreateView();
        return $this->successView($view);
    }

    public function store(VendorRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request, 1, true);
        }, true, self::MSG_REG, self::VENDOR_LIST_ROUTE);
    }

    public function edit(int|string $vendor): View
    {
        $view = $this->returnEditView();
        $data = parent::findOrRedirect($vendor);
        return $this->successView($view, ["vendor" => $data]);
    }

    public function update(int|string $vendor, VendorRequest $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($vendor, $request) {
            $validatedData = $request->validated();
            parent::updateResource($vendor, $validatedData);
        }, true, self::MSG_REG, self::VENDOR_LIST_ROUTE);
    }
    public function destroy(int|string $vendor): RedirectResponse
    {
        return parent::handleOperation(function () use ($vendor) {
            parent::deleteResource($vendor);
        }, true,self::MSG_DELETE,self::VENDOR_LIST_ROUTE);
    }

    private function prepareData($request, $status = 1, $isVerify = false): array
    {
        $validatedData = $request->validated();
        $validatedData['status'] = $status;
        $validatedData['ip'] = $request->ip();
        $data = [
            ...$validatedData,
            'role_id' => self::CURRENT_ROLE,
        ];

        if ($isVerify) {
            $data['email_verified_at'] = now();
        }

        return $data;
    }

    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . "index";
    }

    private function returnPendingListView(): string
    {
        return self::VIEW_NAMESPACE . "pending-approvals";
    }
    private function returnCreateView(): string
    {
        return self::VIEW_NAMESPACE . "create";
    }
    private function returnEditView(): string
    {
        return self::VIEW_NAMESPACE . "edit";
    }

    private function returnVendorFilter(): array
    {
        return [
            "role_id" => self::CURRENT_ROLE
        ];
    }
}
