<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

final class ProductDto extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public string $image_path,
    ) {
    }
}
