<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\ProductVariants;
use App\Models\VariantAttribute;
use App\Models\VariantAttributeValues;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public const MSG_ITEM_ADDED = 'Item added to cart successfully.';
    public const MSG_ITEM_REMOVED = 'Item removed from cart successfully.';

    protected $cartItem, $variants, $attributes, $variantAttributeValues;

    public function __construct(
        AppUtils $appUtils,
        CartItems $cartItems,
        ProductVariants $productVariants,
        VariantAttribute $variantAttribute,
        VariantAttributeValues $variantAttributeValues
    ) {
        parent::__construct($appUtils, new Cart());
        $this->cartItem = $cartItems;
        $this->variants = $productVariants;
        $this->attributes = $variantAttribute;
        $this->variantAttributeValues = $variantAttributeValues;
    }

    private function returnListView(): string
    {
        return 'cart.index';
    }

    public function store(Request $request): RedirectResponse
    {
        return parent::handleOperation(function () use ($request) {
            $cartData = $this->prepareCartData($request);
            $result = parent::createResource($cartData);
            $variantData = $this->prepareVariantData($request);
            $variant = $this->variants->create($variantData);
            $attributeData = $this->prepareVariantAttributes($request, $variant->id);
            $attribute = $this->attributes->create($attributeData);
            $attributeOptionData = $this->prepareVariantAttributeOptions($request, $attribute->id);
            $this->variantAttributeValues->create($attributeOptionData);
            $cartItemData = $this->prepareCartItemData($request, $result->id, $variant->id);
            $this->cartItem->create($cartItemData);
        }, self::MSG_ITEM_ADDED);
    }
    public function destroy(int|string $cart): RedirectResponse
    {
        return parent::handleOperation(function () use ($cart) {
            parent::deleteResource($cart);
            $getCartItems = $this->cartItem->where('cart_id', $cart)->get();

            foreach ($getCartItems as $item) {
                $attributes = $this->attributes->where('product_varint_id', $item->product_variant_id)->get();
                foreach ($attributes as $attribute) {
                    $this->variantAttributeValues->where('attribute_id', $attribute->id)->delete();
                    $attribute->delete();
                }
                $this->variants->where('id', $item->product_variant_id)->delete();
            }
            $this->cartItem->where('cart_id', $cart)->delete();
        }, self::MSG_ITEM_REMOVED);
    }

    private function prepareCartData(Request $request): array
    {
        return [
            'customer_id' => Auth::user()->id ?? null,
            'session_id' => session()->getId(),
            'sub_total' => $request->input('sub_total', 0),
            'discount_total' => $request->input('discount_total', 0),
        ];
    }
    private function prepareCartItemData(Request $request, int $cartId, int $variantId): array
    {
        return [
            'cart_id' => $cartId,
            'vendor_id' => Auth::guard('vendor')->check() ? Auth::guard('vendor')->id() : null,
            'product_variant_id' => $variantId,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity', 1),
            'unit_price' => $request->input('price', 0),
            'discount_amount' => $request->input('discount_amount', 0),
            'tax_amount' => $request->input('tax_amount', 0),
            'shipping_amount' => $request->input('shipping_amount', 0),
            'item_subtotal' => $request->input('item_subtotal', 0),
            'item_total' => $request->input('item_total', 0),
            'status' => $request->input('status', 0),
        ];
    }

    private function prepareVariantData(Request $request): array
    {
        return [
            'product_id' => $request->input('product_id'),
            'sku' => $request->input('sku'),
            'stock' => $request->input('stock'),
        ];
    }
    private function prepareVariantAttributes(Request $request, $variantId): array
    {
        return [
            "product_variant_id" => $variantId,
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ];
    }

    private function prepareVariantAttributeOptions(Request $request, $attributeId): array
    {
        return [
            "attribute_id" => $attributeId,
            'value' => $request->input('value'),
            'code' => $request->input('code'),
        ];
    }
}
