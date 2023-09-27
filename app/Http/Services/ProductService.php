<?php

namespace App\Http\Services;

use App\Contracts\ProductContract;
use App\Models\Product;

class ProductService extends BaseService implements ProductContract
{
    public function getProductById($id)
    {
        return Product::where('id',$id)->first();
    }
    public function storeProduct($productDto)
    {
        return Product::create([
            'name' => $productDto->name,
            'description' => $productDto->description,
            'price' => $productDto->price,
            'image_path' => $productDto->image_path,
        ]);
    }

    public function updateProduct($productDto, $product)
    {
        $product->name = $productDto->name;
        $product->description = $productDto->description;
        $product->price = $productDto->price;
        $product->image_path = $productDto->image_path;
        $product->save();

        return $product;
    }
}
