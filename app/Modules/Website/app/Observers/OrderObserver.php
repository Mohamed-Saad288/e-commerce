<?php

namespace App\Modules\Website\app\Observers;


use App\Models\User;
use App\Modules\Organization\app\Models\Coupon\CouponUsage;
use App\Modules\Organization\app\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $user = User::find($order->user_id);

            if (!$user) {
                return;
            }

            if ($user->cart) {
                $user->cart->items()->delete();
                $user->cart()->delete();
            }

            if ($order->coupon_id) {
                $exists = CouponUsage::where('user_id', $user->id)
                    ->where('coupon_id', $order->coupon_id)
                    ->exists();

                if (!$exists) {
                    CouponUsage::create([
                        'user_id' => $user->id,
                        'coupon_id' => $order->coupon_id,
                        'used_at' => Carbon::now(),
                        'organization_id' => $user->organization_id,
                    ]);
                }
            }
        });
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $user = User::find($order->user_id);
            if (!$user) {
                return;
            }

            if ($order->coupon_id) {
                CouponUsage::where('user_id', $user->id)
                    ->where('coupon_id', $order->coupon_id)
                    ->delete();
            }

            // لو عايز ترجع المنتجات للسلة، ممكن تضيفها هنا
            // مثال:
            // foreach ($order->items as $item) {
            //     CartItem::create([
            //         'cart_id' => $user->cart->id ?? Cart::create(['user_id' => $user->id])->id,
            //         'product_variation_id' => $item->product_variation_id,
            //         'quantity' => $item->quantity,
            //         'price' => $item->price,
            //     ]);
            // }
        });
    }


    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
