<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAddressRequest;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\User;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CustomerAddressController extends Controller
{
    public const PAGE_KEY = 'Customer Address';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    public const MSG_UPDATE_SUCCESS = self::PAGE_KEY . Messages::MSG_UPDATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = self::PAGE_KEY . Messages::MSG_DELETE_SUCCESS;
    public const VIEW_NAMESPACE = "users.address.";
    public const ACTIVE_STATUS = 1;
    protected $customerModel, $countryModel;
    public function __construct(AppUtils $appUtils, CustomerAddress $customerAddress, Country $country, User $customer)
    {
        parent::__construct($appUtils, $customerAddress);
        $this->countryModel = $country;
        $this->customerModel = $customer;
    }

    public function index()
    {
        return parent::executeWithTryCatch(function () {

            $addresses = $this->model
                ->with(['customer', 'country'])
                ->get();

            return $this->successView(
                $this->returnListView(),
                ['addresses' => $addresses]
            );
        });
    }



    public function create()
    {
        return parent::executeWithTryCatch(function () {
            $addresses = null;
            $comanData = $this->getCommonData();
            return $this->successView($this->returnCreateView(), ["address" => $addresses, "comanData" => $comanData]);
        });
    }
    public function store(CustomerAddressRequest $request): RedirectResponse|View
    {
        return parent::handleOperation(function () use ($request) {
            $validatedData = $this->prepareData($request);
            $this->createResource($validatedData);
        }, self::MSG_CREATE_SUCCESS, false, $this->returnListRoute());
    }
    public function edit(int|string $address)
    {
        return parent::executeWithTryCatch(function () use ($address) {
            $comanData = $this->getCommonData();
            $addresses = $this->findOrRedirect($address);
            return $this->successView($this->returnEditView(), ["address" => $addresses, "comanData" => $comanData]);
        });
    }

    public function update(int|string $address, CustomerAddressRequest $request): RedirectResponse|View
    {
        return parent::handleOperation(function () use ($request, $address) {
            $validatedData = $this->prepareData($request);
            $this->updateResource($address, $validatedData);
        }, self::MSG_UPDATE_SUCCESS, false, $this->returnListRoute());
    }

    public function destroy(int|string $address): RedirectResponse|View
    {
        return parent::handleOperation(function () use ($address) {
            $this->deleteResource($address);
        }, self::MSG_DELETE_SUCCESS);
    }

    private function getCommonData()
    {
        return [
            "countries" => $this->countryModel->where('status', self::ACTIVE_STATUS)->get(),
            "customers" => $this->customerModel->where('status', self::ACTIVE_STATUS)->get(),
        ];
    }

    private function prepareData(CustomerAddressRequest $request)
    {
        $validatedData = $request->validated();
        $customer = $validatedData['customer_id'];
        if (empty($customer)) {
            $customer = Auth::guard('web')->user()->id ?? null;
        }
        $validatedData['customer_id'] = $customer;
        return $validatedData;
    }

    private function returnListRoute()
    {
        return 'admin.user.address.list';
    }
    private function returnListView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . 'index';
    }
    private function returnCreateView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . 'create';
    }
    private function returnEditView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . 'create';
    }
}
