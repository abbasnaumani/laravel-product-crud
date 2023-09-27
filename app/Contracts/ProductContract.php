<?php

namespace App\Contracts;

use App\DTOs\ProductDto;

interface ProductContract
{
    /**
     * @param ProductDto $productDto
     * @return mixed
     */
    public function storeProduct(ProductDto $productDto);
    public function getProductById($id);
    public function updateProduct(ProductDto $productDto, $product);
}
