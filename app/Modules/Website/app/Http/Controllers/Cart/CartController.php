<?php

namespace App\Modules\Website\app\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Modules\Website\app\Http\Request\Cart\CartRequest;
use App\Modules\Website\app\Http\Request\Cart\StoreCartRequest;
use App\Modules\Website\app\Http\Request\Cart\UpdateCartRequest;
use App\Modules\Website\app\Services\Cart\CartService;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService){}

    public function store_cart(StoreCartRequest $request)
    {
        return $this->cartService->store_cart($request->validated())->response();
    }
    public function update_cart(UpdateCartRequest $request)
    {
        return $this->cartService->update_cart($request->validated())->response();
    }
    public function delete_cart(CartRequest $request)
    {
        return $this->cartService->delete_cart($request->validated())->response();
    }
    public function show_cart(CartRequest $request)
    {
        return $this->cartService->show_cart($request->validated())->response();
    }
    public function clear_cart()
    {
        return $this->cartService->clear_cart()->response();
    }
    public function get_my_cart()
    {
        return $this->cartService->get_my_cart()->response();
    }
}
