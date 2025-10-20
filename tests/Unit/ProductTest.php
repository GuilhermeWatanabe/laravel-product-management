<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_produto_with_valid_data(): void
    {
        $produto = Product::factory()->create([
            'name' => 'Product name',
            'description' => 'any description',
            'price' => 199.99,
            'stock_quantity' => 50,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $produto->id,
            'name' => 'Product name',
            'description' => 'any description',
            'price' => 199.99,
            'stock_quantity' => 50,
        ]);

        $this->assertDatabaseCount('products', 1);
    }

    public function test_it_can_create_a_produto_with_a_null_description(): void
    {
        Product::factory()->create(['description' => null]);

        $this->assertDatabaseHas('products', ['description' => null]);
        $this->assertDatabaseCount('products', 1);
    }

    public function test_it_can_create_a_produto_with_zero_stock(): void
    {
        Product::factory()->create(['stock_quantity' => 0]);

        $this->assertDatabaseHas('products', ['stock_quantity' => 0]);
    }

    public function test_it_fails_to_create_a_produto_without_a_name(): void
    {
        $this->expectException(QueryException::class);

        Product::factory()->create(['name' => null]);
    }

    public function test_it_fails_to_create_a_produto_with_a_duplicate_name(): void
    {
        $this->expectException(QueryException::class);

        Product::factory()->create(['name' => 'Duplicate Name']);

        Product::factory()->create(['name' => 'Duplicate Name']);
    }

    public function test_it_fails_to_create_a_produto_without_a_price(): void
    {
        $this->expectException(QueryException::class);

        Product::factory()->create(['price' => null]);
    }

    public function test_it_fails_to_create_a_produto_with_a_negative_price(): void
    {
        $this->expectException(QueryException::class);

        Product::factory()->create(['price' => -10.50]);
    }

    public function test_it_fails_to_create_a_produto_without_stock_quantity(): void
    {
        $this->expectException(QueryException::class);

        Product::factory()->create(['stock_quantity' => null]);
    }

    public function test_it_fails_to_create_a_produto_with_negative_stock_quantity(): void
    {
        $this->expectException(QueryException::class);

        Product::factory()->create(['stock_quantity' => -1]);
    }
}
