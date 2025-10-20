<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_it_can_display_the_products_index_page(): void
    {
        $product1 = Product::factory()->create(['description' => 'description 1']);
        $product2 = Product::factory()->create(['description' => 'description 2']);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertSee($product1->name)
            ->assertSee('description 1')
            ->assertSee('R$ ' . number_format($product1->price, 2, ',', '.'))
            ->assertSee($product1->stock_quantity);
        $response->assertSee($product2->name)
            ->assertSee('description 2')
            ->assertSee('R$ ' . number_format($product2->price, 2, ',', '.'))
            ->assertSee($product2->stock_quantity);
    }

    public function test_guests_are_redirected_from_index_to_login(): void
    {
        auth()->logout();
        $this->get(route('products.index'))->assertRedirect('/login');
    }

    public function test_it_can_display_the_create_product_page(): void
    {
        $response = $this->get(route('products.create'));
        $response->assertStatus(200);
        $response->assertViewIs('products.create');
        $response->assertSee('Adicionar Novo Produto');
    }

    public function test_it_can_store_a_new_product_with_valid_data(): void
    {
        $product = Product::factory()->make();

        $response = $this->post(route('products.store'), $product->toArray());

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Cadastrado');
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity
        ]);
    }

    public function test_it_fails_to_store_a_new_product_with_invalid_data(): void
    {
        $product = Product::factory()->make(['name' => '']);

        $response = $this->post(route('products.store'), $product->toArray());

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseEmpty('products');
    }

    public function test_it_can_display_the_edit_product_page(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee($product->price)
            ->assertSee($product->stock_quantity);
    }

    public function test_it_can_update_an_existing_product_with_valid_data(): void
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->make();

        $response = $this->put(route('products.update', $product1), $product2->toArray());

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Atualizado');
        $this->assertDatabaseHas('products', [
            'id' => $product1->id,
            'name' => $product2->name,
            'description' => $product2->description,
            'price' => $product2->price,
            'stock_quantity' => $product2->stock_quantity
        ]);
    }

    public function test_it_fails_to_update_a_product_with_a_duplicate_name(): void
    {
        Product::factory()->create(['name' => 'product 1']);
        $product2 = Product::factory()->create(['name' => 'product 2']);

        $response = $this->put(route('products.update', $product2), [
            'name' => 'product 1',
            'price' => 10.00,
            'stock_quantity' => 1,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseHas('products', [
            'name' => 'product 2',
            'description' => $product2->description,
            'price' => $product2->price,
            'stock_quantity' => $product2->stock_quantity
        ]);
    }

    public function test_it_can_display_a_single_product_page(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee('R$ ' . number_format($product->price, 2, ',', '.'))
            ->assertSee($product->stock_quantity);
    }

    public function test_it_can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Deletado');
        $this->assertDatabaseEmpty('products');
    }

    public function test_it_fails_to_update_a_product_with_another_existing_name(): void
    {
        $product1 = Product::factory()->create(['name' => 'name 1']);
        $product2 = Product::factory()->create(['name' => 'name 2']);

        $response = $this->put(route('products.update', $product2), ['name' => $product1->name]);

        $response->assertSessionHasErrors('name');
    }
}