<?php

namespace App\Pipelines\Checkout;

use Closure;

class ApplyCoupon
{
    private const COUPONS = ['SAVE10' => 0.10, 'SAVE20' => 0.20];

    /**
     * Subtract coupon percentage from the subtotal.
     */
    public function handle(CheckoutData $data, Closure $next)
    {
        $rate = self::COUPONS[$data->coupon] ?? 0;
        $data->discount = round($data->subtotal * $rate, 2);

        $data->log('ApplyCoupon: -'.$data->discount);

        return $next($data);
    }
}
