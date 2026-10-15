<?php

namespace App\Http\Controllers;

use App\Pipelines\Checkout\AddTax;
use App\Pipelines\Checkout\ApplyCoupon;
use App\Pipelines\Checkout\CalculateSubtotal;
use App\Pipelines\Checkout\CheckoutData;
use App\Pipelines\Checkout\ValidateStock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use RuntimeException;

class PipelineDemoController extends Controller
{
    /**
     * Run a cart through the checkout pipeline and return the trace.
     */
    public function checkout(Request $request): JsonResponse
    {
        $data = new CheckoutData(
            items: $request->input('items', [
                ['name' => 'laptop', 'price' => 1000, 'qty' => 1],
                ['name' => 'mouse', 'price' => 20, 'qty' => 2],
            ]),
            coupon: $request->input('coupon', 'SAVE10'),
        );

        try {
            $result = Pipeline::send($data)
                ->through([
                    ValidateStock::class,
                    CalculateSubtotal::class,
                    ApplyCoupon::class,
                    AddTax::class,
                ])
                ->thenReturn();
        } catch (RuntimeException $e) {
            return response()->json(['error' => $e->getMessage(), 'steps' => $data->steps], 422);
        }

        return response()->json($result);
    }
}
