<?php

namespace Route\Http;

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

class Product
{
    public static function register()
    {
        Route::middleware('auth')->group(function () {
            Route::get('/products', [ProductController::class, 'index'])->name('products.index');
            Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
            Route::post('/products/store', [ProductController::class,'store'])->name('products.store');
            Route::get('/products/{id}', [ProductController::class , 'show'])->name('products.show');
            Route::get('/products/{id}/edit', [ProductController::class , 'edit'])->name('products.edit');
            Route::post('/products/update', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        });
    }
}
