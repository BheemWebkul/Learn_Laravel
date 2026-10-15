<?php

namespace App\Pipelines\Checkout;

use Closure;

class CalculateSubtotal
{
    /**
     * Sum price x qty of all items.
     */
    public function handle(CheckoutData $data, Closure $next)
    {
        $data->subtotal = collect($data->items)
            ->sum(fn ($item) => $item['price'] * $item['qty']);

        $data->log('CalculateSubtotal: '.$data->subtotal);

        return $next($data);
    }
}
