<?php

namespace App\Pipelines\Checkout;

use Closure;
use RuntimeException;

class ValidateStock
{
    private const STOCK = ['laptop' => 5, 'mouse' => 50, 'keyboard' => 0];

    /**
     * Stop the pipeline by throwing when an item is out of stock.
     */
    public function handle(CheckoutData $data, Closure $next)
    {
        foreach ($data->items as $item) {
            if (($item['qty'] ?? 0) > (self::STOCK[$item['name']] ?? 0)) {
                throw new RuntimeException("Out of stock: {$item['name']}");
            }
        }

        $data->log('ValidateStock: ok');

        return $next($data);
    }
}
