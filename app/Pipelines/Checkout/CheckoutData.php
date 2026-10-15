<?php

namespace App\Pipelines\Checkout;

class CheckoutData
{
    public array $steps = [];

    public function __construct(
        public array $items,
        public ?string $coupon = null,
        public float $subtotal = 0,
        public float $discount = 0,
        public float $tax = 0,
        public float $total = 0,
    ) {}

    /**
     * Record a step so the demo can show the order of execution.
     */
    public function log(string $step): void
    {
        $this->steps[] = $step;
    }
}
