<?php

namespace App\Http\Controllers;

use App\Contracts\ProductContract;
use App\DTOs\ProductDto;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Exception;

class ProductController extends Controller
{
    /**
     * @param ProductContract $productService
     */
    public function __construct(private readonly ProductContract $productService)
    {
    }

    /**
     * Displays All Products
     */
    public function index(): View
    {
        $products = Product::all();

        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Display Product to edit
     */
    public function edit($id): View
    {
        $product = $this->productService->getProductById($id);
        return view('products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Display Product to edit
     */
    public function show($id): View
    {
        $product = $this->productService->getProductById($id);
        return view('products.details', [
            'product' => $product,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProductUpdateRequest $request): RedirectResponse
    {
        try {
            $product = $this->productService->getProductById($request->input('id'));
            $productDto = ProductDto::from([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image_path' => $request->image_path,
            ]);
            $this->productService->updateProduct($productDto, $product);
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['msg' => $e->getMessage()]);
        }

        return Redirect::route('products.index')->with('success', 'Product Update Successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy($id): RedirectResponse
    {
        $product = $this->productService->getProductById($id);
        if (!$product) return Redirect::route('products.index')->with('error', 'Something Went Wrong Please Try Again Later');
        $product->delete();

        return Redirect::route('products.index')->with('success', 'Product Deleted Successfully');
    }

    /**
     * Display view to add product.
     *
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store Product.
     *
     */
    public function store(CreateProductRequest $request): RedirectResponse
    {
        try {
            $productDto = ProductDto::from([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image_path' => $request->image_path,
            ]);
            $this->productService->storeProduct($productDto);
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['msg' => 'Something Went Wrong Please Try Again Later']);
        }

        return Redirect::route('products.index')->with('success', 'Product Created Successfully');
    }
}
