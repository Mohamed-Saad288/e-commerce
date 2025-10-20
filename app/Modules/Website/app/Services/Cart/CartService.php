<?php

namespace App\Modules\Website\app\Services\Cart;

use App\Modules\Base\app\Response\DataFailed;
use App\Modules\Base\app\Response\DataSuccess;
use App\Modules\Organization\app\Models\Cart\Cart;
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

        $productVariation = ProductVariation::find($data['product_id']);
        if (! $productVariation) {
            return new DataFailed(status: false, message: 'Invalid product');
        }

        $data['organization_id'] = $organization->id;
        $data['user_id'] = $user->id;
        $data['product_variation_id'] = $data['product_id'];
        unset($data['product_id']);
        $existingCart = Cart::where([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'product_variation_id' => $data['product_variation_id'],
        ])->first();

        if ($existingCart) {
            $existingCart->quantity += $data['quantity'];
            $existingCart->price = $productVariation->selling_price * $existingCart->quantity;
            $existingCart->save();

            return new DataSuccess(
                data: new CartResource($existingCart),
                status: true,
                message: 'Cart updated successfully'
            );
        }

        $data['price'] = $productVariation->selling_price * $data['quantity'];

        $cart = Cart::create($data);

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Product added to cart successfully'
        );
    }

    public function update_cart($data)
    {
        $cart = Cart::find($data['cart_id']);
        if (! $cart) {
            return new DataFailed(status: false, message: 'Cart not found');
        }

        if (isset($data['product_id'])) {
            $productVariation = ProductVariation::find($data['product_id']);
            if (! $productVariation) {
                return new DataFailed(status: false, message: 'Invalid product');
            }

            $cart->product_variation_id = $data['product_id'];
            $cart->price = $productVariation->selling_price * ($data['quantity'] ?? $cart->quantity);
        }

        if (isset($data['quantity'])) {
            $cart->quantity = $data['quantity'];
            $productVariation = ProductVariation::find($cart->product_variation_id);
            $cart->price = $productVariation->selling_price * $cart->quantity;
        }

        $cart->save();

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Cart updated successfully'
        );
    }

    public function show_cart($data)
    {
        $cart = Cart::find($data['cart_id']);
        if (! $cart) {
            return new DataFailed(status: false, message: 'Cart not found');
        }

        return new DataSuccess(
            data: new CartResource($cart),
            status: true,
            message: 'Cart fetched successfully'
        );
    }

    public function delete_cart($data)
    {
        $cart = Cart::find($data['cart_id']);
        if (! $cart) {
            return new DataFailed(status: false, message: 'Cart not found');
        }

        $cart->delete();

        return new DataSuccess(
            status: true,
            message: 'Cart deleted successfully'
        );
    }

    public function get_my_cart()
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();

        $carts = Cart::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->with('productVariation')
            ->latest()
            ->get();

        $data = [
            'carts' => CartResource::collection($carts),
            'total_price' => $carts->sum('price'),
            'total_items' => $carts->sum('quantity'),
        ];

        return new DataSuccess(
            data: $data,
            status: true,
            message: 'Carts fetched successfully'
        );
    }

    public function clear_cart()
    {
        $user = auth('sanctum')->user();
        $organization = $this->getOrganization();

        Cart::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->delete();

        return new DataSuccess(
            status: true,
            message: 'Cart cleared successfully'
        );
    }
}
