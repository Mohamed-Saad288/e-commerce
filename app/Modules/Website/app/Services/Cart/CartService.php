<?php

namespace App\Modules\Website\app\Services\Cart;

use App\Modules\Base\app\Response\DataFailed;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Cart\Cart;
use App\Modules\Organization\app\Models\Cart\CartItem;
use App\Modules\Organization\app\Models\Coupon\Coupon;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use App\Modules\Website\app\Http\Resources\Cart\CartResource;
use App\Modules\Website\app\Traits\WebsiteLink\WebsiteLinkTrait;

class CartService
{
    use WebsiteLinkTrait;

    public function store_cart($data)
    {
        $organization = $this->getOrganization();
        $user = auth('sanctum')->user();

        $productVariation = ProductVariation::where('organization_id', $organization->id)
            ->where('id', $data['product_id'])
            ->first();

        if (! $productVariation) {
            return new DataFailed(status: false, message: 'Invalid product');
        }

        $coupon = null;
        if (! empty($data['coupon_code'])) {
            $coupon = Coupon::where('organization_id', $organization->id)
                ->where('code', $data['coupon_code'])
                ->first();

            if (! $coupon) {
                return new DataFailed(status: false, message: 'Invalid coupon');
            }
        }

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
        ], [
            'total' => 0,
            'coupon_id' => $coupon?->id,
        ]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variation_id', $data['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $data['quantity'] ?? 1;
            $cartItem->price = $productVariation->total_price * $cartItem->quantity;
            $cartItem->save();
        } else {
            $cartItem = $cart->items()->create([
                'product_variation_id' => $data['product_id'],
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'quantity' => $data['quantity'],
                'price' => $productVariation->total_price * $data['quantity'],
            ]);
        }

        $cart->total = $cart->items()->sum('price');
        $cart->save();

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Product added/updated in cart successfully'
        );
    }

    public function update_cart_item($data)
    {
        $user = auth('sanctum')->user();

        $cartItem = CartItem::where('id', $data['cart_item_id'])
            ->where('user_id', $user->id)
            ->first();

        if (! $cartItem) {
            return new DataFailed(status: false, message: 'Cart item not found');
        }

        if (! empty($data['quantity'])) {
            $cartItem->quantity = $data['quantity'];

            $productVariation = $cartItem->productVariation;
            $cartItem->price = $productVariation->total_price * $cartItem->quantity;
        }

        if (! empty($data['product_id'])) {
            $productVariation = ProductVariation::find($data['product_id']);

            if (! $productVariation) {
                return new DataFailed(status: false, message: 'Invalid product');
            }

            $cartItem->product_variation_id = $data['product_variation_id'];
            $cartItem->price = $productVariation->total_price * $cartItem->quantity;
        }
        $cartItem->save();
        $cart = $cartItem->cart;
        $cart->total = $cart->items()->sum('price');
        $cart->save();

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Cart updated successfully'
        );
    }

    public function delete_cart_item($data)
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();

        $cartItem = CartItem::where('id', $data['cart_item_id'])
            ->where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->first();

        if (! $cartItem) {
            return new DataFailed(status: false, message: 'Cart item not found');
        }

        $cart = $cartItem->cart;

        $cartItem->delete();

        $cart->total = $cart->items()->sum('price');

        if ($cart->items()->count() == 0) {
            $cart->delete();
        } else {
            $cart->save();
        }

        return new DataSuccess(
            status: true,
            message: 'Cart item deleted successfully'
        );
    }

    public function get_my_cart()
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();

        $cart = Cart::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->latest()
            ->first();

        if (empty($cart)) {
            return new DataSuccess(
                data: (object) null,
                status: true,
                message: 'No Items in your cart'
            );
        }

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Carts fetched successfully'
        );
    }

    public function clear_cart()
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();

        $cart = Cart::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->first();

        if (! $cart) {
            return new DataSuccess(
                data: (object) null,
                status: true,
                message: 'No cart to clear'
            );
        }

        $cart->items()->delete();

        $cart->delete();

        return new DataSuccess(
            status: true,
            message: 'Cart cleared successfully'
        );
    }

    public function apply_coupon_code($data)
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();
        $cart = Cart::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->first();
        if (! $cart) {
            return new DataFailed(status: false, message: 'No cart found');
        }
        $coupon = Coupon::where('organization_id', $organization->id)
            ->where('code', $data['coupon_code'])
            ->first();
        if (! $coupon) {
            return new DataFailed(status: false, message: 'Invalid coupon');
        }
        if (! validateCouponForUser(coupon: $coupon, userId: $user->id)) {
            return new DataFailed(status: false, message: 'Coupon is not valid for you');
        }
        $cart->coupon_id = $coupon->id;
        $cart->save();

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Coupon applied successfully'
        );
    }
}
