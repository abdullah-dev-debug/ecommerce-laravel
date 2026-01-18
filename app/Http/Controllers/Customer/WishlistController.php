<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public const MSG_WISHLIST_ADDED = 'Item added to wishlist successfully.';
    public const MSG_WISHLIST_REMOVED = 'Item removed from wishlist successfully.';
    public const VIEW_NAMESPACE = 'wishlist.';
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new WishList());
    }
    private function returnIndexView(): string
    {
        return self::VIEW_NAMESPACE . 'index';
    }

    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnIndexView();
            $whishlists = parent::getAllResources([
                "customer_id" => auth()->user()->id,
            ], [
                'customer',
                'product'
            ]);
            return $this->successView($view, [
                'wishlists' => $whishlists,
            ]);
        });
    }

    public function store(Request $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $data = $this->prepareData($request);
            $wishlist = $this->model->where('product_id', $data['product_id'])
                ->where('customer_id', $data['customer_id'])
                ->first();
            if ($wishlist) {
                throw new \Exception('Item is already in wishlist.');
            }
            parent::createResource($data);
        }, self::MSG_WISHLIST_ADDED);
    }

    public function destroy(int $whishlist): RedirectResponse
    {
        return parent::handleOperation(function () use ($whishlist) {
            parent::deleteResource($whishlist);
        }, self::MSG_WISHLIST_REMOVED);
    }

    private function prepareData(Request $request): array
    {
        return [
            'customer_id' => auth()->check() ? auth()->user()->id : $request->input('customer_id'),
            'product_id' => $request->input('product_id'),
        ];
    }
}
