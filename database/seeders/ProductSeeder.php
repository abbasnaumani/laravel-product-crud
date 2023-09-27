<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') !== 'production') {
            $products = [
                [
                    'id' => 1,
                    'name' => 'Studio Headphones',
                    'description' => 'Studio Headphones are renowned as the top-quality headphones in the area, known for their exceptional audio quality.',
                    'price' => 80,
                    'image_path' => 'images/products/6514921790c9c.png'
                ],
                [
                    'id' => 2,
                    'name' => 'iPhone 15 pro max cover',
                    'description' => 'iPhone 15 Pro Max: Cutting-edge features, superb camera, immense power.',
                    'price' => 100,
                    'image_path' => 'images/products/6514921790c9c.png'
                ],
                [
                    'id' => 3,
                    'name' => 'iPhone 14 pro max cover',
                    'description' => 'iPhone 14 Pro Max: Cutting-edge features, superb camera, immense power.',
                    'price' => 100,
                    'image_path' => 'images/products/6514921790c9c.png'
                ]
            ];
            foreach ($products as $product) {
                $fillableData = Arr::only($product, Product::getModel()->getFillable());
                Product::query()->updateOrCreate(['id' => $product['id']], $fillableData);
            }
        }
    }
}
