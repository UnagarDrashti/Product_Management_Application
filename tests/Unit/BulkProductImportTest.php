<?php

namespace Tests\Unit;

use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class BulkProductImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_products_and_assigns_default_image_if_none_provided()
    {
        Queue::fake();

        $data = [
            ['name' => 'Test Product 1', 'description' => 'desc', 'price' => 100, 'category' => 'Electronics', 'stock' => 10, 'image' => null],
            ['name' => 'Test Product 2', 'description' => 'desc', 'price' => 200, 'category' => 'Books', 'stock' => 20, 'image' => 'custom.png'],
        ];

        foreach ($data as $row) {
            Product::create([
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price'],
                'category' => $row['category'],
                'stock' => $row['stock'],
                'image' => $row['image'] ?? 'default.png',
            ]);
        }

        $this->assertDatabaseHas('products', ['name' => 'Test Product 1', 'image' => 'default.png']);
        $this->assertDatabaseHas('products', ['name' => 'Test Product 2', 'image' => 'custom.png']);
    }
}
