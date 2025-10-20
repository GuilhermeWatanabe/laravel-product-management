<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAPIControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_it_denies_access_to_products_for_unauthenticated_users(): void
    {
        $this->getJson('/api/products')->assertStatus(401);
        $this->postJson('/api/products')->assertStatus(401);
    }

    public function test_it_can_list_products_for_an_authenticated_user(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->withToken($this->token)->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_product_with_valid_data(): void
    {
        $product = Product::factory()->make();

        $response = $this->withToken($this->token)->postJson('/api/products', $product->toArray());

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'stock_quantity' => $product['stock_quantity']
        ]);
        $this->assertDatabaseHas('products', [
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'stock_quantity' => $product['stock_quantity']
        ]);
    }

    public function test_it_fails_to_create_a_product_with_invalid_data(): void
    {
        $response = $this->withToken($this->token)->postJson('/api/products', ['name' => '']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function test_it_can_show_a_single_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->withToken($this->token)->getJson('/api/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson(['id' => $product->id, 'name' => $product->name]);
    }

    public function test_it_returns_404_when_showing_a_non_existent_product(): void
    {
        $response = $this->withToken($this->token)->getJson('/api/products/999');

        $response->assertStatus(404);
    }

    public function test_it_can_update_a_product_with_valid_data(): void
    {
        $product = Product::factory()->create();
        $new = [
            'name' => 'any name',
            'price' => 99.99,
            'stock_quantity' => 100
        ];

        $response = $this->withToken($this->token)->putJson('/api/products/' . $product->id, $new);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'any name',
            'description' => $product->description,
            'price' => 99.99,
            'stock_quantity' => 100
        ]);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'name' => 'any name',
            'description' => $product->description,
            'price' => 99.99,
            'stock_quantity' => 100
        ]);
    }

    public function test_it_can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->withToken($this->token)->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(204);
        $this->assertDatabaseCount('products', 0);
    }
}
