# Laravel Pipeline

## What is it
A pipeline passes one object through a list of small classes (pipes). Each pipe does one job, then hands the object to the next pipe. Like a factory conveyor belt.

## How it works
```
Pipeline::send($data)        // object that travels
    ->through([A, B, C])     // ordered pipes
    ->thenReturn();          // result after last pipe
```
Each pipe has `handle($data, Closure $next)`:
- change `$data`, then `return $next($data);` -> go to next pipe
- throw or return early -> stop the pipeline
- code after `$next($data)` runs on the way back (onion model, same as middleware)

## Real example: checkout
Files in `app/Pipelines/Checkout/`:

1. ValidateStock - throws if item out of stock
2. CalculateSubtotal - price x qty
3. ApplyCoupon - SAVE10 / SAVE20
4. AddTax - 18%, final total

Run: `php artisan serve`, open `/pipeline-demo`.

Try:
- `/pipeline-demo?coupon=SAVE20`
- `/pipeline-demo?items[0][name]=keyboard&items[0][price]=50&items[0][qty]=1` (out of stock, 422)

Response `steps` shows pipe execution order.

## Why use it
- each rule in own class, easy to test
- add/remove/reorder a step by editing one array
- same idea Laravel uses for HTTP middleware

Test: `php artisan test --filter=PipelineDemoTest`
