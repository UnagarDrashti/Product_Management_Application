<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/products', [
            'name' => 'Test Product',
            'description' => 'A sample product',
            'price' => 99.99,
            'category' => 'Electronics',
            'stock' => 10,
            'image' => 'default.png',
        ]);

        $response->assertStatus(302); // Redirect after create
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
        ]);
    }

    /** @test */
    // public function user_can_update_a_product()
    // {
    //     $user = User::factory()->create();
    //     $product = Product::factory()->create(['name' => 'Old Name']);

    //     $response = $this->actingAs($user)->put("/products/{$product->id}", [
    //         'name' => 'New Name',
    //         'description' => $product->description,
    //         'price' => $product->price,
    //         'category' => $product->category,
    //         'stock' => $product->stock,
    //         'image' => $product->image,
    //     ]);

    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('products', ['name' => 'New Name']);
    // }

    // /** @test */
    // public function user_can_delete_a_product()
    // {
    //     $user = User::factory()->create();
    //     $product = Product::factory()->create();

    //     $response = $this->actingAs($user)->delete("/products/{$product->id}");

    //     $response->assertStatus(302);
    //     $this->assertDatabaseMissing('products', ['id' => $product->id]);
    // }
}
