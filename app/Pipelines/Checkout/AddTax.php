<?php

namespace App\Pipelines\Checkout;

use Closure;

class AddTax
{
    /**
     * Add 18% tax and compute the final total.
     */
    public function handle(CheckoutData $data, Closure $next)
    {
        $data->tax = round(($data->subtotal - $data->discount) * 0.18, 2);
        $data->total = round($data->subtotal - $data->discount + $data->tax, 2);

        $data->log('AddTax: +'.$data->tax);

        return $next($data);
    }
}
