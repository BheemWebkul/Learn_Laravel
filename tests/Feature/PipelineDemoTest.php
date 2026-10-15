<?php

namespace Tests\Feature;

use Tests\TestCase;

class PipelineDemoTest extends TestCase
{
    public function test_pipes_run_in_order_and_compute_total(): void
    {
        $this->getJson('/pipeline-demo')
            ->assertOk()
            ->assertJsonPath('subtotal', 1040)
            ->assertJsonPath('discount', 104)
            ->assertJsonPath('tax', 168.48)
            ->assertJsonPath('total', 1104.48)
            ->assertJsonCount(4, 'steps');
    }

    public function test_out_of_stock_stops_pipeline(): void
    {
        $this->getJson('/pipeline-demo?items[0][name]=keyboard&items[0][price]=50&items[0][qty]=1')
            ->assertStatus(422)
            ->assertJsonPath('error', 'Out of stock: keyboard');
    }
}
